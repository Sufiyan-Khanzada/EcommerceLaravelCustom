<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BottomMenu extends Model
{
    use HasFactory;
  
    protected $table = "bottom_menus";
    protected $primaryKey = 'bottom_menu_id';
    protected $guarded = ["bottom_menu_id"];
}
