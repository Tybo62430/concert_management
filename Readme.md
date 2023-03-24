# Concert Management

## Après avoir cloné le projet :

`composer install`

## Éditer le .env et ajouter/modifier la ligne de configuration MySql :

DATABASE_URL="mysql:// **user**:**password**@127.0.0.1:3306/**concertmanagement**?serverVersion=8&charset=utf8mb4"

## Créer la base de données :

`bin/console d:d:c`

## Effectuer les migrations || dumper le schéma:

`bin/console doctrine:migrations:migrate` || `bin/console d:s:u --force`

## Si vous voulez générer de fausses données :

`bin/console doctrine:fixtures:load`
