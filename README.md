# Приложение GG Test Yii2 #

Добавление возможности бесконечного расширения списка атрибутов у хранимых сущностей

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
composer install
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


## Загрузка моделей и начальных данных в СУБД
```
cd /var/www/gg-test-yii2
php yii migrate/up
```


# Тесты

Реализованы только модульные тесты

```
vendor/bin/codecept run unit
```

```
Codeception PHP Testing Framework v2.3.5
Powered by PHPUnit 6.2.4 by Sebastian Bergmann and contributors.

Unit Tests (7) ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
✔ PageEAVTes: Page by id (0.51s)
✔ PageEAVTes: Read extra attribute (0.11s)
✔ PageEAVTes: Write extra attribute (0.05s)
✔ PageEAVTes: Save extra attributes (0.25s)
✔ PageEAVTes: Remove extra attribute (0.09s)
✔ PageEAVTes: New entity with attributes (0.11s)
✔ PageEAVTes: Remove attributes when delete entity (0.09s)
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


Time: 5.18 seconds, Memory: 14.00MB

OK (7 tests, 30 assertions)
```

# Использование

Используется только для хранимых классов, которые наследуюются от ActiveRecord.

Для включения такой возможности необходимо указать базовый класс `\app\library\eav\BaseActiveRecord`

## Пример подключения:

```sql
CREATE TABLE `shop_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8
```

```php
<?php

class ShopItem extends \app\library\eav\BaseActiveRecord
{
    public static function tableName()
    {
        return 'shop_item';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
```

## Пример использования

```php
<?php

$shopItem = new ShopItem; // или ShopItem::findOne(<id>)
$shopItem->name = 'Car'; // обращение к свойству name, хранящемуся в таблице `shop_item`
$shopItem->color = 'red'; // обращение к дополнительному свойству
unset($shopItem->color); // удаление дополнительного свойства
```