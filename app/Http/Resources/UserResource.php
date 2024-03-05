<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "first_name"=>$this->first_name,
            "last_name"=>$this->last_name,
            "username"=>$this->username,
            "email"=>$this->email,
            "phone"=>$this->phone,
            "company_id"=>new CompanyResource($this->company),
//            "company"=>new CompanyResource($this->company),
            "role_id"=>new RoleResource($this->role),
//            "role"=>new RoleResource($this->role),
            "balance"=>$this->balance,
//        "email_verified_at",
            "password"=>$this->password,
            "active"=>$this->active,
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
        ];
    }
}
