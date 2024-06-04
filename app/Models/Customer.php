<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    
    protected $table = 'customers';

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'fname',
        'lname',
        'company',
        'email',
        'password',
        'phone',
        'address1',
        'address2',
        'country_id',
        'state_id',
        'city',
        'postalcode',
        'status',
        'workbook_status',
        'tax_exempt',
    ];

    protected $hidden = [
        'password'
    ];

    public $timestamps = false;
    
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
