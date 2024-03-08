<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController
{
  public function index()
  {
    return Category::where('name', 'LIKE', 'C%');
  }

  public function store()
  {
    return Category::create([
      'name' => 'Category 1'
    ]);
  }
}