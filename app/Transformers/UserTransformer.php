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

    protected $availableIncludes = ['latestPosts', 'user'];

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

    public function includeLatestPosts(User $user)
    {
        $posts = $user->posts()->orderBy('created_at', 'DESC')->take(5)->get();
        return $this->collection($posts, new PostTransformer());
    }

    public function includeUser(User $user)
    {
        return $this->item($user, new UserTransformer());
    }

}