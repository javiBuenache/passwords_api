<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    protected $table = 'passwords';
    protected $fillable = ['title','password','category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function register($title, $password, $category_id)
    {
        $password = new Password();
        $password->title = $request->title;
        $password->password = $request->password;
        $password->category_id = $category->id;             
        $password->save();
    }
}
