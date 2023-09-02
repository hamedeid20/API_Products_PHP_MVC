<?php 

    namespace API\Models;

    class ImgModel extends AbstractModel{
        private $id;
        private $path_img;
        private $product_id;

        protected static $primaryKey = 'id';
        protected static $name_id = 'img_';
        protected static $table_Name = 'product_imgs';
        protected static $table_Schema = array(
            "path_img" => self::DATA_TYPE_STR,
            "product_id" => self::DATA_TYPE_INT
        );

        public function __get($prop){
            return $this->$prop;
        }
       
        public function setId($id){
            $this->id = $id;
            return $this;
        }

        public function setPath_img($path_img){
            $this->path_img = $path_img;
            return $this;
        }

        public function setProduct_id($product_id){
            $this->product_id = $product_id;
            return $this;
        }
    }

?>