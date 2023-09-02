<?php 

    namespace API\Models;

    class DetailModel extends AbstractModel{

        private $id;
        private $detail_title;
        private $detail_description;
        private $product_id;

        protected static $primaryKey = 'id';
        protected static $name_id = 'detail_';
        protected static $table_Name = 'details';
        protected static $table_Schema = array(
            "detail_title" => self::DATA_TYPE_STR,
            "detail_description" => self::DATA_TYPE_STR,
            "product_id" => self::DATA_TYPE_INT
        );

        public function __get($prop){
            return $this->$prop;
        }

        public function setId($id){
            $this->id = $id;
            return $this;
        }

        public function setDetail_title($detail_title){
            $this->detail_title = $detail_title;
            return $this;
        }

        public function setDetail_description($detail_description){
            $this->detail_description = $detail_description;
            return $this;
        }

        public function setProduct_id($product_id){
            $this->product_id = $product_id;
            return $this;
        }
    }

?>