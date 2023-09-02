<?php 

    namespace API\LIB;

    use API\Models\ImgModel;

    trait Helpers{
        private $timeZone;

        public function msg($success, $status, $message, $extra = []) {
            return array_merge([
                "success" => $success,
                "status"  => $status,
                "message" => $message
            ],$extra);
        }

        public function setTimezone($timeZone) {
        $this->timeZone = new \DateTimeZone($timeZone);
        }
      
        public function getCurrentTime() {
            if (!$this->timeZone) {
            throw new \Exception("Time zone has not been set.");
            }else{
                $currentTime = new \DateTime('now', $this->timeZone);
                return $currentTime->format('Y-m-d h:i A');
            }
        }

        public function handlerUploadImg($user_id_folder, $product_id, ImgModel $imgModel){
            $targetDirectory = UPLOAD_PATH;
            if(is_dir($targetDirectory . "Dir_user_" . $user_id_folder)){
                $targetDirectory = $targetDirectory . "Dir_user_" . $user_id_folder . DS;
            }else{
                $targetDirectory = mkdir($targetDirectory . "Dir_user_" . $user_id_folder);
            }
            $imgs = $_FILES["img"]["tmp_name"];
            $result = [];
            $count_jpg = 1;
            $count_jpeg = 1;
            $count_png = 1;
            for($i = 0; $i < count($imgs); $i++) {
                $imageFileType = strtolower(pathinfo($_FILES["img"]["name"][$i], PATHINFO_EXTENSION));

                $imageName = $user_id_folder . '-' . $product_id . '.' . $imageFileType;
                
                if($imageFileType === "jpg"){
                    $imageName = $user_id_folder . '-' . $product_id . '-' . $count_jpg . '.' . $imageFileType;
                    $count_jpg++;
                }elseif($imageFileType === "jpeg"){
                    $imageName = $user_id_folder . '-' . $product_id . '-' . $count_jpeg . '.' . $imageFileType; 
                    $count_jpeg++;
                }elseif($imageFileType === "png"){
                    $imageName = $user_id_folder . '-' . $product_id . '-' . $count_png . '.' . $imageFileType; 
                    $count_png++;                                     
                }
                
                $targetPath = $targetDirectory . $imageName;
        
                $check = getimagesize($_FILES["img"]["tmp_name"][$i]);
                if($check !== false) {
                    $allowedExtensions = array("jpg", "jpeg", "png");
                    if(in_array($imageFileType, $allowedExtensions)) {
                        
                        if(move_uploaded_file($_FILES["img"]["tmp_name"][$i], $targetPath)) {
                            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                            $targetPath = $protocol . getenv('HTTP_HOST') . DS . "api_products" . DS . "public" . DS . "uploads" . DS . "Dir_user_" . $user_id_folder . DS . DS . $imageName ;
                            $imgModel->setPath_img($targetPath);
                            $imgModel->setProduct_id($product_id);
                            $result_upload = $imgModel->create();
                            if($result_upload === true){
                                $result[] = [
                                    "success" => 1,
                                    "message" => "Data Uploaded"
                                ];
                            }
                        } else {
                            $result[] = [
                                "success" => 0,
                                "message" => "Sorry, there was an error uploading"
                            ];
                        }
                    } else {
                        $result[] = [
                            "success" => 0,
                            "message" => "Sorry, only JPG, JPEG, PNG files are allowed"
                        ];
                    }
                } else {
                    $result[] = [
                        "success" => 0,
                        "message" => "File '".$_FILES["uploadImg"]["name"][$i]."' is not an image."
                    ];
                }
                
            }  
            return $result;              
        }
        public function handlerUpdateImg($user_id_folder, $product_id, $img_id, $old_img, ImgModel $imgModel){
            $targetDirectory = UPLOAD_PATH;
            if(is_dir($targetDirectory . "Dir_user_" . $user_id_folder)){
                $targetDirectory = $targetDirectory . "Dir_user_" . $user_id_folder . DS;
            }else{
                $targetDirectory = mkdir($targetDirectory . "Dir_user_" . $user_id_folder);
            }
            $result = [];

            $url = explode('/', $old_img);
            $path = explode(DS,$url[2]);
            $current_path = UPLOAD_PATH . $path[4] . DS . $path[6];

            if(is_file($current_path) && file_exists($current_path)){
                unlink($current_path);
            }
            
            $imageFileType = strtolower(pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION));
            $count = rand();
            $imageName = $user_id_folder . '-' . $product_id . '-' . $count . '.' . $imageFileType;
            $targetPath = $targetDirectory . $imageName;

            $check = getimagesize($_FILES["img"]["tmp_name"]);
            if($check !== false) {
                $allowedExtensions = array("jpg", "jpeg", "png");
                if(in_array($imageFileType, $allowedExtensions)) {
                    
                    if(move_uploaded_file($_FILES["img"]["tmp_name"], $targetPath)) {
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                        $targetPath = $protocol . getenv('HTTP_HOST') . DS . "api_products" . DS . "public" . DS . "uploads" . DS . "Dir_user_" . $user_id_folder . DS . DS . $imageName ;
                        $imgModel->setPath_img($targetPath);
                        $imgModel->setProduct_id($product_id);
                        $imgModel->setId($img_id);
                        $result_upload = $imgModel->updateDetail(["path_img" => '']);
                        if($result_upload === true){
                            $result[] = [
                                "success" => 1,
                                "message" => "Image Updated"
                            ];
                        }
                    } else {
                        $result[] = [
                            "success" => 0,
                            "message" => "Sorry, there was an error uploading"
                        ];
                    }
                } else {
                    $result[] = [
                        "success" => 0,
                        "message" => "Sorry, only JPG, JPEG, PNG files are allowed"
                    ];
                }
            } else {
                $result[] = [
                    "success" => 0,
                    "message" => "File '".$_FILES["uploadImg"]["name"]."' is not an image."
                ];
            }            
                   
            return $result;              
        }
        
    }

?>