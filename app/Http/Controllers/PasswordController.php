<?php

namespace App\Http\Controllers;

use App\Password;
use App\Category;
use App\User;
use App\Helpers\Token;
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
      
        $user = $request->user;

        //$user_email = $request->user->email;
        
       // $user = User::where('email', $user_email)->first();

        $category = Category::where('user_id', $user->id)->where('name', $request->name)->first();
        if (isset($category)) 
        {
            $password = new Password();
            $password->register($request, $category->id);
            return response()->json(['Message' => 'Password creada'], 201);    
        }
        else {
            return response()->json(['Message' => 'No se ha podido crear'], 401);    
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
        $user = $request->user;

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
        $user = $request->user;

        $password = Password::find($id);
        $category = $password->category;
        $user = $category->user;

        if($request_user == $user)
        {
            $password->title = $request->title;
            $password->password = $request->password;
            $password->save();

            return response()->json([
                "message" => "Contraseña actualizada"
            ], 200);
            
        }else{
            return response()->json([
                "message" => "no tiene autorización"
            ], 200);
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
         $user = $request->user;

        $password = Password::find($id);
        $category = $password->category;
        $user = $category->user;
                
        if($request_user == $user)
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
