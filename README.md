# SlimPHP & Eloquent Starter

## Installation
**Clone this repo then run `composer update` then add a config.php file with the definitions below**

## config.php
**You must include the following definitions in a config.php file**

```
session_start();

// Environment
define('DEV', 1);

// Database Credentials
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'database_name');
```

## PHP Version Requirement
**This project supports PHP 5.3.3 & above**

## Routes
**SlimPHP Routes are defined in index.php and are designed to pull data using Eloquent models and return JSON to front-end clients**

## Resources
**Resource classes are defined in Classes.php as extensions of the Eloquent "Model"**

## Authentication
**Auth.php is a scaffold for adding authentication middleware to your Slim Routes**
