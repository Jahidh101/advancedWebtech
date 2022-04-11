<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\All_user;


class User_type extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function all_users(){
        return $this->hasMany(All_user::class);
    }
}
