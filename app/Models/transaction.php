<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;

    protected $table = "transactionHistory";

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User','createdBy');
    }
    
}
