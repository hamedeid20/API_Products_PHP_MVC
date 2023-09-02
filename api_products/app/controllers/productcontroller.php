<?php 

    namespace API\Controllers;
    use API\LIB\Helpers;
    use API\LIB\InputFilter;
    use API\Models\DetailModel;
    use API\Models\ImgModel;
    use API\Models\ProductModel;
    use API\LIB\TokenValidation;

    class ProductController extends AbstractController{
        use Helpers;
        use InputFilter;
        use TokenValidation;
        public function defaultAction(){ 
            $auth = $this->tokenValidation(); 
            
            if($_SERVER['REQUEST_METHOD'] != "GET"){
                http_response_code(404);
                $this->_data['returnData'] = (array) $this->msg(0, 404, "Page Not Found");
            }else{
                @$user_id = $this->filterInt($auth['user']);
                if(isset($user_id) && !empty($user_id)){
                    @$id = $this->filterInt($this->_params[0]); 
                    $product = new ProductModel();                              
                    $imgs = new ImgModel();                              
                    $details = new DetailModel();                              
                    if(isset($id) && !empty($id)){
                        $product->setUser_id($user_id);
                        $product->setId($id);
                        $sql = "SELECT `product`.*, `categories`.`category_name`
                        FROM `product` 
                            LEFT JOIN `categories` ON `product`.`category_id` = `categories`.`category_id`
                        WHERE product.product_id = :id AND product.user_id = :user_id";
                        $result_product = $product->getFetchAll($sql, ["id" => \PDO::PARAM_INT ,"user_id" => \PDO::PARAM_INT]);//***************** */
                        
                        if(@$result_product['product_id']){
                            $imgs->setProduct_id($result_product['product_id']);
                            $details->setProduct_id($result_product['product_id']);
                        }

                        $result_imgs = $imgs->getByFk();
                        $result_details = $details->getByFk();

                        if($result_product != true){
                            http_response_code(422);
                            $result_product = (array) $this->msg(0, 422, "Product Not Found");
                        }else{
                            http_response_code(200);
                            $result_product ;
                        } 

                        if($result_imgs != true){
                            http_response_code(422);
                            $result_imgs = (array) $this->msg(0, 422, "Images Not Found");
                        }else{
                            http_response_code(200);
                            $result_imgs ;
                        }  

                        if($result_details != true){
                            http_response_code(422);
                            $result_details = (array) $this->msg(0, 422, "Details Not Found");
                        }else{
                            http_response_code(200);
                            $result_details ;
                        }                            

                        http_response_code(200);
                        $this->_data['returnData'] = [
                            "product" => array_merge([
                                $result_product,
                                "images" => $result_imgs,
                                "details" => $result_details
                                ]
                            )
                        ];
                        
                        
                        
    
                    }else{
                        $product->setUser_id($user_id);
                        $product->setId($id);
                        $sql = "SELECT `product`.*, `categories`.`category_name`
                        FROM `product` 
                            LEFT JOIN `categories` ON `product`.`category_id` = `categories`.`category_id`
                        WHERE product.user_id = :user_id";
                        $result_product = $product->getFetchAll($sql, ["user_id" => \PDO::PARAM_INT]);//***************** */
                        

                        $products = [];
                        for($i = 0; $i < count($result_product); $i++){
                            // $product_id[] = $product['product_id'];
                            $imgs->setProduct_id($result_product[$i]['product_id']);
                            $details->setProduct_id($result_product[$i]['product_id']);
                            $result_imgs = $imgs->getByFk();
                            $result_details = $details->getByFk();

                            if($result_product != true){
                                http_response_code(422);
                                $result_product = (array) $this->msg(0, 422, "Products Not Found");
                            }else{
                                http_response_code(200);
                                $result_product ;
                            } 
    
                            if($result_imgs != true){
                                http_response_code(422);
                                $result_imgs = (array) $this->msg(0, 422, "Images Not Found");
                            }else{
                                http_response_code(200);
                                $result_imgs ;
                            }  
    
                            if($result_details != true){
                                http_response_code(422);
                                $result_details = (array) $this->msg(0, 422, "Details Not Found");
                            }else{
                                http_response_code(200);
                                $result_details ;
                            }                            
    
                            $products[] = array_merge([
                                $result_product[$i],
                                "images" => $result_imgs,
                                "details" => $result_details
                            ]);
                                        
                        }
                        http_response_code(200);
                        $this->_data['returnData'] = $products;
                    }
    
                }else{
                    http_response_code(422);
                    $this->_data['returnData'] = (array) $this->msg(0, 422, "InValid User, Please Check on token");
                }
            }


            

            $this->_view();
        }
        public function addAction(){
            $auth = $this->tokenValidation();

            if($_SERVER['REQUEST_METHOD'] != "POST"){
                http_response_code(422);
                $this->_data['returnData'] = $this->msg(0, 422, "Page Not Found");
            }else{
                $userData = $_POST;
                $img_Files = $_FILES;
                if($auth['success'] !=0 && $auth['success'] == 1){
                    $user_id = $this->filterInt($auth['user']);
                    if(isset($user_id) && !empty($user_id)){
                        $product = new ProductModel();                              
                        $imgs = new ImgModel();                              
                        $details = new DetailModel(); 

                        $this->setTimezone(TIME_ZONE);
                        $created_at = $this->getCurrentTime();

                        if(isset($userData) && !empty($userData)){
                            if(
                                isset($userData['product_name'], $userData['discount_percentage'], $userData['price_before_discount'], $userData['price_after_discount'], $userData['description'], $userData['category_id'], $userData['detail_title'], $userData['detail_description']) &&
                                !empty($userData['product_name']) &&
                                !empty($userData['discount_percentage']) &&
                                !empty($userData['price_before_discount']) &&
                                !empty($userData['price_after_discount']) &&
                                !empty($userData['description']) &&
                                !empty($userData['category_id']) &&
                                !empty($userData['detail_title']) &&
                                !empty($userData['detail_description'])

                            ){
                                $product_name = $this->filterString($userData['product_name']); 
                                $discount_percentage = $this->filterInt($userData['discount_percentage']); 
                                $price_before_discount = $this->filterFloat($userData['price_before_discount']); 
                                $price_after_discount = $this->filterFloat($userData['price_after_discount']); 
                                $description = $this->filterString($userData['description']); 
                                $category_id = $this->filterInt($userData['category_id']);
    
                                $detail_title = $userData['detail_title'];
                                $detail_description = $userData['detail_description'];

                                $product->setUser_id($user_id);
                                $product->setProduct_name($product_name);
                                $product->setDiscount_percentage($discount_percentage);
                                $product->setPrice_before_discount($price_before_discount);
                                $product->setPrice_after_discount($price_after_discount);
                                $product->setDescription($description);
                                $product->setCategory_id($category_id);
                                $product->setCreated_at($created_at);

                                $sql = "SELECT product_name FROM product WHERE product_name = :product_name";
                                $check_product = $product->get($sql, ["product_name" => \PDO::PARAM_STR]);
                                if(@$check_product['product_name'] != $product_name){
                                    $product_result = $product->create();
                                }else{
                                    http_response_code(422);
                                    $this->_data['returnData'] = $this->msg(0, 422, "Product Already Exists!");
                                    $this->_view();
                                    exit;
                                }
                                $product_id = null;
                                if($product_result === true){
                                    $sql = "SELECT product_id FROM product WHERE product_name = :product_name AND user_id = :user_id";
                                    $product_id = $product->get($sql, ["product_name" => \PDO::PARAM_STR, "user_id" => \PDO::PARAM_INT]);
                                }
                                
                                if(is_array($detail_title) && !empty($detail_title)){
                                    $detail_title;
                                }else{
                                    $detail_title = $this->filterString($detail_title);
                                }
                                
                                if(is_array($detail_description) && !empty($detail_description)){
                                    $detail_description;
                                }else{
                                    $detail_description = $this->filterString($detail_description);
                                }
                                
                                if(is_array($detail_title) && is_array($detail_description) && !empty($detail_title) && !empty($detail_description) ){
                                    $result = false;
                                    for($i = 0; $i < count($detail_title); $i++){
                                        $details->setProduct_id($product_id['product_id']);
                                        $details->setDetail_title($detail_title[$i]);
                                        $details->setDetail_description($detail_description[$i]);
                                        $result = $details->create();
                                    }
                                    if($result != false && $result == true){
                                        http_response_code(200);
                                        $this->_data['returnData'] = $this->msg(1, 200, "The product has ben inserted");
                                    }else{
                                        http_response_code(422);
                                        $this->_data['returnData'] = $this->msg(0, 422, $result);
                                    }
                                }else{
                                    $details->setProduct_id($product_id['product_id']);
                                    $details->setDetail_title($detail_title);
                                    $details->setDetail_description($detail_description);
                                    $result = $details->create(); 
                                    if($result != false && $result === true){
                                        http_response_code(200);
                                        $this->_data['returnData'] = $this->msg(1, 200, "The product has ben inserted");
                                    }else{
                                        http_response_code(422);
                                        $this->_data['returnData'] = $this->msg(0, 422, $result);
                                    }                                   
                                }

                                if(isset($img_Files) && !empty($img_Files)){
                                    $handleImg = $this->handlerUploadImg($user_id, $product_id['product_id'], $imgs);
                                    http_response_code(200);
                                    $this->_data['returnDataFiles'] = $handleImg;
                                }else{
                                    http_response_code(422);
                                        $fields = ["Important_Image_Fields" => [
                                            "img[]"
                                            ]];
                                        $this->_data['returnDataFiles'] = (array) $this->msg(0, 422, "Invalid Image Fields OR Empty", $fields);
                                }

                            }else{
                                http_response_code(422);
                                $fields = ["Valid_Fields" => [
                                    "product_name", "discount_percentage",
                                    "price_before_discount", "price_after_discount",
                                    "description", "category_id", "detail_title OR detail_title[]", "detail_description OR detail_description[]"
                                    ]];
                                $this->_data['returnData'] = (array) $this->msg(0, 422, "Invalid Fields OR Not Set All Fields", $fields);
                            }
                        }else{
                            http_response_code(422);
                                $fields = ["Important_Fields" => [
                                    "product_name", "discount_percentage",
                                    "price_before_discount", "price_after_discount",
                                    "description", "category_id", "detail_title OR detail_title[]", "detail_description OR detail_description[]"
                                    ]];
                                $this->_data['returnData'] = (array) $this->msg(0, 422, "Invalid Fields", $fields);
                        }
                        
                    }

                }else{
                    http_response_code(422);
                    $this->_data['returnData'] = (array) $this->msg(0, 422, "InValid User, Please Check on token");
                }  
            }

            $this->_view();
        }
        public function updateAction(){
            $auth = $this->tokenValidation();
            if($_SERVER['REQUEST_METHOD'] != "POST"){
                http_response_code(422);
                $this->_data['returnData'] = $this->msg(0, 422, "Page Not Found");
            }else{
                $userData = $_POST;
                $img_Files = $_FILES;
                if($auth['success'] !=0 && $auth['success'] == 1){
                    $user_id = $this->filterInt($auth['user']);
                    if(isset($user_id) && !empty($user_id)){
                        $product = new ProductModel();                              
                        $imgs = new ImgModel();                              
                        $details = new DetailModel();

                        $params = $this->_params;
                        if(isset($params[0],$params[1],$params[2]) && !empty($params[0]) && !empty($params[1]) && !empty($params[2])){
                            $product_id = $params[0];
                            $action = $params[1];
                            $action_id = $params[2];
                        }elseif(isset($params[0]) && !empty($params[0])){
                            $product_id = $params[0];
                        }

                        if(isset($action) && !empty($action)){
                            
                            switch($action){
                                case "images":
                                    if(isset($img_Files['img'], $action_id) && !empty($action_id) && $img_Files['img']['size'] > 0){
                                        $imgs->setId($this->filterInt($action_id));
                                        $imgs->setProduct_id($this->filterInt($product_id));
                                        $sql = "SELECT * FROM product_imgs WHERE img_id = :id AND product_id = :product_id";
                                        $result = $imgs->get($sql, ["id" => \PDO::PARAM_INT, "product_id" => \PDO::PARAM_INT]);
                                        if(isset($result['img_id']) && $result['img_id'] === $action_id){
                                            $old_img = $result['path_img'];
                                            // var_dump($old_img);
                                            $handleImg = $this->handlerUpdateImg($user_id, $product_id, $action_id,$old_img, $imgs);
                                            http_response_code(200);
                                            $this->_data['returnDataFiles'] = $handleImg;
                                        }else{
                                            http_response_code(422);
                                            $this->_data['returnDataFiles'] = (array) $this->msg(0, 422, "Not Found Image In Your Image Gallery!, Please Enter Valid ID!");
                                        }
                                    }else{
                                        http_response_code(422);
                                            $fields = ["Important_Image_Fields" => [
                                                "img"
                                                ]];
                                            $this->_data['returnDataFiles'] = (array) $this->msg(0, 422, "Invalid Image Fields OR Empty!", $fields);
                                    }
                                    break;
                                case "details" :
                                    if(isset($action, $action_id, $userData) && !empty($action) && !empty($action_id) && !empty($userData)){
                                        if(isset($userData['detail_title'], $userData['detail_description'], $product_id) && !empty($product_id) && !empty($userData['detail_title']) && !empty($userData['detail_description'])){ 
                                            $details->setProduct_id($product_id);
                                            $details->setId($action_id);
                                            $details->setDetail_title($userData['detail_title']);
                                            $details->setDetail_description($userData['detail_description']);
                                            $result = $details->updateDetail(["detail_title" => \PDO::PARAM_STR, "detail_description" => \PDO::PARAM_STR]);
                                            if($result != false && $result === true){
                                                http_response_code(200);
                                                $this->_data['returnData'] = $this->msg(1, 200, "Details updated");
                                            }else{
                                                http_response_code(422);
                                                $this->_data['returnData'] = $this->msg(0, 422, $result);
                                            } 
                                            
                                        }else{
                                            http_response_code(422);
                                                $fields = ["Fields" => [
                                                    "detail_title",
                                                    "detail_description"
                                                    ]];
                                                $this->_data['returnDataFiles'] = (array) $this->msg(0, 422, "Fields Empty!, OR Not Set Fields!", $fields);
                                        }


                                    }else{
                                        http_response_code(422);
                                            $fields = ["Important_Fields" => [
                                                "detail_title",
                                                "detail_description"
                                                ]];
                                            $this->_data['returnDataFiles'] = (array) $this->msg(0, 422, "Invalid Fields OR Empty!, OR Not Set Action And ID!", $fields);
                                    }
                                    break;
                            }
                        }else{
                            // var_dump("Product_id : " . $product_id ); 

                            if(isset($userData) && !empty($userData) && !empty($product_id)){
                                $product_id = $this->filterInt($product_id);
                                $product_name = isset($userData['product_name']) ? $this->filterString($userData['product_name']) : null; 
                                $discount_percentage = isset($userData['discount_percentage']) ? $this->filterInt($userData['discount_percentage']) : null; 
                                $price_before_discount = isset($userData['price_before_discount']) ? $this->filterFloat($userData['price_before_discount']) : null; 
                                $price_after_discount = isset($userData['price_after_discount']) ? $this->filterFloat($userData['price_after_discount']) : null; 
                                $description = isset($userData['description']) ? $this->filterString($userData['description']) : null; 
                                $category_id = isset($userData['category_id']) ? $this->filterInt($userData['category_id']) : null;
                                
                                $product_fields = ["product_name" => $product_name, "discount_percentage" => $discount_percentage, "price_before_discount" => $price_before_discount, "price_after_discount" => $price_after_discount, "description" => $description, "category_id" => $category_id];

                                $data = function (array $product_fields){
                                    $result = [];
                                    // $i = 0;
                                    // $len = count($product_fields);
                                    foreach($product_fields as $data => $value){
                                        if(isset($value) && $value != null){
                                            // if($i == $len - 1) $result = $data;
                                            // else $result = $data . ',';
                                            $result[$data] = $data;
                                        }
                                        // $i++;
                                    }
                                    // return rtrim($result, ',');
                                    return $result;
                                };

                                
                                $detail_id = $userData['detail_id'];
                                $detail_title = $userData['detail_title'] ;
                                $detail_description = $userData['detail_description'] ;

                                $product->setUser_id($user_id);
                                $product->setId($product_id);
                                $product->setProduct_name($product_name);
                                $product->setDiscount_percentage($discount_percentage);
                                $product->setPrice_before_discount($price_before_discount);
                                $product->setPrice_after_discount($price_after_discount);
                                $product->setDescription($description);
                                $product->setCategory_id($category_id);

                                $product_result = $product->updateBy($data($product_fields));
                                
                                if(isset($product_result) && $product_result === true){

                                    if(is_array($detail_title) && !empty($detail_title)) $detail_title;
                                    else $detail_title = $this->filterString($detail_title);
                                    
                                    if(is_array($detail_description) && !empty($detail_description)) $detail_description;
                                    else $detail_description = $this->filterString($detail_description);
                                    
                                    if(isset($detail_id,$detail_title,$detail_description) && is_array($detail_title)&& !empty($detail_id) && !empty($detail_title) && !empty($detail_description) ){
                                        $result = false;
                                        for($i = 0; $i < count($detail_title); $i++){
                                            $details->setProduct_id($product_id);
                                            $details->setId($detail_id[$i]);
                                            $details->setDetail_title($detail_title[$i]);
                                            $details->setDetail_description($detail_description[$i]);
                                            $result = $details->updateDetail(["detail_title" => \PDO::PARAM_STR, "detail_description" => \PDO::PARAM_STR]);
                                        }
                                        if($result != false && $result == true){
                                            http_response_code(200);
                                            $this->_data['returnData'] = $this->msg(1, 200, "The product has ben updated");
                                        }else{
                                            http_response_code(422);
                                            $this->_data['returnData'] = $this->msg(0, 422, $result);
                                        }
                                    }elseif(isset($detail_id) && !empty($detail_id)){
                                        $details->setProduct_id($product_id);
                                        $details->setId($detail_id);
                                        $details->setDetail_title($detail_title);
                                        $details->setDetail_description($detail_description);
                                        $result = $details->updateDetail(["detail_title" => \PDO::PARAM_STR, "detail_description" => \PDO::PARAM_STR]);
                                        if($result != false && $result === true){
                                            http_response_code(200);
                                            $this->_data['returnData'] = $this->msg(1, 200, "The product has ben updated");
                                        }else{
                                            http_response_code(422);
                                            $this->_data['returnData'] = $this->msg(0, 422, $result);
                                        }                                   
                                    } 

                                }else{
                                    http_response_code(422);
                                    $this->_data['returnData'] = $this->msg(0, 422, "Product Not Updated!");
                                }
                                
                                                               

                            }else{
                                http_response_code(422);
                                    $fields = ["Important_Fields" => [
                                        "product_name", "discount_percentage",
                                        "price_before_discount", "price_after_discount",
                                        "description", "category_id",
                                        "detail_id OR detail_id[]",
                                        "detail_title OR detail_title[]", 
                                        "detail_description OR detail_description[]",
                                        // "img[]"
                                        ]];
                                    $this->_data['returnData'] = (array) $this->msg(0, 422, "Invalid Fields", $fields);
                            }

                        }
  
                    }
                }else{
                    http_response_code(422);
                    $this->_data['returnData'] = (array) $this->msg(0, 422, "InValid User, Please Check on token");
                }
                                           
            }
            $this->_view();
        }
        public function deleteAction(){
            $auth = $this->tokenValidation();

            if($_SERVER['REQUEST_METHOD'] != "DELETE"){
                http_response_code(422);
                $this->_data['returnData'] = $this->msg(0, 422, "Page Not Found");
            }else{
                if($auth['success'] !=0 && $auth['success'] == 1){
                    $user_id = $this->filterInt($auth['user']);
                    $product_id = isset($this->_params[0]) && !empty($this->_params[0]) ? $this->filterInt($this->_params[0]) : null;
                    if(isset($user_id) && !empty($user_id)){
                        if(isset($product_id) && !empty($product_id)){
                            $product = new ProductModel();
                            $product->setUser_id($user_id);
                            $product->setId($product_id);
                            
                            $sql = "SELECT count(product_id) as count_product FROM product WHERE product_id = :id AND user_id = :user_id";
                            $check_product = $product->get($sql, ["id" => \PDO::PARAM_INT, "user_id" => \PDO::PARAM_INT]);

                            $imgs = new ImgModel();
                            $imgs->setProduct_id($product_id);
                            $sql = "SELECT path_img FROM product_imgs WHERE product_id = :product_id";
                            $result = $imgs->getFetchAll($sql, ["product_id" => \PDO::PARAM_INT]);
                            
                            $paths = [];
                            foreach($result as $path){
                                $paths[] = $path['path_img'];
                            }

                            if(isset($check_product['count_product']) && !empty($check_product['count_product']) && $check_product['count_product'] != 0){
                                $result = $product->delete();
                                if(isset($result) && $result === true){

                                    foreach($paths as $path){
                                        $url = explode('/', $path);
                                        $path = explode(DS,$url[2]);
                                        $current_path = UPLOAD_PATH . $path[4] . DS . $path[6];
                                        unlink($current_path);
                                    }
                                    

                                    http_response_code(200);
                                    $this->_data['returnData'] = (array) $this->msg(1, 200, "Product Deleted");


                                }else{
                                    http_response_code(422);
                                    $this->_data['returnData'] = (array) $this->msg(0, 422, $result);
                                }
                            }else{
                                http_response_code(422);
                                $this->_data['returnData'] = (array) $this->msg(0, 422, "Product Not Found, Please Enter Valid Product");
                            }


                        }else{
                            http_response_code(422);
                            $this->_data['returnData'] = (array) $this->msg(0, 422, "Please Enter Product_id In Link As Parameter");
                        }
                    }
                }else{
                    http_response_code(422);
                    $this->_data['returnData'] = (array) $this->msg(0, 422, "InValid User, Please Check on token");
                }
            }

            $this->_view();
        }
    }

?>