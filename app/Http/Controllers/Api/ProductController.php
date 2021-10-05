<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Support\ApiResponseHelpers;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ApiResponseHelpers;

    public function index($id = null)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'nullable|exists:product_categories,id'
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        if ($id) {
            return new ProductResource(Product::with('category')->find($id));
        } else {
            return ProductResource::collection(Product::with('category')->get());
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:product_categories,id',
            'name' => 'required|unique:products,name',
            'code' => 'required|unique:products,code',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->code = $request->code;
        $product->product_category_id = $request->category;
        $product->price = $request->price;
        $product->unit = $request->unit;
        $product->save();

        $product->load('product_category');

        return $this->storeSuccess('Product Created', ['product' => new ProductResource($product)]);
    }
}
