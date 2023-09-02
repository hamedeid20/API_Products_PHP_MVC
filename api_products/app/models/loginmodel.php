<?php 

    namespace API\Models;

    class LoginModel extends AbstractModel{
        private $email;

        protected static $table_Name = 'users';
        protected static $table_Schema = array(
            "email" => self::DATA_TYPE_STR
        );

        public function __get($prop){
            return $this->$prop;
        } 
        
        public function setEmail($email){
            $this->email = $email;
            return $this;
        }

        
    }

?>