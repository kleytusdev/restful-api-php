<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController
{
  public function create_category()
  {
    echo Category::add();
  }
}