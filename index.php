<?php

header('Content-Type: application/json');

require 'vendor/autoload.php';
require 'autoload.php';

use App\Models\Category;
use App\Models\Product;

echo Product::get();
// echo Category::update();
