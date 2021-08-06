curdir = $(shell pwd)

up:
	docker-compose up -d

up-build:
	docker-compose up -d --build

install:
	cd $(curdir);
	docker-compose exec hgs_web php composer.phar self-update;
	docker-compose exec hgs_web php composer.phar install;
	docker-compose exec hgs_web cp .env.example .env;
	docker-compose exec hgs_web php artisan key:generate;
	cd ../;

down:
	docker-compose down
