<?php 

    namespace API\Controllers;
    use API\LIB\Helpers;
    use API\LIB\InputFilter;
    use API\LIB\TokenValidation;
    use API\Models\CategoryModel;

    class CategoryController extends AbstractController{
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
                    $category = new CategoryModel;
                    if(isset($id) && !empty($id)):
                        $category->setId($id);
                        $category->setUser_id($user_id);
                        $result = $category->getByPk();
                        if($result != true):
                            http_response_code(422);
                            $this->_data['returnData'] = (array) $this->msg(0, 422, "Category Not Found");
                        else:
                            http_response_code(200);
                            $this->_data['returnData'] = [
                                "category" => $result
                            ];
                        endif;
                    else:
                        $category->setUser_id($user_id);
                        $result = $category->getAll();
                        if($result != true):
                            http_response_code(422);
                            $this->_data['returnData'] = (array) $this->msg(0, 422, "Not Found");
                        else:
                            http_response_code(200);
                            $this->_data['returnData'] = [
                                "categories" => $result
                            ];
                        endif;
                    endif;
    
                }else{
                    http_response_code(422);
                    $this->_data['returnData'] = (array) $this->msg(0, 422, "InValid User, Please Check on token");
                }
            }
            $this->_view();
        }
        public function addAction(){
            $auth = $this->tokenValidation();
            $userData = (array) json_decode(file_get_contents("php://input"), true);
            
            if($_SERVER['REQUEST_METHOD'] != "POST"){
                http_response_code(404);
                $this->_data['returnData'] = (array) $this->msg(0, 404, "Page Not Found");
            }else{
                @$user_id = $this->filterInt($auth['user']);
                if(isset($user_id) && !empty($user_id)){
                    $category_name = isset($userData['category_name']) ? $this->filterString($userData['category_name']) : null;
                    if(isset($category_name) && !empty($category_name)):
                        $category = new CategoryModel;
                        $category->setCategory_name($category_name);
                        $category->setUser_id($user_id);
                        $result = $category->create();
                        if($result != true):
                            http_response_code(422);
                            $this->_data['returnData'] = (array) $this->msg(0, 422, "Not Added");
                        else:
                            http_response_code(200);
                            $this->_data['returnData'] = (array) $this->msg(1, 200, "Category Added");
                        endif;
                    else:
                        http_response_code(422);
                        $fields = ["Valid_Fields" => ["category_name"]];
                        $this->_data['returnData'] = (array) $this->msg(0, 422, "Invalid Fields", $fields);
                    endif;

                }else{
                    http_response_code(422);
                    $this->_data['returnData'] = (array) $this->msg(0, 422, "InValid User, Please Check on token");
                }
            }
            $this->_view();
        }
        public function updateAction(){
            $auth = $this->tokenValidation();
            $userData = (array) json_decode(file_get_contents("php://input"), true);
            
            if($_SERVER['REQUEST_METHOD'] != "PATCH"){
                http_response_code(404);
                $this->_data['returnData'] = (array) $this->msg(0, 404, "Page Not Found");
            }else{
                @$user_id = $this->filterInt($auth['user']);
                if(isset($user_id) && !empty($user_id)){
                    @$id = $this->filterInt($this->_params[0]);
                    $category_name = isset($userData['category_name']) ? $this->filterString($userData['category_name']) : null;
                    if(isset($category_name) && !empty($category_name)):
                        if(isset($id) && !empty($id)):
                            $category = new CategoryModel;
                            $category->setCategory_name($category_name);
                            $category->setId($id);
                            $category->setUser_id($user_id);

                            $sql = "SELECT count(category_id) as count_category FROM categories WHERE category_id = :id AND user_id = :user_id";
                            $check_category =$category->get($sql, ["id" => \PDO::PARAM_INT, "user_id" => \PDO::PARAM_INT]);
                            if(isset($check_category) && !empty($check_category) && $check_category['count_category'] != 0){
                                $result = $category->updateBy($userData);
                                if($result != true):
                                    http_response_code(422);
                                    $this->_data['returnData'] = (array) $this->msg(0, 422, "Not Updated");
                                else:
                                    http_response_code(200);
                                    $this->_data['returnData'] = (array) $this->msg(1, 200, "Category Updated");
                                endif;
                            }else{
                                http_response_code(422);
                                $this->_data['returnData'] = (array) $this->msg(0, 422, "Not Found Category");
                            }

                        else:
                            http_response_code(422);
                            $this->_data['returnData'] = (array) $this->msg(0, 422, "Please Set ID  Parameter");
                        endif;
                    else:
                        http_response_code(422);
                        $fields = ["Valid_Fields" => ["category_name"]];
                        $this->_data['returnData'] = (array) $this->msg(0, 422, "Invalid Fields", $fields);
                    endif;

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
                http_response_code(404);
                $this->_data['returnData'] = (array) $this->msg(0, 404, "Page Not Found");
            }else{
                @$user_id = $this->filterInt($auth['user']);
                if(isset($user_id) && !empty($user_id)){
                    @$id = $this->filterInt($this->_params[0]);
                    if(isset($id) && !empty($id)):
                        $category = new CategoryModel;
                        $category->setId($id);
                        $category->setUser_id($user_id);

                        $sql = "SELECT count(category_id) as count_category FROM categories WHERE category_id = :id AND user_id = :user_id";
                        $check_category =$category->get($sql, ["id" => \PDO::PARAM_INT, "user_id" => \PDO::PARAM_INT]);
                        if(isset($check_category) && !empty($check_category) && $check_category['count_category'] != 0){
                            $result = $category->delete();
                            if($result != true):
                                http_response_code(422);
                                $this->_data['returnData'] = (array) $this->msg(0, 422, "Not Deleted");
                            else:
                                http_response_code(200);
                                $this->_data['returnData'] = (array) $this->msg(1, 200, "Category Deleted");
                            endif;
                        }else{
                            http_response_code(422);
                            $this->_data['returnData'] = (array) $this->msg(0, 422, "Not Found Category");
                        }                            
                    else:
                        http_response_code(422);
                        $this->_data['returnData'] = (array) $this->msg(0, 422, "Please Set ID  Parameter");
                    endif;
                }else{
                    http_response_code(422);
                    $this->_data['returnData'] = (array) $this->msg(0, 422, "InValid User, Please Check on token");
                }
            }
            $this->_view();
        }
    }

?>