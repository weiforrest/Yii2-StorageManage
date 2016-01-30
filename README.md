Yii2-StorageManage
============================
This is a storage management system what is base on Yii-base. 

FEATURES:
-------------
USER Management with Yii2-user module.
Customer Management
Delivery Management
Stock-In Management
Collection Management
Product Management
Account Management

REQUIREMENTS
------------
PHP 5.4.0 Or Newer.
Yii2

INSTALLATION
------------
If you want install this respostory, you could use these steps.

* install Yii2-base.
* Git this repository in Yii-base root directory.
* Create the Database with create.sql
* use the composer install the [Yii2-user](https://github.com/amnah/yii2-user), i had wrote the require in composer.json, so you just run composer install.
* run the Yii2-user migrate command : ```php yii migrate --migrationPath=@vendor/amnah/yii2-user/migrations```
* login with ```neo\neo```(change it)
* set the database to you configure.

ISSUES
-------
If you have any question, you can [email me](mailto://weiforrest@gmail.com).
Thanks!
