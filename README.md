# Basic login API

## Technologies

- Docker running:
    - Nginx
    - PHP-FPM
    - Composer
    - MySQL
    
- Language: PHP
- Framework: Symfony 4

## Overview

This project uses the following ports:

| Server     | Port |
|------------|------|
| MySQL      | 8989 |
| Nginx      | 8000 |

### Project tree

```sh
.
├── api
│   ├── bin
│   ├── composer.json
│   ├── composer.lock
│   ├── config
│   ├── public
│   ├── src
│   ├── symfony.lock
│   ├── var
│   └── vendor
├── data
│   ├── db
│   ├── nginx
│   └── symfony
├── docker-compose.yml
├── etc
│   ├── nginx
│   └── php
├── Makefile
└── README.md

```

## Run the application

1. Start docker executing: 

    ```sh
    make dev
    ```

2. Stop, restart and rebuild the app executing:

    ```sh
    make nodev
    make restart
    make rebuild
    ```

3. Check the logs executing:

    ```sh
    make logs
    ```

4. Backend base url :

    [http://localhost:8000](http://localhost:8000/)
    
5. First execution:

In order to run the code for the first time, you need to execute the migrations to set up the database: 

    make enter-code && php bin/console doctrine:migrations:migrate
    
## Request

Example of login call:

    curl -X POST \
      'http://localhost:8000/login?XDEBUG_SESSION_START=PHPSTORM' \
      -H 'Content-Type: application/json' \
      -H 'Postman-Token: 59b0d4ce-89ed-4550-9571-25ce1bf8cb67' \
      -H 'cache-control: no-cache' \
      -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' \
      -F email=test@test.com \
      -F password=test

## Response

The response codes are:

| Code     | Message      |
|----------|--------------|
| 200      | OK           |
| 400      | Bad Request  |
| 401      | Unauthorized |

### Response Format

The response format is Json.

### Example of responses

Invalid credentials:

    {
        "email": "Invalid credentials"
    }

Success:

    {
        "token": "very_secret_token"
    }
    
## Test data

    email: test@test.com
    password: test