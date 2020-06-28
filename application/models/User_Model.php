<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_Model extends CI_Model
{


    public function getUser()
    {
        $property = $this->db->query("SELECT * FROM users")->result();
        return $property;
    }

    public function addUser($user)
    {
        $this->db->insert('users', $user);
    }

    public function updateUser($user)
    {
        $id = $user->id;
        $name = $user->name;
        $lastname = $user->lastname;
        $email = $user->email;
        $type_id = $user->type_id;
        $identification = $user->identification;


        $user = $this->db->query("UPDATE users SET name ='${name}', lastname ='${lastname}', email ='${email}', type_id ='${type_id}', identification ='${identification}' WHERE id = ${id}");
    }


    public function deleteUser($id)
    {
        $response = $this->db->query("DELETE FROM users WHERE id={$id->id}");
    }

    public function getOneUser($email)
    {

        $oneUser = $this->db->query("SELECT * FROM users WHERE email = '{$email}'")->result();
        return $oneUser;
    }

    public function listUserProperties()
    {
        $property = $this->db->query(" SELECT usersxproperty.id, usersxproperty.property_id, usersxproperty.user_id, title, type, address, rooms, price, area FROM property INNER JOIN usersxproperty ON usersxproperty.property_id = property.id WHERE usersxproperty.user_id>0 ")->result();
        return $property;
    }

    public function getPropertiesSorted()
    {
        $property = $this->db->query("SELECT usersxproperty.id, usersxproperty.property_id, usersxproperty.user_id, title, type, address, rooms, price, area FROM property INNER JOIN usersxproperty ON usersxproperty.property_id = property.id WHERE usersxproperty.user_id>0 ORDER BY price ASC")->result();
        return $property;
    }

    public function getUserPropertiesSorted()
    {
        $property = $this->db->query("SELECT usersxproperty.id, usersxproperty.property_id, usersxproperty.user_id, title, type, address, rooms, price, area FROM property INNER JOIN usersxproperty ON usersxproperty.property_id = property.id WHERE usersxproperty.user_id=81 ORDER BY price ASC")->result();
        return $property;
    }
}
