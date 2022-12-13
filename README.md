[![Deploy production](https://github.com/numeris-isep/numeris-v2/actions/workflows/prod.yml/badge.svg?branch=master)](https://github.com/numeris-isep/numeris-v2/actions/workflows/prod.yml)
[![Deploy staging](https://github.com/numeris-isep/numeris-v2/actions/workflows/staging.yml/badge.svg?branch=staging)](https://github.com/numeris-isep/numeris-v2/actions/workflows/staging.yml)
[![Test docker build](https://github.com/numeris-isep/numeris-v2/actions/workflows/test.yml/badge.svg)](https://github.com/numeris-isep/numeris-v2/actions/workflows/test.yml)

# Numeris-v2

<!-- [![Build Status](https://travis-ci.com/2Seg/numeris-v2.svg?branch=master)](https://travis-ci.com/2Seg/numeris-v2) -->

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

Here are the instructions to install the project locally on Linux or Mac. For Windows users, please consider using a linux terminal emulator if you want to be able to run `make` commands which is recommended.
> **Note:** Only collaborators can contribute to this project.

## Prerequisites

Before we get started, you need to install :
- `docker`
- `docker-compose`

## Installation

1. Clone this repository in the folder of your choice

2. In the root folder of the project, copy the content of `.env.example` file in a new `.env` file and set up the environment variables as you like.

3. Then move to `back` folder and copy the content of the other `.env.example` file in another new `.env` file and set up the environment variables as you like.

4. Launch the command `make start` from the `makefile` in the root folder

5. Generate the application key with `make key-generate`

6. Generate the jwt secret with `make jwt-secret`

7. Create and seed the database with `make db-reset`

**Et voilà, you're good to go!**
