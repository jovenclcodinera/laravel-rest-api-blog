<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelpers;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $products = Product::all();
        $response = ApiHelpers::createApiResponse(false, 200, "", $products);
        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $is_product_saved = $product->save();
        if ($is_product_saved) {
            $code = 201;
            $message = "Product successfully inserted";
        } else {
            $code = 400;
            $message = "Error has occurred: Product not saved";
        }
        $response = ApiHelpers::createApiResponse(!$is_product_saved, $code, $message, null);
        return response()->json($response, $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $product =  Product::find($id);
        if (is_null($product))
            $message = "No Product fetched for this request";
        else
            $message = "";
        $response = ApiHelpers::createApiResponse(false, 200, $message, $product);
        return \response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            $code = 200;
            $message = "Product {$id} does not exists";
            $is_product_updated = false;
        } else {
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $is_product_updated = $product->update();
            if ($is_product_updated) {
                $code = 200;
                $message = "Product was updated successfully";
            } else {
                $code = 400;
                $message = "Error occurred: Product was not updated";
            }
        }
        $response = ApiHelpers::createApiResponse(!$is_product_updated, $code, $message, $product);
        return \response()->json($response, $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            $code = 200;
            $message = "Product {$id} does not exists";
            $is_product_deleted = false;
        } else {
            $is_product_deleted = $product->delete();
            if ($is_product_deleted) {
                $code = 200;
                $message = "Product was deleted successfully";
            } else {
                $code = 400;
                $message = "Error occurred: Product was not deleted";
            }
        }
        $product = null;
        $response = ApiHelpers::createApiResponse(!$is_product_deleted, $code, $message, $product);
        return \response()->json($response, $code);
    }
}
