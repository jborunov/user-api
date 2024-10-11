<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'userName' => $this->user_name,
            'countryName' => config('countries.' . $this->country_code),
            'ipAddressSum' => $this->ip_address ? array_sum(explode('.', $this->ip_address)) : 0,
        ];
    }
}