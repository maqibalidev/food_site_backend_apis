<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Product ;
class productController extends Controller
{


public function getProducts(){

$products = Product::all();
 return json_encode(['status' => 200,'message'=>'success', 'products' => $products]);



}


}
