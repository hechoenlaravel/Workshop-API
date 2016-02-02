<?php

namespace App\Http\Controllers\Auth;

use Authorizer;
use App\Http\Requests;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

/**
 * Class OAuthController
 * @package App\Http\Controllers\Auth
 */
class OAuthController extends Controller
{

    use Helpers;

    /**
     * Issue an access token
     * @return mixed
     */
    public function authorizeClient()
    {
        return $this->response->array(Authorizer::issueAccessToken());
    }
}
