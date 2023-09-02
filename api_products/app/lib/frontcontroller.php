<?php 

    namespace API\LIB;

    class FrontController{

        const NOT_FOUND_ACTION = "NotFoundAction";
        const NOT_FOUND_CONTROLLER = "API\Controller\\NotFoundController";
        private $_controller = 'index';
        private $_action = 'default';
        private $_params = array();

        public function __construct(){
            $this->_parseUrl();
        }

        public function _parseUrl(){
            $url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 5);

            // if($url[2] != "uploads"){
                if(isset($url[2]) && $url[2] != ''):
                    $this->_controller = $url[2];
                endif;
                if(isset($url[3]) && $url[3] != ''):
                    $this->_action = $url[3];
                endif;
                if(isset($url[4]) && $url[4] != ''):
                    $this->_params = explode('/' , $url[4]);
                endif;
            // }
        }

        public function dispatch(){
            $controllerClassName = "API\Controllers\\" . ucfirst($this->_controller) . "Controller";
            $actionName = $this->_action . "Action";
            if(!class_exists($controllerClassName)):
                $controllerClassName = self::NOT_FOUND_CONTROLLER;
                echo json_encode([
                    "message" => $controllerClassName
                ]);
                exit;
            endif;
            $controller = new $controllerClassName();
            if(!method_exists($controller,$actionName)):
                $action = $this->_action = $actionName = self::NOT_FOUND_ACTION;
                echo json_encode([
                    "message" => $action
                ]);
                exit;
            endif;

            $controller->set_controller($this->_controller);
            $controller->set_action($this->_action);
            $controller->set_params($this->_params);
            $controller->$actionName();
        }

    }


?>