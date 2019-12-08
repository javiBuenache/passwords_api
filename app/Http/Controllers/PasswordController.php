<?php

namespace App\Http\Controllers;

use App\Password;
use App\Category;

use Illuminate\Http\Request;


class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $passwords = Password::all();

        return response()->json([
            "passwords" => $passwords
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data_token = $request->header('Authorization');
        $token = new Token();
        $user_email = $token->decode($data_token);
        $user = User::where('email', '=', $user_email)->first();

        $category = Category::where('name', $request->category)->first();
        if($category->user_id == $user->id)
        {
        $password = new Password();
        $password->title = $request->title;
        $password->password = $request->password;
        $password->category_id = $category->id;             
        $password->save();

        return response()->json([
            "message" => "contrasena creada"
        ], 201 );

         } else
        {
        return response()->json([
            "message" => " categoría no encontrada"
        ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data_token = $request->header('Authorization');
        $token = new Token();
        $user_email = $token->decode($data_token);
        $user = User::where('email', '=', $user_email)->first();

        return response()->json([
            "passwords" => $user->passwords
        ], 200);
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
    public function update(Request $request, $id)
    {
        $password = Password::where('id','=', $id)->first();
        //var_dump($request->title); exit;
        $password->title = $request->title;
        $password->password= $request->password;
        $password->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data_token = $request->header('Authorization');
        $token = new Token();
        $user_email = $token->decode($data_token);
        $user = User::where('email', '=', $user_email)->first();

        $password = Password::find($id);
        $category = $password->category;
                
        if( $user->id == $category->user_id)
        {
            $password->delete();

            return response()->json([
                "message" => "password borrado"
    
            ], 201 );

        }else
        {
            return response()->json([
                "message" => "no se puede borrar un password ajeno"
            ], 401);
        }
    }
}
