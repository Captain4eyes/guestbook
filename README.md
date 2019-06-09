# Guestbook

### 1. Install dependencies:
```bash
$ composer install
```
### 2. Create directories `data/uploads` and `data/uploads/thumbs` for future uploaded images.

### 3. Configure database connection in: `module/Guestbook/config/module.config.php`

### 4. Use migration commands below to create table from Guestbook Entry entity:
#### 
The first command calculates the difference between your database and the migration, the second command performs the migration.
#### Linux:
```bash
$ php vendor/doctrine/doctrine-module/bin/doctrine-module.php migrations:diff
```
```bash
$ php vendor/doctrine/doctrine-module/bin/doctrine-module.php migrations:migrate
```

#### Windows:
```bash
$ php vendor\doctrine\doctrine-module\bin\doctrine-module.php migrations:diff
```
```bash
$ php vendor\doctrine\doctrine-module\bin\doctrine-module.php migrations:migrate
```

## 5. Test application in browser.
