# humanity_task

### Install
``
composer install
``
### Install with Docker
Quickest way to run docker containers is with docker-compose command, so first, make sure you have docker-compose installed.
```
// Run containers detached in background
docker-compose up -d 

// Log into humanity app container (php v7.3)
docker exec -it humanity_app bash

// Finally run
composer install
```

### Setup
In humanity_task directory, if <b>not exist</b>, 
copy ".env.example" file and rename it to ".env". <br>
Make sure that API_KEY, API_USERNAME, API_PASSWORD are filled.

### Run
If you are using docker environment, by default web server is started on address: <br>
`localhost:80` <br><br>
Otherwise, it depends on your development environment.