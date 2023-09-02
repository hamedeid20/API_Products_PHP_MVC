<?php 

    namespace API\Models;

    class CategoryModel extends AbstractModel{

        private $id;
        private $category_name;
        private $user_id;

        protected static $primaryKey = 'id';
        protected static $name_id = 'category_';
        protected static $table_Name = 'categories';
        protected static $table_Schema = array(
            "category_name" => self::DATA_TYPE_STR,
            "user_id" => self::DATA_TYPE_INT
        );

        public function __get($prop){
            return $this->$prop;
        }
 
        public function setId($id){
            $this->id = $id;
            return $this;
        }

        public function setCategory_name($category_name){
            $this->category_name = $category_name;
            return $this;
        }

        public function setUser_id($user_id){
            $this->user_id = $user_id;
            return $this;
        }
    }

?>