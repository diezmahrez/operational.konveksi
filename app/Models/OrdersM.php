<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersM extends Model
{
    use HasFactory;
    protected $table = 'dt_orders';

    protected $guarded = [];
}
