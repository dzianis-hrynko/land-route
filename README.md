# Backend Developer Test #

Your task is to create a simple service in PHP using the framework of your choice (Symfony is preferred), 
that is able to calculate any possible land route from one country to another. 
The objective is to take a list of country data in JSON format and calculate the route 
by utilizing individual countries' border information.

### Specifications ###

* PHP using framework of your choice (Symfony is preferred)
* Data link: https://raw.githubusercontent.com/mledoze/countries/master/countries.json
* The application exposes REST endpoint /routing/{origin}/{destination} that returns a list of border crossings to get from origin to destination
* Single route is returned if the journey is possible
* Algorithm needs to be efficient
* If there is no land crossing, the endpoint returns HTTP 400
* Countries are identified by cca3 field in country data
* HTTP request sample (land route from Czech Republic to Italy): GET /routing/CZE/ITA HTTP/1.0 :
```json
{ 
"route": ["CZE", "AUT", "ITA"] 
} 
```

### Instruction ###
#### For using the application ####
1. Install Docker and docker-compose on your local environment
2. Create .env file
```bash
cp .env.example .env
```
3. Run to build an image
```bash
docker-compose -f docker-compose.roadrunner.yml build
```
4. Run to up a container and wait till it runs fully. It can take time to run neo4j container
```bash
docker-compose -f docker-compose.roadrunner.yml up --remove-orphans
```
5. Request an endpoint to get a route. Notice that you have to provide correct 3-letters country code instead of
{origin} and {destination}
curl --location --request GET 'http://127.0.0.1:8015/routing/{origin}/{destination}'
Or you can user Postman or Insomnia to request:
GET http://127.0.0.1:8015/routing/CZE/ITA
Example
```bash
curl --location --request GET 'http://127.0.0.1:8015/routing/CZE/ITA'
```

#### For developing and testing the application ####

Run commands to build image and up containers
```bash
docker build . -f Dockerfile --tag land-route:dev
```
Only for development. Run to install packages locally
```bash
docker run --rm -w /application -v $(pwd):/application land-route:dev composer install
```

### To check syntax run:
```bash
docker run --rm -w /application -v $(pwd):/application land-route:dev vendor/bin/phpcs --basepath=/application --standard=/application/.phpcs.xml --report-full src   
```

### To run statical analyze run:
```bash
docker run --rm -w /application -v $(pwd):/application land-route:dev vendor/bin/phpstan analyze --memory-limit 1G -c phpstan.ci.neon      
```

Run unit test
```bash
docker run --rm -w /application -v $(pwd):/application land-route:dev vendor/bin/phpspec run 
```

To-Do Find a way how to get access from inside container to http://localhost
```bash
docker run --rm -w /application -v $(pwd):/application land-route:dev vendor/bin/behat 
```

Till with previous point solution has not found, to run feature tests do:
1. Install composer
2. 
```bash
composer install
```
3. 
```bash
vendor/bin/behat 
```
