<?php


namespace App\Repostirories;


use App\Models\Product;
use App\Repostirories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{

    public function findAll()
    {
        return Product::all();
    }

    public function findById($id)
    {
        return Product::find($id);
    }

    public function save($product)
    {
        $prod = Product::where('name', $product->name)->exists();
//        dd($prod);
        if ($prod){
            return false;
        }
         Product::create([
            "name" => $product->name,
            "model" => $product->model,
        ]);
        return true;
    }

    public function deleteById($id)
    {
        return Product::destroy($id);
    }

    public function delete($product)
    {
        // TODO: Implement delete() method.
    }

    public function deleteAllById($ids)
    {
        // TODO: Implement deleteAllById() method.
    }

    public function deleteAll($products)
    {
        // TODO: Implement deleteAll() method.
    }
}
