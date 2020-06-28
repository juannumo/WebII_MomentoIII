<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserSignIn extends CI_Controller
{

    //url base
    //http://localhost:8081/Momento3/UserSignIn/

    public function index()
    {
        //User Sign-Up   
    }


    public function SignIn()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST') {

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            //Validate empty inputs
            if ($data->email == "" || $data->password == "") {
                $response = array('response' => 'Empty Input');
                echo json_encode($response);
            }

            //Validation for Email
            else if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {

                $response = array('response' => 'Invalid email format');
                echo json_encode($response);
            }

            //Validate data email (user) exits
            else if ($this->getOneUser($data->email) != null) {

                $this->dataVerification($data->email, $data->password);
            } else {
                $response = array('response' => 'User does not exist');
                echo json_encode($response);
            }
        } else {

            header('content-type: application/json');
            $response = array('response' => 'Something is not right');
            echo json_encode($response);
        }
    }


    public function getOneUser($email)
    {
        $oneUser = $this->User_Model->getOneUser($email);
        return $oneUser;
    }

    public function dataVerification($email, $password)
    {
        $dataemail = $email;
        $datapassword = $password;
        $userArray = $this->getOneUser($email);

        foreach ($userArray as $user) {
            if ($user->email == $dataemail && $user->password == $datapassword) {

                header('content-type: application/json');
                $response = array('response' => 'Welcome to your Session');
                echo json_encode($response);
            } else {
                header('content-type: application/json');
                $response = array('response' => 'Password is wrong');
                echo json_encode($response);
            }
        }
        return $response;
    }
}
