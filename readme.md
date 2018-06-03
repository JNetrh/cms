[![forthebadge](https://forthebadge.com/images/badges/built-with-love.svg)](https://forthebadge.com)
[![forthebadge](https://forthebadge.com/images/badges/fuck-it-ship-it.svg)](https://forthebadge.com)
[![forthebadge](https://forthebadge.com/images/badges/its-not-a-lie-if-you-believe-it.svg)](https://forthebadge.com)

BLOCKY CMS
=================

One page based CMS powered by [Nette](https://nette.org) framework


Requirements
------------

PHP 5.6 or higher.

MariaDB


Installation
------------

There is no need to install anything. Package contains all dependencies. Simply upload all files
to the web hosting and processed to URL given. You will be redirected to the installation 
page.


Make directories `temp/` and `log/` writable.


Web Server Setup
----------------

The simplest way to get started is to start the built-in PHP server in the root directory of your project:

	php -S localhost:8000 -t www

Then visit `http://localhost:8000` in your browser to see the welcome page.

For Apache or Nginx, setup a virtual host to point to the `www/` directory of the project and you
should be ready to go.

**It is CRITICAL that whole `app/`, `log/` and `temp/` directories are not accessible directly
via a web browser. See [security warning](https://nette.org/security-warning).**

For a database connection on localhost you can use Xampp or MAMP that run Maria DB. sql.sql file can be found in cms/www/sql.sql.
It contains all database configuration. 

Notice: Composer PHP version
----------------------------
This project forces `PHP 5.6` as your PHP version for Composer packages. If you have newer version on production you should change it in `composer.json`.
```json
"config": {
	"platform": {
		"php": "7.0"
	}
}
```
