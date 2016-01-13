<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 * @package App\Transformers
 */
class UserTransformer extends TransformerAbstract
{

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->uuid,
            'email' => $user->email,
            'name' => $user->name,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];
    }

}