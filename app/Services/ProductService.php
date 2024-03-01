<?php


namespace App\Services;


use App\Models\ApiResponse;

class ProductService extends BaseService
{

    public function getAll()
    {
        $products = $this->productRepository->findAll();
        return new ApiResponse("Productlar dizimi : ", true, $products);
    }

    public function getOne($id)
    {
        $product = $this->productRepository->findById($id);
        if ($product == null){
            return new ApiResponse("Bunday id li product tabilmadi!!!", false);
        }
        return new ApiResponse("Product : ", true, $product);
    }

    public function save($product)
    {
        $product = $this->productRepository->save($product);
        if (!$product){
            return new ApiResponse("Bunday Product bazada bar!!!", false);
        }
        return new ApiResponse("Saqlandi !!! ", true, $product);
    }

    public function update($id, $request)
    {
        $product = $this->productRepository->findById($id);
        if ($product == null){
            return new ApiResponse("Bunday id li product tabilmadi!!!", false);
        }
        $product->name = $request->name;
        $product->model = $request->model;
        $product->save();
        return new ApiResponse("Product : ", true, $product);
    }

    public function destroy($id)
    {
        $product = $this->productRepository->deleteById($id);
        if (!$product){
            return new ApiResponse("Bunday id li product bazadan tabilmadi!!!", false);
        }
        return new ApiResponse("Product o`shirildi!!!", true);
    }

}
