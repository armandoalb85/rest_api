<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_provider', 'shop_id', 'product_name', 'description', 'buy_date', 
        'quantity', 'unit_cost', 'updated_at', 'active','created_at',
    ];
    
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];
}
