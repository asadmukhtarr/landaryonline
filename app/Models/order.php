<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    public function orderdetails(){
        return $this->hasMany(orderdetail::class);
    }
    public function customer(){
        return $this->belongsTo(customer::class);
    }
    public function department(){
        return $this->belongsTo(department::class);
    }
}
