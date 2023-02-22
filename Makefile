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
