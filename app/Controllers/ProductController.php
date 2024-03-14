<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController
{
  public function index()
  {
    return Product::all();
  }

  public function store()
  {
    return Product::create([
      'name' => 'Product 1',
      'description' => 'Product description',
      'price' => 10,
      'stock' => 20,
      'category_id' => 1,
      'supplier_id' => 1,
    ]);
  }
}
