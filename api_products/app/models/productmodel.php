<?php 

    namespace API\Models;
    use API\Models\AbstractModel;

    class ProductModel extends AbstractModel{

        private $id;
        private $product_name;
        private $discount_percentage;
        private $price_before_discount;
        private $price_after_discount;
        private $description;
        private $created_at;
        private $user_id;
        private $category_id;

        protected static $primaryKey = 'id';
        protected static $name_id = 'product_';
        protected static $table_Name = 'product';
        protected static $table_Schema = array(
            "product_name"          => self::DATA_TYPE_STR,
            "discount_percentage"   => self::DATA_TYPE_STR,
            "price_before_discount" => self::DATA_TYPE_STR,
            "price_after_discount"  => self::DATA_TYPE_STR,
            "description"           => self::DATA_TYPE_STR,
            "created_at"            => self::DATA_TYPE_STR,
            "user_id"               => self::DATA_TYPE_STR,
            "category_id"           => self::DATA_TYPE_STR
        );

        public function __get($prop){
            return $this->$prop;
        }

        public function setProduct_name($product_name){
            $this->product_name = $product_name;
            return $this;
        }

        public function setDiscount_percentage($discount_percentage){
            $this->discount_percentage = $discount_percentage;
            return $this;
        }

        public function setPrice_before_discount($price_before_discount){
            $this->price_before_discount = $price_before_discount;
            return $this;
        }

        public function setPrice_after_discount($price_after_discount){
            $this->price_after_discount = $price_after_discount;
            return $this;
        }

        public function setDescription($description){
            $this->description = $description;
            return $this;
        }

        public function setCreated_at($created_at){
            $this->created_at = $created_at;
            return $this;
        }
 
        public function setUser_id($user_id){
            $this->user_id = $user_id;
            return $this;
        }

        public function setCategory_id($category_id){
            $this->category_id = $category_id;
            return $this;
        }

        public function setId($id){
            $this->id = $id;
            return $this;
        }
    }

?>