<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\All_user;


class Token extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    public function all_users(){
        return $this->belongsTo(All_user::class,'username','username');
    }

}
