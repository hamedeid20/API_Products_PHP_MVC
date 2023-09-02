<?php 

    namespace API\Controllers;

    use API\LIB\FrontController;

    class AbstractController{

        protected $_controller;
        protected $_action;
        protected $_params;
        protected $_data = [];

        public function get_controller(){
            return $this->_controller;
        }

        public function set_controller($_controller){
            $this->_controller = $_controller;
            return $this;
        }

        public function get_action(){
            return $this->_action;
        }

        public function set_action($_action){
            $this->_action = $_action;
            return $this;
        }

        public function get_params(){
            return $this->_params;
        }

        public function set_params($_params){
            $this->_params = $_params;
            return $this;
        }

        public function _view(){
            if($this->_action == FrontController::NOT_FOUND_ACTION){
                require_once VIEWS_PATH . 'notfound' . DS . 'notfound.view.php';
            }else{
                $view = VIEWS_PATH .  $this->_controller . DS . $this->_action . '.view.php';
                if(file_exists($view)):
                    extract($this->_data);
                    require_once VIEWS_PATH . $this->_controller . DS . $this->_action . '.view.php';
                else:
                    require_once VIEWS_PATH . 'notfound' . DS . 'noview.view.php';
                endif;
            }
        }
    }

?>