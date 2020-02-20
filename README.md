# Numeris-v2

[![Build Status](https://travis-ci.org/2Seg/numeris-v2.svg?branch=master)](https://travis-ci.org/2Seg/numeris-v2.svg?branch=master)

> Created and maintened by [2Seg](https://github.com/2Seg)

**Home of the new website of Numeris**

This repository contains the code of the new website of Numéris for students of ISEP engineering school.

***Url:** [https://numeris-isep.fr](https://numeris-isep.fr)*

## Stack

- [Laravel](https://laravel.com/docs/5.8)
- [Angular](https://v7.angular.io/docs)
- [Semantic UI](https://semantic-ui.com/introduction/getting-started.html) + [ng2-semantic-ui](https://edcarroll.github.io/ng2-semantic-ui/#/getting-started)
- [Docker](https://docs.docker.com/)
- [Travis CI](https://travis-ci.org/2Seg/numeris-v2)
- [PHPUnit](https://phpunit.readthedocs.io/en/7.0/)

## Getting started

Here are the instructions to install the project locally on Linux or Mac. For Windows, please use a linux terminal emulator if you want to be able to run `make` commands which is recommended.
> **Note:** Only collaborators can contribute to this project.

## Prerequisites

Before we get started, you need to install :
- `docker`
- `docker-compose`

## Installation

1. Clone this repository in the folder of your choice

2. In the root folder of the project, copy the content of `.env.example` file in a new `.env` file and set it up like so:
```
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=numeris
DB_USERNAME=root
DB_PASSWORD=

MYSQL_ROOT_PASSWORD=root

BACK_PORT=8080
FRONT_PORT=4200
```

3. Then move to `back` folder and copy the content of the other `.env.example` file in another new `.env` file and set it up like so:
```
APP_NAME="Numéris ISEP"
APP_NAME="Numéris ISEP"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=https://localhost:8080
FRONT_APP_URL=http://localhost:4200

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=numeris
DB_USERNAME=root
DB_PASSWORD=

DB_HOST_TESTING=127.0.0.1
DB_PORT_TESTING=3306
DB_DATABASE_TESTING=numeris_testing
DB_USERNAME_TESTING=root
DB_PASSWORD_TESTING=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=sav.numeris@gmail.com
MAIL_FROM_NAME="Numéris ISEP"

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

JWT_SECRET=

GOOGLE_RECAPTCHA_KEY=6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI
GOOGLE_RECAPTCHA_SECRET=LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe
```

4. Launch the command `make start` from the `makefile` in the root folder

5. Generate the application key with `make key-generate`

6. Generate the jwt secret with `make jwt-secret`

7. Create and seed the database with `make db-reset`

**Et voilà, you are good to go!**