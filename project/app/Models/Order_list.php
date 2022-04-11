<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\All_user;
use App\Models\Cart;

class Order_list extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function petients(){
        return $this->belongsTo(All_user::class,'username','username');
    }

    public function delivary_man(){
        return $this->belongsTo(All_user::class,'delivary_username','username');
    }

    public function seller(){
        return $this->belongsTo(All_user::class,'seller_username','username');
    }

    public function carts(){
        return $this->hasMany(Cart::class, 'order_id', 'order_id');
    }

}
