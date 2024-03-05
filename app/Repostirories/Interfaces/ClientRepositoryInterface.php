<?php


namespace App\Repostirories\Interfaces;


use Ramsey\Uuid\Type\Integer;

interface ClientRepositoryInterface
{

    public function save($first_name, $last_name, $phone, $company_id);

    public function deleteById($id);

    public function findByPhone($phone);

    public function update($id, $client);

    public function findById($id);

    public function findAll();


    public function findByCreatedByOrderByFirstName($id);

    public function existsByPhone($phone);

    public function existsByPhoneAndCreatedBy($phone, $id);

    public function findAllByOrderByFirstName();


}
