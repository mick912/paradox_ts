Requirements

docker-compose

Install
 - clone the project
 - cd to the project`s dir
 - docker-compose build
 - docker-compose up -d #run this command 2 times
 - open the link http://localhost:8010

Structure:

* /src/api - API source code
* /src/front - front-end source code

API files and directories structure:
* /App/Controller - Controllers
* /App/Filter - Ordering, keyword search
* /App/Migrations - DB migrations
* /App/Models - models
* /App/Seed - seeders
* /App/Serializer - response serializers
* /App/settings - API settings


* /bin/app - CLI commands
* /bin/Core - core dependencies such as router, request, response etc.


