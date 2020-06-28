<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Property_Model extends CI_Model
{


    public function getProperty()
    {
        $property = $this->db->query("SELECT * FROM property")->result();
        return $property;
    }

    public function addProperty($property)
    {
        $this->db->insert('property', $property);
    }

    public function updateProperty($property)
    {
        $id = $property->id;
        $title = $property->title;
        $type = $property->type;
        $address = $property->address;
        $rooms = $property->rooms;
        $price = $property->price;
        $area = $property->area;

        $property = $this->db->query("UPDATE property SET title ='${title}', type ='${type}', address ='${address}', rooms ='${rooms}', price ='${price}', area ='${area}' WHERE id = ${id}");
    }


    public function deleteProperty($id)
    {
        $response = $this->db->query("DELETE FROM property WHERE id={$id->id}");
    }
}
