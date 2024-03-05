<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
//            "product_id"=>new ProductResource($this->product),
            "product"=>new ProductResource($this->product),
            "product_name"=>$this->product_name,
//            "user_id"=>new UserResource($this->user),
            "user"=>new UserResource($this->user),
            "price"=>$this->price,
//            "client_id"=>new ClientResource($this->client),
            "client"=>new ClientResource($this->client),
            "percent"=>$this->percent,
            "part"=>$this->part,
            "active"=>$this->active,
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
        ];
    }
}
