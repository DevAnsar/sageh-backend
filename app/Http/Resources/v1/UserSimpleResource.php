<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserSimpleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        //test user
        $user1=User::find(1);
        $user2=User::find(2);

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'family' => $this->family,
            'brand' => $this->brand,
            'username' => $this->username,
            'avatar' => $this->avatar ? Storage::url($this->avatar['url']) : null,

        ];
        if (showMobileRoles($user1,$user2)) {
            if (isMobile($this->mobile))
                $data = array_merge($data, [
                    'tell' => $this->mobile
                ]);
        }

        return $data;
    }
}
