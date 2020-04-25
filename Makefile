.PHONY:

up:
	 docker-compose build
	 docker-compose up -d

permission:
	 dcoker exec  php -i | grep php.ini && echo "extension=swoole.so" >> php.ini  && echo "'extension=inotify.so'" >> php.ini

start:
	docker-compose exec php bin/console swoole:server:run
	docker-compose exec php bin/console swoole:server:reload

composer:
	docker-compose exec php composer install

create-user:
	cd QuickScript && php start.php

crate:
	curl -X POST -H 'Content-type: application/json' http://neo4j:jack@127.0.0.1:7474/db/data/cypher -d '{ "query" : "CREATE (n:Person { name : {name} }) RETURN n", "params" : {"name" : "Andres"}}