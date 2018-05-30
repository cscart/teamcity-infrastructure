# Jetbrains TeamCity environment

Deploys production-ready TeamCity to your machine using docker.
 
## Webhook CI Proxy

Serves as a middleware for [TeamCity Commit Hooks Plugin](https://github.com/JetBrains/teamcity-commit-hooks).

Listens for GitHub webhook payload, fetches pull request status via GitHub API and then re-sends webhook payload to TeamCity itself.

Pull requests prefetch is required to update PR's merge branch and get latest commits when checking VCS roots for changes.
(see https://youtrack.jetbrains.com/issue/TW-53108 for details).

When installing webhook on your repo, you'll have to go and manually alter the Payload URL to point to the middleware.

Example:

* TeamCity is installed at `http://teamcity.example.com`.
* Webhook CI Proxy is installed at `http://webhook.teamcity.example.com`.
* Payload URL is `http://teamcity.example.com/app/hooks/github/unique-hook-hash`.
* Payload URL must be `http://webhook.teamcity.example.com/app/hooks/github/unique-hook-hash`.

## Pre-requisites

* Docker
* `docker-compose`

## How to build and run

1. `$cd compose/`

1. Modify environment variables at `.env` to feed your needs

1. Build images:
    ```
    $ docker-compose -f core_images.yml build && docker-compose -f base_images.yml build && docker-compose -f project_images.yml build
    ```

1. `$cd compose/ci/`

1. `$ cp .env.dist .env`

1.  Modify environment variables at `.env` to feed your needs

1. Run it:

    ###### Teamcity only: 
    ```
    $ docker-compose -f general.yml -f teamcity.yml -f teamcity_volumes.yml -f proxy_teamcity.yml up -d
    ```
   
    ###### Webhook only: 
    ```
    $ docker-compose -f general.yml -f proxy_webhook.yml -f webhook.yml up -d
    ```
   
    ###### Everything: 
    ```
    $ docker-compose -f general.yml -f teamcity.yml -f teamcity_volumes.yml -f proxy.yml -f webhook.yml up -d
    ``` 

## How to update Webhook CI Proxy

1. `$ cd images/project_images/webhook/webhook`

1. `$ cp config.php.dist config.php`

1. Modify the `config.php`:
    
    * Specify TeamCity URL instead of `${CI_URL}`.
    
        URL must contain schema, domain and path, e.g. `http://teamcity.example.com`.
         
    * Specify GitHub access token instead of `${GITHUB_ACCESS_TOKEN}`. 
        
        Obtain your token on [https://github.com/settings/tokens](https://github.com/settings/tokens).

1. `$ cd compose/`

1. Build image: 
    ```
    $ docker-compose -f project_images.yml build
    ```

1. `$ cd compose/ci/`

1. Run it: see [How to run](#webhook-only) above.

## Thanks

@Protopopys for helping me. 

## License
MIT.
