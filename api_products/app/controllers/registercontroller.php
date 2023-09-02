<?php 

    namespace API\Controllers;
    use API\LIB\Helpers;
    use API\LIB\InputFilter;
    use API\Models\RegisterModel;

    class RegisterController extends AbstractController{
        
        use Helpers;
        use InputFilter;
        
        public function createAction(){
            $data = json_decode(file_get_contents("php://input"));
            
            if($_SERVER['REQUEST_METHOD'] != "POST"){
                http_response_code(404);
                $this->_data['returnData'] = (array) $this->msg(0, 404, "Page Not Found");
            }elseif(
                !isset($data->name)
                || !isset($data->email)
                || !isset($data->password)
                || empty(trim($data->name))
                || empty(trim($data->email))
                || empty(trim($data->password))
            ){
                http_response_code(422);
                $fields = ['fields' => ['name', 'email', 'password']];
                $this->_data['returnData'] = (array) $this->msg(0, 422, 'Please Fill in all Required Fields!', $fields);
            }else{
                $name     = $this->filterString(trim($data->name));
                $email    = $this->filterString(trim($data->email));
                $password = $this->filterString(trim($data->password));
                

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    http_response_code(422);
                    $this->_data['returnData'] = (array) $this->msg(0, 422, 'Invalid Email Address');
                }elseif(strlen($password) < 8 ) {
                    http_response_code(422);
                    $this->_data['returnData'] = (array) $this->msg(0, 422, "Your password must be at least 8 characters long!");
                }elseif(strlen($name) < 3 ) {
                    http_response_code(422);
                    $this->_data['returnData'] = (array) $this->msg(0, 422, "Your name must be at least 3 characters long!");
                }else{
                    try{
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $register = new RegisterModel();
                        $register->setUserName($name);
                        $register->setEmail($email);
                        $register->setPassword($password);

                        $check_email = $register->checkEmail($email);
        
                        if($check_email === true) {
                            http_response_code(422);
                            $this->_data['returnData'] = (array) $this->msg(0, 422, "This E-mail already in use!");
                        }else{
                            if($register->create()){
                                http_response_code(201);
                                $this->_data['returnData'] = (array) $this->msg(1, 201, "You have successfully registered");
                            }
                        }
                    }catch(\Exception $e){
                        http_response_code(500);
                        $this->_data['returnData'] = (array) $this->msg(0, 500, $e->getMessage());
                    }
                }

            }
            $this->_view();
        }
    }

?>