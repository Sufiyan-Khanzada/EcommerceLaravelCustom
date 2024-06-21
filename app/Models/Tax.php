<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $table = 'taxes';
    protected $primaryKey = 'tax_id';
    protected $guarded = ['tax_id'];
    
    
}
