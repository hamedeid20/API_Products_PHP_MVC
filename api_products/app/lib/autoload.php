<?php 

    namespace API\LIB;

    class Autoload{

        public static function autoload($className){
            
            $className = str_replace('API' , '', $className); 
            $className = strtolower($className);
            $className = $className . '.php';
            
            if(file_exists(APP_PATH . $className)){
                require_once APP_PATH . $className;
            }

        }

    }
    

    spl_autoload_register( __NAMESPACE__ . '\Autoload::autoload');

?>