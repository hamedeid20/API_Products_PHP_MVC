<?php 

    namespace API\Models;

    class RegisterModel extends AbstractModel{
        private $user_name;
        private $email;
        private $password;

        protected static $table_Name = 'users';
        protected static $table_Schema = array(
            "user_name" => self::DATA_TYPE_STR,
            "email"     => self::DATA_TYPE_STR,
            "password"  => self::DATA_TYPE_STR
        );
        protected static $primaryKey = 'id';

        public function __get($prop){
            return $this->$prop;
        }
        
        public function setUserName($name){
            $this->user_name = $name;
            return $this;
        }
        
        public function setEmail($email){
            $this->email = $email;
            return $this;
        }
        
        public function setPassword($password){
            $this->password = $password;
            return $this;
        }
    }

?>