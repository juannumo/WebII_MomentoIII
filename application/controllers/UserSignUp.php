<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserSignUp extends CI_Controller
{

    //url base
    //http://localhost:8081/Momento3/UserSignUp/

    public function index()
    {
        //User Sign-Up   
    }


    public function addUser()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST') {

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            //Validate empty inputs
            if ($data->name == "" || $data->lastname == "" || $data->email == "" || $data->type_id == "" || $data->identification == "" || $data->password == "") {
                $response = array('response' => 'Empty Input');
                echo json_encode($response);
            }

            //Validate data email (user) exits
            else if ($data->email != "" && $this->getOneUser($data->email) != []) {

                header('content-type: application/json');
                $response = array('response' => 'There is an User with the same email. Please choose a different email');
                echo json_encode($response);
            }

            //Validation for Name
            else if (!(strlen($data->name) >= 1 && strlen($data->name) <= 40)) {
                $response = array('response' => 'Name lenght must be more than 1 character and less than 40 characters');
                echo json_encode($response);
            } else if ($this->symbols($data->name) !== []) {
                header('content-type: application/json');
                $response = array('response' => 'Error using special characters: ¡, @, #, $, %, &, ?, ¿, !');
                echo json_encode($response);
            }

            //Validation for Lastname
            else if (!(strlen($data->lastname) >= 1 && strlen($data->lastname) <= 40)) {
                $response = array('response' => 'Lastname lenght must be more than 1 character and less than 40 characters');
                echo json_encode($response);
            } else if ($this->symbols($data->lastname) !== []) {
                header('content-type: application/json');
                $response = array('response' => 'Error using special characters: ¡, @, #, $, %, &, ?, ¿, !');
                echo json_encode($response);
            }

            //Validation for Email
            else if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {

                $response = array('response' => 'Invalid email format');
                echo json_encode($response);
            }

            //Validation for Type_id
            else if ($this->validateTypeId($data->type_id) === false) {

                $response = array('response' => 'Invalid Type of Identification. Valid options are cc or Pas');
                echo json_encode($response);
            }

            //Validation for Identification

            else if ($this->validateTypeId($data->type_id) === "Pas" && $this->validateIdentification($data->identification) === false) {

                $response = array('response' => 'Invalid identification passport number. (Required less than 10 characters)');
                echo json_encode($response);
            } else if ($this->validateTypeId($data->type_id) === "cc" && !is_numeric($data->identification)) {

                $response = array('response' => 'Invalid identification cc number. (Number required)');
                echo json_encode($response);
            }

            //Validation for Password

            else if (!((strlen($data->password) >= 8 && strlen($data->password) <= 16)) || count($this->symbols($data->password)) < 2) {

                $response = array('response' => 'Invalid Password. Range between 8 and 16 characters. More than two special characters ¡, @, #, $, %, &, ?, !, ¿, *');
                echo json_encode($response);
            } else {

                $this->User_Model->addUser($data);

                http_response_code(200);
                header('content-type: application/json');
                $response = array('response' => 'User successfully added');
                echo json_encode($response);
            }
        } else {

            header('content-type: application/json');
            $response = array('response' => 'Something is not right');
            echo json_encode($response);
        }
    }

    public function getUser()
    {
        header("Access-Control-Allow_Origin: *"); // Para evitar problemas al conectarse desde cualquier parte
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'GET') {

            $user = $this->User_Model->getUser();

            header('content-type: application/json');
            $response = array('success' => true, 'data' => $user, 'error' => ['title' => http_response_code(200), 'message' => "OK"]);
            echo json_encode($response);
        } else {

            header('content-type: application/json');
            $response = array('success' => false, 'data' => [], 'error' => ['title' => http_response_code(404), 'message' => "Not Found"]);
            echo json_encode($response);
        }
    }

    public function updateUser()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'PUT') {

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            $this->User_Model->updateUser($data);

            //Validate empty inputs
            if ($data->name == "" || $data->lastname == "" || $data->email == "" || $data->type_id == "" || $data->identification == "") {
                $response = array('response' => 'Empty Input');
                echo json_encode($response);
            }


            //Validation for Name
            else if (!(strlen($data->name) >= 1 && strlen($data->name) <= 40)) {
                $response = array('response' => 'Name lenght must be more than 1 character and less than 40 characters');
                echo json_encode($response);
            } else if ($this->symbols($data->name) !== []) {
                header('content-type: application/json');
                $response = array('response' => 'Error using special characters: ¡, @, #, $, %, &, ?, ¿, !');
                echo json_encode($response);
            }

            //Validation for Lastname
            else if (!(strlen($data->lastname) >= 1 && strlen($data->lastname) <= 40)) {
                $response = array('response' => 'Name lenght must be more than 1 character and less than 40 characters');
                echo json_encode($response);
            } else if ($this->symbols($data->lastname) !== []) {
                header('content-type: application/json');
                $response = array('response' => 'Error using special characters: ¡, @, #, $, %, &, ?, ¿, !');
                echo json_encode($response);
            }

            //Validation for Email
            else if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {

                $response = array('response' => 'Invalid email format');
                echo json_encode($response);
            }

            //Validation for Type_id
            else if ($this->validateTypeId($data->type_id) === false) {

                $response = array('response' => 'Invalid Type of Identification. Valid options are cc or Pas');
                echo json_encode($response);
            }

            //Validation for Identification

            else if ($this->validateTypeId($data->type_id) === "Pas" && $this->validateIdentification($data->identification) === false) {

                $response = array('response' => 'Invalid identification passport number. (Required less than 10 characters)');
                echo json_encode($response);
            } else if ($this->validateTypeId($data->type_id) === "cc" && !is_numeric($data->identification)) {

                $response = array('response' => 'Invalid identification cc number. (Number required)');
                echo json_encode($response);
            } else {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('response' => 'User Successfully Updated');
                echo json_encode($response);
            }
        } else {

            header('content-type: application/json');
            $response = array('response' => 'There was a problem updating');
            echo json_encode($response);
        }
    }


    public function deleteUser()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'DELETE') {

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            $this->User_Model->deleteUser($data);

            http_response_code(200);
            header('content-type: application/json');
            $response = array('response' => 'Property Successfully deleted');
            echo json_encode($response);
        } else {

            header('content-type: application/json');
            $response = array('response' => 'There was a problem deleting');
            echo json_encode($response);
        }
    }

    public function getOneUser($email)
    {
        $oneUser = $this->User_Model->getOneUser($email);
        return $oneUser;
    }

    public function symbols($data)
    {
        $dat = $data;
        $chardat =  preg_split('//', $dat, -1, PREG_SPLIT_NO_EMPTY);

        $symbol = '¡@#$%&?¿!*';
        $charsym =  preg_split('//', $symbol, -1, PREG_SPLIT_NO_EMPTY);

        $matches = [];
        foreach ($chardat as $char) {
            foreach ($charsym as $symbol) {
                if ($char == $symbol) {
                    array_push($matches, $char);
                }
            }
        }
        return $matches;
    }

    public function validateTypeId($data)
    {
        switch ($data) {
            case 'cc':
                return "cc";
                break;
            case 'Pas':
                return "Pas";
                break;
            default:
                return false;
                break;
        }
    }

    public function validateIdentification($data)
    {

        if (is_numeric($data)) {
            if (strlen(strval($data)) <= 10) {
                return true;
            } else {
                return false;
            }
        } else if (is_integer($data)) {
            if (strlen(strval($data)) <= 10) {
                return true;
            } else {
                return false;
            }
        } else if (is_int($data)) {
            if (strlen(strval($data)) <= 10) {
                return true;
            } else {
                return false;
            }
        } else {
            return "str";
        }
    }
}
