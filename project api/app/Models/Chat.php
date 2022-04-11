<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\All_user;


class Chat extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function all_users_s(){
        return $this->belongsTo(All_user::class,'sender','username');
    }

    public function all_users_r(){
        return $this->belongsTo(All_user::class,'receiver','username');
    }

}
