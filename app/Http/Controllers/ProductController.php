<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;

class ProductController extends BaseController
{
    public function index()
    {
        $products = $this->productService->getAll();
        return $this->response($products);
    }

    public function store(ProductStoreRequest $request)
    {
        $product = $this->productService->save($request);
        return $this->response($product);
    }

    public function show($id)
    {
        $product = $this->productService->getOne($id);
        return $this->response($product);
    }

    public function update(ProductStoreRequest $request, $id)
    {
        $product = $this->productService->update($id, $request);
        return $this->response($product);
    }

    public function destroy($id)
    {
        $product = $this->productService->destroy($id);
        return $this->response($product);
    }
}
