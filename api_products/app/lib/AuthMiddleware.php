<?php 

    namespace API\LIB;
    use API\LIB\JwtHandler;

    require __DIR__ . "/JwtHandler.php";

    class AuthMiddleware extends JwtHandler{
        protected $headers;
        protected $token;
        private static $instance = null;

        private function __construct($headers){
            parent::__construct();
            $this->headers = $headers;
        }

        public function isValid(){
            if (array_key_exists('Authorization', $this->headers) && preg_match('/Bearer\s(\S+)/', $this->headers['Authorization'], $matches)) {

                $data = $this->jwtDecodeData($matches[1]);

                if(
                    isset($data['data']->user_id)
                ) :
                    return[
                        "success" => 1,
                        "status" => "Token is valid",
                        "user" => $data['data']->user_id
                    ];
                else :
                    return[
                        "success" => 0,
                        "message" => $data['message']
                    ];
                endif;
                
            }else{
                return[
                    "success" => 0,
                    "message" => "Token not found in request"
                ];
            }
        }

        public static function getInstance($header){
            if(!self::$instance){
                self::$instance = new AuthMiddleware($header);
            }
            return self::$instance;
        }

    }


?>