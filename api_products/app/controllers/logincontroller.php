<?php 

    namespace API\Controllers;
    use API\Controllers\AbstractController;
    use API\LIB\Helpers;
    use API\LIB\JwtHandler;
    use API\Models\LoginModel;

    class LoginController extends AbstractController{
        use Helpers;

        public function tokenAction(){

            $data = json_decode(file_get_contents("php://input"));

            if($_SERVER['REQUEST_METHOD'] != "POST") {
                http_response_code(404);
                $this->_data['returnData'] = (array) $this->msg(0, 404, "Page Not Found!");
            }elseif(
                !isset($data->email)
                || !isset($data->password)
                || empty(trim($data->email))
                || empty(trim($data->password))
            ){
                $fields = ['fields' => ['email', 'password']];
                $this->_data['returnData'] = (array) $this->msg(0, 422, 'Please Fill in all Required Fields!', $fields);
            }else{

                $email = trim($data->email);
                $password = trim($data->password);

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $this->_data['returnData'] = (array) $this->msg(0, 422, 'Invalid Email Address');
                }elseif(strlen($password) < 8 ) {
                    $this->_data['returnData'] = (array) $this->msg(0, 422, "Your password must be at least 8 characters long!");
                }else {
                    try{

                        $login = new LoginModel();
                        $login->setEmail($email);
                        $check = $login->checkLogin();
                        if($check){
                            $row = $check;
                            $check_password = password_verify($password, $row['password']);
                            if($check_password){
                                $jwt = new JwtHandler();
                                $token = $jwt->jwtEncodeData(
                                    'http://localhost/api_product/public/',
                                    array("user_id" => $row['user_id'])
                                );

                                http_response_code(200);
                                $this->_data['returnData'] = (array) [
                                    "success" => 1,
                                    "message" => "You have successfully logged in.",
                                    "token" => $token
                                ];
                            }else{
                                http_response_code(422);
                                $this->_data['returnData'] = (array) $this->msg(0, 422, "Invalid Password!.");
                            }
                        }else{
                            http_response_code(422);
                            $this->_data['returnData'] = (array) $this->msg(0, 422, "Invalid Email Address!.");
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