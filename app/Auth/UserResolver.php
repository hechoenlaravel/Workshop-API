<?php

namespace App\Auth;

use App\User;

/**
 * Class UserResolver
 * @package App\Auth
 */
class UserResolver
{


    /**
     * @param $id
     * @return mixed
     */
    public function resolveById($id)
    {
        return User::findOrFail($id);
    }

}