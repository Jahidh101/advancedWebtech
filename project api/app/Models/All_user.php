<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User_type;
use App\Models\Login_history;
use App\Models\Cart;
use App\Models\Order_list;

class All_user extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function user_types(){
        return $this->belongsTo(User_type::class,);
    }

    public function login_history(){
        return $this->hasMany(Login_history::class,'username','username');
    }

    public function chats_s(){
        return $this->hasMany(Chat::class,'sender','username');
    }

    public function chats_r(){
        return $this->hasMany(Chat::class,'receiver','username');
    }
    public function carts(){
        return $this->hasMany(Cart::class,'username','username');
    }
    public function order_list_patients(){
        return $this->hasMany(Order_list::class,'username','username');
    }

    public function order_list_delivary_man(){
        return $this->hasMany(Order_list::class,'delivary_username','username');
    }

    public function order_list_seller(){
        return $this->hasMany(Order_list::class,'seller_username','username');
    }

}
