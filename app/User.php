<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name','email','password'];


    public function register(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->password = $request->password;
        $user->email = $request->email;
        $user->save();
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function passwords()
    {
        return $this->hasManyThrough('App\Password', 'App\Category');
    }
}
