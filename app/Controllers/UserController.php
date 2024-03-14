<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
  public function store()
  {
    User::create([
      'email' => 'john@doe.com',
      'password' => 'secret'
    ]);
  }
}