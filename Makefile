.PHONY:

up:
	 docker-compose build
	 docker-compose up

permission:
	 dcoker exec  php -i | grep php.ini && echo "extension=swoole.so" >> php.ini  && echo "'extension=inotify.so'" >> php.ini

start:
	docker-compose exec php bin/console swoole:server:run

composer:
	docker-compose exec php composer install


