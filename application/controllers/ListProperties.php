<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ListProperties extends CI_Controller
{

    //url base
    //http://localhost:8081/Momento3/ListProperties/

    public function index()
    {
    }

    //Show all user's properties
    public function getListProperties()
    {
        header("Access-Control-Allow_Origin: *"); // Para evitar problemas al conectarse desde cualquier parte

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'GET') {

            $userProperties = $this->User_Model->listUserProperties();

            header('content-type: application/json');
            $response = array('success' => true, 'data' => $userProperties, 'error' => ['title' => http_response_code(200), 'message' => "Data OK"]);
            echo json_encode($response);
        } else {

            header('content-type: application/json');
            $response = array('success' => false, 'data' => [], 'error' => ['title' => http_response_code(404), 'message' => "Data Not Found"]);
            echo json_encode($response);
        }
    }

    //Show all user's properties in order

    public function getSortedProperties()
    {
        header("Access-Control-Allow_Origin: *"); // Para evitar problemas al conectarse desde cualquier parte

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'GET') {

            $userProperties = $this->User_Model->getPropertiesSorted();

            //http_response_code(200);
            header('content-type: application/json');
            $response = array('success' => true, 'data' => $userProperties, 'error' => ['title' => http_response_code(200), 'message' => "Data OK"]);
            echo json_encode($response);
        } else {

            header('content-type: application/json');
            $response = array('success' => false, 'data' => [], 'error' => ['title' => http_response_code(404), 'message' => "Data Not Found"]);
            echo json_encode($response);
        }
    }

    //Show all the properties of an User ordered by price

    public function getSortedUserProperties()
    {
        header("Access-Control-Allow_Origin: *"); // Para evitar problemas al conectarse desde cualquier parte

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'GET') {

            $userProperties = $this->User_Model->getUserPropertiesSorted();


            header('content-type: application/json');
            $response = array('success' => true, 'data' => $userProperties, 'error' => ['title' => http_response_code(200), 'message' => "Data OK"]);
            echo json_encode($response);
        } else {

            header('content-type: application/json');
            $response = array('success' => false, 'data' => [], 'error' => ['title' => http_response_code(404), 'message' => "Data Not Found"]);
            echo json_encode($response);
        }
    }
}
