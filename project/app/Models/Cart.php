<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\All_user;
use App\Models\Medicine;
use App\Models\Order_list;

class Cart extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function patients(){
        return $this->belongsTo(All_user::class,'username','username');
    }

    public function medicines(){
        return $this->belongsTo(Medicine::class);
    }

    public function order_lists(){
        return $this->belongsTo(Order_list::class, 'order_id', 'order_id');
    }

    
}
