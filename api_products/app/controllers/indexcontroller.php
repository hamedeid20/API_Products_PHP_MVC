<?php 

    namespace API\Controllers;
    use API\Controllers\AbstractController;

    class IndexController extends AbstractController{

        public function defaultAction(){
            $this->_view();
        }
    }
?>