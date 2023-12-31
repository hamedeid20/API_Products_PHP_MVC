<?php 

    if(!defined('DS')){
        define('DS', DIRECTORY_SEPARATOR);
    }

    define('APP_PATH', dirname(realpath(__FILE__)) . DS . '..' . DS);
    define('VIEWS_PATH', APP_PATH . DS . 'views' . DS);
    define('UPLOAD_PATH', dirname(realpath(__FILE__)) . DS . '..' . DS . '..' . DS . 'public' . DS . 'uploads' . DS);
    
    defined('DATABASE_HOST_NAME')       ? null : define('DATABASE_HOST_NAME', 'localhost');
    defined('DATABASE_USER_NAME')       ? null : define('DATABASE_USER_NAME', 'root');
    defined('DATABASE_PASSWORD')        ? null : define('DATABASE_PASSWORD', '');
    defined('DATABASE_DB_NAME')         ? null : define('DATABASE_DB_NAME', 'api_product');
    defined('DATABASE_PORT_NUMBER')     ? null : define('DATABASE_PORT_NUMBER', 3306);
    defined('DATABASE_CONN_DRIVER')     ? null : define('DATABASE_CONN_DRIVER', 1);

    defined('TIME_ZONE')                ? null : define('TIME_ZONE', 'Asia/Baghdad');

?>