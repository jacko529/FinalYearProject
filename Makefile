.PHONY:

up:
	 docker-compose build
	 docker-compose run composer composer install
	 docker-compose run php ./artisan key:generate --ansi
	 docker-compose up

permission:
	 docker-compose exec php bash -c 'chmod -R 777 /var/www/html/storage/'
