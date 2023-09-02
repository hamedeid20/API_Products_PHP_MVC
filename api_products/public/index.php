<?php 

    namespace API;
    use API\LIB\FrontController;
    
    header("Content-Type: application/json; charset=UTF-8");

    if(!defined('DS')){
        define('DS', DIRECTORY_SEPARATOR);
    }

    require_once '..' . DS . 'app' . DS . 'config' . DS . 'config.php';
    require_once APP_PATH . DS . 'lib' . DS . 'autoload.php';

    $FrontController = new FrontController;
    $FrontController->dispatch();

?>