<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController
{
  public function index()
  {
    return Category::where('id', '=', 1);
  }

  public function store()
  {
    return Category::create([
      'name' => 'Category 1'
    ]);
  }
}