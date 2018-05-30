# Jetbrains TeamCity environment

Deploys production-ready TeamCity to your machine using docker.

## Pre-requisites
* Docker
* `docker-compose`

## How to run
1. `cd compose/`
2. Modify environment variables at `.env` to feed your needs
3. `$ docker-compose -f core_images.yml build && docker-compose -f base_images.yml build && docker-compose -f project_images.yml build` - Build core/base/project images.
4. cd ./ci/
5. `$ cp .env.example .env`
6.  Modify environment variables at `.env` to feed your needs
7. a) `$ docker-compose -f general.yml -f teamcity.yml -f teamcity_volumes.yml -f proxy_teamcity.yml up -d` - if you only need a teamcity
   b) `$ docker-compose -f general.yml -f teamcity.yml -f teamcity_volumes.yml -f proxy.yml up -d -f webhook.yml` - if you need all
   c) `$ docker-compose -f general.yml -f proxy_webhook.yml up -d -f webhook.yml` - if you only need a webhook
## Thanks
@Protopopys for helping me. 

## License
MIT.
