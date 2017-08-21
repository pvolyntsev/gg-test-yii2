# Инструкция по установке приложения GG Test Yii2 #

## Минимальные требования
- PHP 7.0+
- MySQL 5.0+
- [Composer](https://getcomposer.org/download/)


## Установка

```
cd /var/www
git clone https://github.com/pvolyntsev/gg-test-yii2.git
cd gg-test-yii2
composer global require "fxp/composer-asset-plugin:~1.1.4"
composer update
```

## Создание БД
```
DROP DATABASE IF EXISTS `gg_test_yii2`;
CREATE DATABASE IF NOT EXISTS `gg_test_yii2` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON gg_test_yii2.* TO gg_test_yii2_user@localhost IDENTIFIED BY '123456';
```

Параметры базы данных можно установить в файле `config/db.php`
```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=gg_test_yii2',
    'username' => 'gg_test_yii2_user',
    'password' => '123456',
    'charset' => 'utf8',
];
```


#### Миграция таблиц ####
```
cd /var/www/gg_test_yii2
php yii migrate/up
```
