<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name','email','password'];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function passwords()
    {
        return $this->hasManyThrough('App\Password', 'App\Category');
    }
}
