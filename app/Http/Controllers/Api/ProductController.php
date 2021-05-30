<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{

    public function index()
    {
        try{
            $products=Product::all();
            return response()->json([
                'success'=>true,
                'message'=>"All Products",
                'data'=>$products,

            ]);
        }catch (\Exception $exception){
            return response()->json([
                'success'=>false,
                'message'=>$exception->getMessage(),
                ]);
        }
    }


    public function create(Request $request){
        try {
            $request->validate([
                'name' => 'required',
                'price' => 'required|numeric',
                'description' => 'required',
                'photo' => 'required|max:1024',
            ]);


            $photo = $request->file('photo');
            $filename = time() . '_product.' . $photo->getClientOriginalExtension();
            $request->photo->move('assets/uploads', $filename);
            $product = Product::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'photo' => $filename
            ]);

            return response()->json([
                'success'=>true,
                'message'=>"Product created",
                'data'=>$product,

            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'success'=>false,
                'message'=>$exception->getMessage()
            ]);
        }


    }
}
