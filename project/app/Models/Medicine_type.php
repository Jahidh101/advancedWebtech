<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Medicine;

class Medicine_type extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function medicines(){
        return $this->hasMany(Medicine::class,'type');
    }

}
