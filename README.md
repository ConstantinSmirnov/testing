php bin/console doctrine:schema:validate
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixture:load --env=test 