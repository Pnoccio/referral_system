<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function addProduct(Request $request){
    try{
      // validate the requested data
      $validateData = $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|numeric|min:0'
      ]);

      //create the product
      $product = Product::create($validateData);

      //returning a JSON response with the created product details
      $response = [
        'status' => 201,
        'product' => $product,
        'message' => 'Product has added',
      ];
    }catch(Exception $error){
      // handle exception
      $response = [
        'status' => 500,
        'message' => $error->getMessage()
      ];
    }

    return response()->json($response);
  }
}
