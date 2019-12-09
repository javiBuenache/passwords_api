<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use App\Helpers\Token;

use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function show_all_passwords_and_categories(Request $request)
    {
        $user = $request->user; 

        $user_all = Category::where('user_id', $user->id)->with('passwords')->get();
       
        return response()->json($user_all, 400);
    }
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

        $user = $request->user;

        $duplicate_category = Category::where('name', $request->name)->where('user_id',$user->id)->first();
      
        if (isset($duplicate_category)) 
        {
            return response()->json(["Error" => "el nombre ya existe"], 401);
        }
        else
        {
           $category->register($request->name,$user->id);

           return response()->json(["Success" => "categoria creada"], 201);
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
        $user = $request->user;

        $category = Category::find($id);                 
        
        if($user->id == $category->user_id)
        {            
            $category->name = $request->name;       
            $category->save();
            return response()->json([
                "message" => "category actualizada"
            ], 200);
        }else{
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
    public function destroy($id)
    {
        $user = $request->user;  

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
