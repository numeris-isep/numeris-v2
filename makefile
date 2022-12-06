## Global commands
####################

start:
	docker-compose up -d

start-output:
	docker-compose up

build:
	docker-compose build

status:
	docker-compose ps

start-prod:
	docker-compose -f docker-compose.production.yml up -d --no-deps

build-prod:
	docker-compose -f docker-compose.production.yml build

deploy-prod: build-prod start-prod

start-testing:
	docker-compose -f docker-compose.testing.yml up -d

stop:
	docker-compose stop

down:
	docker-compose down --rmi all -v --remove-orphans

reload: stop start


## Package manager commands
#############################

back-install:
	docker exec -it numeris-back composer install

back-update:
	docker exec -it numeris-back composer update

front-install:
	docker exec -it numeris-front npm install

front-update:
	docker exec -it numeris-front npm update

front-fix-vulnerabilities:
	docker exec -it numeris-front npm audit fix


## Shell commands
###################

shell-back:
	docker exec -it numeris-back bash

shell-front:
	docker exec -it numeris-front bash

shell-sql:
	docker exec -it numeris-mysql bash

tinker:
	docker exec -it numeris-back sh -c 'php artisan tinker'


## Database commands
######################

db-reset:
	docker exec -it numeris-back sh -c 'php artisan migrate:refresh --seed'

migrate:
	docker exec -it numeris-back sh -c 'php artisan migrate'

migrate-prod:
	docker exec -t numeris-back sh -c 'php artisan migrate --force'

db-refresh:
	docker exec -it numeris-back sh -c 'php artisan migrate:refresh'

migrate-rollback:
	docker exec -it numeris-back sh -c 'php artisan migrate:rollback'

db-seed:
	docker exec -it numeris-back sh -c 'php artisan db:seed'


## Test commands
###################

test:
	docker exec -it numeris-back sh -c 'vendor/bin/phpunit'


## Utils commands
###################

log-back:
	docker exec -it numeris-back sh -c 'less +G storage/logs/laravel.log'

config-clear:
	docker exec numeris-back sh -c 'php artisan config:clear'
	docker exec numeris-back sh -c 'php artisan cache:clear'
	docker exec numeris-back sh -c 'php artisan route:clear'

config-cache:
	docker exec numeris-back sh -c 'php artisan route:cache'
	docker exec numeris-back sh -c 'php artisan config:cache'

key-generate:
	docker exec numeris-back sh -c 'php artisan key:generate'

jwt-secret:
	docker exec numeris-back sh -c 'php artisan jwt:secret'
