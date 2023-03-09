
## Installation

- ```composer install``` : installe les dépendances PHP
- ```yarn install``` :installe les dépendances PHP
- ```cp .env.example .env``` : initialiser le .env

Accéder à mysql et exécuter ```CREATE DATABASE account_management_system;```

Après avoir ajouté un mot de passe à la variable d'environnement "ADMIN_PASSWORD" vous pouvez exécuter les migrations et les seeders
```php artisan migrate --seed``` : un utilisateur avec le rôle admin sera créé


## Lancer l'application
- ```yarn dev``` : compile le code source Javascript
- ```php artisan serve``` : lance le serveur

### Laravel
- [Telescope](https://laravel.com/docs/10.x/telescope) : Utilisé en environnement de développement pour aider au debug.
