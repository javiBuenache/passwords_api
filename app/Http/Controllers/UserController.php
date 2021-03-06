<?php

namespace App\Http\Controllers;

use App\User;
use App\Helpers\Token;
use App\Category;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function login(Request $request)
    {
        if ($request->email == null || $request->password == null) 
        {
            return response()->json([
                'alert' => 'Error: Inserte un email y un password'],
                400
            );
        }

        $user = User::where('email', $request->email)->first();
        $token = new Token($user->email);
        $encoded_token = $token->encode();

        if($user->password == $request->password)
        {
            return response()->json([
                "token" => $encoded_token
            ], 200 );
        
        }else
        {
            return response()->json([
                "message" => "no tiene permisos"
            ], 401);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        
        return response()->json([
            "usuarios" => $users
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

        if ($request->name == null || $request->email == null || $request->password == null) 
        {
            return response()->json([
                'alert' => 'Error: Inserte un nonbre, un email y un password'],
                400
         );
        }

        $user = new User();
       
        if(!$user->checkUsers($request->email))
        {
            
            $user->register($request);

            $token = new Token($user->email);
            $encoded_token = $token->encode();
        
            return response()->json(["token" => $encoded_token
                ], 200);
        }
        else
        {
            return response()->json(["Error" => "este correo ya existe"]);
        }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
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
        $user_change = $request->user;   

        $user = User::find($id);
        
        if($user_change->id == $user->id)
        {            
            $user = new User();
            $user->register($request);
            
            return response()->json([
                "message" => "usuario modificado"
            ], 200);
        }
        else
        {
           return response()->json([
                "message" => "no tiene permisos"
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user;

        if($user->id == $id)
        {
            $user->delete();  
            return response()->json([
                "message" => "usuario borrado"
            ], 200);

        }else
        {
            return response()->json([
                "message" => "no tiene permisos"
            ], 401);
         }
    }
}
