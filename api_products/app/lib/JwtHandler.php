<?php

    namespace API\LIB;
    require "composer/vendor/autoload.php";
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    class JwtHandler{

        protected $jwt_secrect;
        protected $token;
        protected $issuedAt;
        protected $expire;
        protected $jwt;

        public function __construct(){
            date_default_timezone_set("Asia/Baghdad");
            $this->issuedAt = time();
            // 3600 = 1hr
            // 31536000 = 1 year
            $this->expire = $this->issuedAt + 31536000;
            $this->jwt_secrect = "123456789";
        }

        public function jwtEncodeData($iss, $data){
            $this->token = array(

                "iss" => $iss,
                "aud" => $iss,

                "iat" => $this->issuedAt,
                "exp" => $this->expire,

                "data" => $data
            );
            $this->jwt = JWT::encode($this->token, $this->jwt_secrect, "HS256");
            return $this->jwt;
        }

        public function jwtDecodeData($jwt_token){ 
            try{
                // $decode =  JWT::decode($jwt_token, $this->jwt_secrect, array('HS256'));
                $decode = JWT::decode($jwt_token, new Key($this->jwt_secrect, 'HS256'));
                return[
                    "data" => $decode->data
                ];
            }catch(\Exception $e){
                return[
                    "message" => $e->getMessage()
                ];
            }
        }


    }
    

?>