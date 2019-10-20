## Legal Entity Management API
### API Documentation

- Refer to "Legal Entity Management API.pdf" file for information about resources, uri and parameters.  
- You can also import the file "Legal Entity Management    API.postman_collection.json" import postman tool to see all resources    available

   	
### Instructions to run application inside docker
-  Install docker and docker-compose	 	
-  cd docker [go to docker folder given in zip] 	
-  Update the absolute path of legal-entity-api(/Users/venkatma/code/legal-entity-api) with new location on your host in docker-compose.yml
-  docker-compose up
-  docker exec -it docker_php-apache_1 bash
-  php artisan migrate
-  php artisan db:seed --class=CountriesTableSeeder
-  php artisan queue:table
-  php artisan migrate

### Basic functionality accomplished

- Created entity with name, country and status
- Created job for successful validation of a resource
- Updated entity with one or more fields
- Logged modificiation history while Update entity
- Do not update unvalidated entity while Update entity
- Retrieve​d ​entity listing​, search by status and validation
- Retrieve​d ​entity by LEI fetching history link along and fetch by version pararmeter
	
### Technical Implementation	
- Created laravel app with composer
- Created migrations for entity, country and history with database design planned(migrate)
- Created models with relationships like one-one and one-many
- Created service for LEI generation
- Created repository and included models to do CRUD here
- Created routes and controller to buit the RESTful API
- Overall flow

		    Routes(api.php) --> Controller(LegalEntityController) --> Service(LegalEntityGenerateUniqueService)

			Routes(api.php) --> Controller(LegalEntityController) --> Repository(LegalEntityrepository) --> Models with relationships(legalEntity, Country and legalEntityHistory)  --> Database

			Database design planned --> migrations & seeders --> php artisan migrate
