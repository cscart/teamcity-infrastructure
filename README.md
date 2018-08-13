# Jetbrains TeamCity environment

Deploys production-ready TeamCity to your machine using docker.
 
## Webhook CI Proxy

Serves as a middleware for [TeamCity Commit Hooks Plugin](https://github.com/JetBrains/teamcity-commit-hooks).

Listens for GitHub webhook payload, fetches pull request status via GitHub API and then re-sends webhook payload to TeamCity itself.

Pull requests prefetch is required to update PR's merge branch and get latest commits when checking VCS roots for changes.
(see https://youtrack.jetbrains.com/issue/TW-53108 for details).

## Pre-requisites

* Docker
* `docker-compose`

## How to build and run

1. `$ cd compose/`

1. Modify environment variables at `.env` to feed your needs

1. Build images:
    ```
    $ docker-compose build
    ```

1. `$ cd compose/ci/`

1. `$ cp .env.dist .env`

1.  Modify environment variables at `.env` to feed your needs

1. Run it:

    ###### Teamcity only with selfsinged SSL
    ```
    $ docker-compose -f general.yml -f teamcity.yml -f teamcity_volumes.yml -f proxy_teamcity_local.yml up -d
    ```
   
    ###### Teamcity and Webhook CI Proxy with selfsinged SSL
    ```
    $ docker-compose -f general.yml -f teamcity.yml -f teamcity_volumes.yml -f webhook.yml -f proxy_all_local.yml up -d
    ``` 

    ###### Teamcity only with SSL (acme.sh)
    ```
    $ docker-compose -f general.yml -f teamcity.yml -f teamcity_volumes.yml -f proxy_teamcity.yml up -d
    ```
   
    ###### Teamcity and Webhook CI Proxy with SSL (acme.sh)
    ```
    $ docker-compose -f general.yml -f teamcity.yml -f teamcity_volumes.yml -f webhook.yml -f proxy_all.yml up -d
    ``` 

## How to update Webhook CI Proxy

1. `$ cd images/project_images/webhook/webhook`

1. `$ cp config.php.dist config.php`

1. Modify the `config.php`:
    
    * Specify GitHub access token instead of `${GITHUB_ACCESS_TOKEN}`. 
        
        Obtain your token on [https://github.com/settings/tokens](https://github.com/settings/tokens).

1. `$ cd compose/`

1. Build image: 
    ```
    $ docker-compose -f base_images.yml build && docker-compose -f project_images.yml build
    ```

1. `$ cd compose/ci/`

1. Run it: see [How to build and run :: Teamcity and Webhook CI Proxy](#teamcity-and-webhook-ci-proxy).

## Thanks

@Protopopys for helping me. 

## License
MIT.
