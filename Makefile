test:
	./bin/phpunit

start:
	symfony server:start

stop:
	symfony server:stop

migrate:
	./bin/console --no-interaction doctrine:migration:migrate

migrate.test:
	./bin/console --no-interaction doctrine:migration:migrate --env=test

diff:
	./bin/console --no-interaction doctrine:migration:diff

load:
	./bin/console --no-interaction doctrine:fixtures:load --purge-with-truncate

migrate.update: diff migrate migrate.test

database.drop:
	./bin/console doctrine:database:drop --force

database.create:
	./bin/console doctrine:database:create

database.drop.test:
	./bin/console doctrine:database:drop --force --env=test

database.create.test:
	./bin/console doctrine:database:create --env=test
