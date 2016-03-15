<?php

namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{

    public function transform(Post $model)
    {
        return [
            'id' => $model->uuid,
            'body' => $model->body,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

}