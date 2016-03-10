<?php

namespace App\Http\Controllers;


use Dingo\Api\Exception\UpdateResourceFailedException;
use Uuid;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response->paginator(User::paginate(10), new UserTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateUserRequest $request)
    {
        $data = $request->except('password_confirmation');
        $data['password'] = bcrypt($data['password']);
        $data['uuid'] = Uuid::generate(4)->string;
        $user = User::create($data);
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $user = User::where('uuid', $id)->firstOrFail();
            return $this->response->item($user, new UserTransformer());
        }catch (ModelNotFoundException $e){
            throw new NotFoundHttpException;
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateUserRequest $request, $id)
    {
        try{
            $user = User::where('uuid', $id)->firstOrFail();
            if($user->email !== $request->get('email')){
                $validator = app(Factory::class);
                $v = $validator->make($request->all(), [
                    'email' => 'unique:users,email'
                ]);
                if($v->fails()){
                    throw new UpdateResourceFailedException('Resource update failure', $v->errors()->getMessages());
                }
            }
            $user->fill($request->all());
            $user->save();
            return $this->response->item($user, new UserTransformer());
        }catch (ModelNotFoundException $e){
            throw new NotFoundHttpException;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = User::where('uuid', $id)->firstOrFail();
            $user->delete();
            return $this->response->noContent();
        }catch (ModelNotFoundException $e){
            throw new NotFoundHttpException;
        }
    }
}
