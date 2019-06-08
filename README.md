# Guestbook

## Installation using Composer
### Install dependencies:
```bash
$ composer install
```
### Configure database connection:
Change params for database connection in: `\guestbook\module\Guestbook\config\module.config.php`

### Use migration commands below to create table from Guestbook Entry entity:
#### 
The first command calculates the difference between your database and the migration, the second command performs the migration.
### Linux:
```bash
$ php vendor/doctrine/doctrine-module/bin/doctrine-module.php migrations:diff
```
```bash
$ php vendor/doctrine/doctrine-module/bin/doctrine-module.php migrations:migrate
```

### Windows:
```bash
$ php vendor\doctrine\doctrine-module\bin\doctrine-module.php migrations:diff
```
```bash
$ php vendor\doctrine\doctrine-module\bin\doctrine-module.php migrations:migrate
```

## Test application in browser.
