<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PropertyCRUD extends CI_Controller
{

    //url base
    //http://localhost:8081/Momento3/PropertyCRUD/
    public function index()
    {
    }

    public function addProperty()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json);

            //Validar campos vacíos
            if ($data->title == "" || $data->type == "" || $data->address == "" || $data->rooms == "" || $data->price == "" || $data->area == "") {
                $response = array('response' => 'Empty Input');
                echo json_encode($response);
            }

            //Validar tipo de propiedad que sea casa, habitacion u hostal
            else if ($data->type != 'casa' && $data->type != 'habitacion' && $data->type != 'hostal') {
                $response = array('response' => 'Invalid Input (Required: casa, hostal or habitacion)');
                echo json_encode($response);
            }

            //validar que los datos son de tipo String
            else if (!is_string($data->title) || !is_string($data->type)  || !is_string($data->address)) {
                $response = array('response' => 'Invalid Input (String required)');
                echo json_encode($response);
            }

            //validar que rooms, price y area son numéricos
            else if (!is_numeric($data->rooms) || !is_numeric($data->price) || !is_numeric($data->area)) {
                $response = array('response' => 'Invalid Input (Number required in rooms, price or area)');
                echo json_encode($response);
            }

            //validar que area es Int
            else if (!is_int($data->area)) {
                $response = array('response' => 'Invalid Input (Integer required in area)');
                echo json_encode($response);
            } else {

                //var_dump($data);

                $this->Property_Model->addProperty($data);

                http_response_code(200);
                header('content-type: application/json');
                $response = array('response' => 'Property successfully added');
                echo json_encode($response);
            }
        } else {

            header('content-type: application/json');
            $response = array('response' => 'Something is not right');
            echo json_encode($response);
        }
    }

    public function getProperty()
    {
        header("Access-Control-Allow_Origin: *"); // Para evitar problemas al conectarse desde cualquier parte

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'GET') {

            $property = $this->Property_Model->getProperty();


            header('content-type: application/json');
            $response = array('success' => true, 'data' => $property, 'error' => ['title' => http_response_code(200), 'message' => "OK"]);
            echo json_encode($response);
        } else {

            header('content-type: application/json');
            $response = array('success' => false, 'data' => [], 'error' => ['title' => http_response_code(404), 'message' => "Not Found"]);
            echo json_encode($response);
        }
    }

    public function updateProperty()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'PUT') {

            $json = file_get_contents('php://input');
            $data = json_decode($json);
            $this->Property_Model->updateProperty($data);

            //Validar campos vacíos
            if ($data->title == "" || $data->type == "" || $data->address == "" || $data->rooms == "" || $data->price == "" || $data->area == "") {
                $response = array('response' => 'Empty Input');
                echo json_encode($response);
            }

            //Validar tipo de propiedad que sea casa, habitacion u hostal
            else if ($data->type != 'casa' && $data->type != 'habitacion' && $data->type != 'hostal') {
                $response = array('response' => 'Invalid Input (Required: casa, hostal or habitacion)');
                echo json_encode($response);
            }

            //validar que los datos son de tipo String
            else if (!is_string($data->title) || !is_string($data->type)  || !is_string($data->address)) {
                $response = array('response' => 'Invalid Input (String required)');
                echo json_encode($response);
            }

            //validar que rooms, price y area son numéricos
            else if (!is_numeric($data->rooms) || !is_numeric($data->price) || !is_numeric($data->area)) {
                $response = array('response' => 'Invalid Input (Number required in rooms or price)');
                echo json_encode($response);
            }

            //validar que area es Int
            else if (!is_int($data->area)) {
                $response = array('response' => 'Invalid Input (Integer required in area)');
                echo json_encode($response);
            } else {
                http_response_code(200);
                header('content-type: application/json');
                $response = array('response' => 'Property Successfully updated');
                echo json_encode($response);
            }
        } else {

            header('content-type: application/json');
            $response = array('response' => 'There was a problem updating');
            echo json_encode($response);
        }
    }


    public function deleteProperty()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'DELETE') {

            $json = file_get_contents('php://input');
            $data = json_decode($json);
            $this->Property_Model->deleteProperty($data);

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
}
