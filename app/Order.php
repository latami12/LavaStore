<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   public function user()
   {
       return $this->belongsTo('App\User', 'customer_id', 'id');
   }

   public function order_detail()
   {
       return $this->hasMany('App\OrderDetail', 'order_id', 'id');
   }

   public function product()
   {
       return $this->belongsTo('App\Product', 'product_id', 'id');
   }
}
