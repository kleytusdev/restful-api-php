<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
  public function create()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(!empty($data)){
      echo User::create([
        "firstname" => $data['firstname'],
        "dni" => $data['dni'],
        "lastname" => $data['lastname'],
        "phone" => $data['phone'],
        "email" => $data['email'],
        "address" => $data['address']
      ]);

    }else{
      echo "Ingrese los campos necesarios";
    }
    
  }

  public function getall()
  {
    echo User::get();
  }

  public function getById()
  {
    echo User::where('id', 1, '=');
  }

  public function delete()
  {
    $id = explode('/',$_SERVER['REQUEST_URI'])[4];
    var_dump($id);
    echo User::delete($id);
  }
}