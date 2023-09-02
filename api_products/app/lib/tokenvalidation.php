<?php 

    namespace API\LIB;

    use API\LIB\Database\Database;

    trait TokenValidation{

            public function tokenValidation(){
                $header = getallheaders();
                $Auth = AuthMiddleware::getInstance($header);
                return $Auth->isValid();
            }

    }

?>