<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name','user_id'];
    

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function passwords()
    
    {
        return $this->hasMany('App\Password','category_id');
    }

    public function register($name, $user_id)
    {
        $category = new Category;
        $category->name = $name;
        $category->user_id = $user_id;
        $category->save();

        return $category;
    }
}
