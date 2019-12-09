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

    Public function checkUsers($email)
    {
        $users = self::where('email',$email)->first();
        
       if(!is_null($users))
        {
            return true;
        }

        return false;
    }


    public function categories()
    {
        return $this->hasMany('App\Category','user_id');
    }

    public function passwords()
    {
        return $this->hasManyThrough('App\Password', 'App\Category');
    }
}
