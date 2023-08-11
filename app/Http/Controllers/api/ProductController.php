<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    //
    public function index() {
        $list_product = Product::all();
        if($list_product->count() > 0) {
            return response()->json(['status'=>200, 'data'=>$list_product],200);
        } else {
            return response()->json(['status'=>200, 'message'=>'no data'],200);
        }
        
    }

    public function addProduct(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:200',
            'description' => 'required|max:255',
            'quantity' => 'required',
            'price' => 'required'
        ]);

        if($validator-> fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ],422);
        } 
        else {
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'price' => $request->price
            ]);

            if($product) {
               return response()-> json([
                    'status'=> 200,
                    'message'=> 'Product Successfully Created',
                    'data' => $product
               ],200);     
            } else {
                return response()-> json([
                    'status' => 500,
                    'message' => "Something went Wrong!"
                ],500);
            }
        }
    }

    public function findById($id) {
        $product = Product::find($id);
        if($product) {
            return response()->json([
                'status' => 200,
                'data' => $product
            ],200);
        } else {
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => "no product with id ".$id
            ],500);
        }
        
    }

    public function deleteById($id) {
        $product = $this->findById($id);
        if($product) {
            $product->delete();
            return response()->json([
                'status'=> 200,
                'message'=> 'product with id ' .$id. ' delete successfully'
            ]);
        } else {
            return response()->json([
                'status'=> 400,
                'message'=> 'no product with id '.$id
            ]);
        }
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:200',
            'description' => 'required|max:255',
            'quantity' => 'required',
            'price' => 'required'
        ]);

        if($validator-> fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ],422);
        } else {
            $product = Product::find($id);
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'price' => $request->price
            ]);

            if($product) {
                return response()->json([
                    'status' => 200,
                    'message' => 'update successfully with id '.$id,
                    'data' => $product
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'update failed with id '.$id
                ]);
            }
        }
    }

    public function createProduct() {
        for($i=0; $i < 100; $i++) {

            $product = new Product([
                "name"=> "product " . $i,
                "description"=> "product ". $i ." description",
                "quantity"=> 10 + $i,
                "price"=> 25000 + $i
            ]);

            $product->save();
        }
    }

    
    
}
