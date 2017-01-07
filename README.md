# Yii2 Lookup Table Module
Yii2 module providing various interfaces for dealing the repetitive tasks of managing lookup tables, i.e. individual database tables having only an auto-incremented primary key and a unique label.

The contents of this package include:

* A graphical user interface providing CRUD operations for lookup table records
* A command line interface providing CRUD operations and bulk import for lookup table records
* A database migration helper to manage creation and dropping of lookup tables 

## Installation

### Install Using Composer

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require humanized/yii2-lookup "*"
```

or add

```
"humanized/yii2-lookup": "*"
```

to the ```require``` section of your `composer.json` file.



### Edit Configuration File

To enable the graphical user interface facilities, add the following lines to the application configuration file:

```php
'modules' => [
    'lookup' => [
        'class' => 'humanized\lookup\Module',
    ],
],
```



To enable command line interface and migration facilities, add the following lines to the console configuration file:

```php
'modules' => [
    'lookup' => [
        'class' => 'humanized\lookup\Module',
    ],
],
```
