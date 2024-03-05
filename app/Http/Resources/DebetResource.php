<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DebetResource extends JsonResource
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
            "month_name"=>$this->month_name,
            "summa"=>$this->summa,
            "contract_id"=>new ContractResource($this->contract),
            "paid"=>$this->paid,
            "pay_date"=>$this->pay_date,
            "active"=>$this->active,
            "desc"=>$this->desc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
