<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            "Todas las categorias" => $categories
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
        $category = new Category();
        $category->name = $request->name;
        $category->user_id = $user->id;
        $category->save();

        return response()->json([
            "message" => "categoria creada"
            
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data_token = $request->header('Authorization');
        $token = new Token();
        $user_email = $token->decode($data_token);
        $user = User::where('email', '=', $user_email)->first();

        return response()->json([
            "categorias creadas" => $user->categories
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
        //
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

        $category = Category::find($id);
        $user= $category->user;

        if( $user->id == $category->user_id)
        {
            $category->delete();

            return response()->json([
            "message" => "categoria borrada"
        ], 201 );
        }
        else
        {
            return response()->json([
                "message" => "no se puede borrar la categoría"
            ], 401);
        }
    }
}
