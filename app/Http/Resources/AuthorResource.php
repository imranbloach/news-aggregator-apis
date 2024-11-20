<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
 
class AuthorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'bio' => $this->bio,
            'profile_url' => $this->profile_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

