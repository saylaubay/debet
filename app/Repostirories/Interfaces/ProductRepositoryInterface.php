<?php


namespace App\Repostirories\Interfaces;


interface ProductRepositoryInterface
{

    public function findAll();

    public function findById($id);

    public function save($product);

    public function deleteById($id);

}
