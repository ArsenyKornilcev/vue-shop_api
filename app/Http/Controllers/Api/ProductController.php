<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function all()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function create(Request $request)
    {
        $data = $request->only('title', 'description', 'price', 'imgSrc');

        $validator = Validator::make($data, [
            'title' => 'required|string|max:30|unique:products',
            'description' => 'string|max:255',
            'price' => 'required|float',
            'imgSrc' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Product::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Товар успешно добавлен в каталог'
        ], 201);
    }

    public function update(Request $request)
    {
        $data = $request->only('id', 'title', 'description', 'price', 'imgSrc');

        $validator = Validator::make($data, [
            'title' => 'required|string|max:30|unique:products',
            'description' => 'string|max:255',
            'price' => 'required|float',
            'imgSrc' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Данные не корректны'
            ], 400);
        }

        $product = Product::find($data[0]);

        $product->title = $data[1];
        $product->description = $data[2];
        $product->price = $data[3];
        $product->imgSrc = $data[4];

        $product->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Товар успешно обновлен'
        ], 200);
    }

    public function delete(Request $request)
    {
        $data = $request->only('id');

        $validator = Validator::make($data, [
            'id' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Данные не корректны'
            ], 400);
        }

        $product = Product::find($data[0]);

        $product->delete();
    }
}
