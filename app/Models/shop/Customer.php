<?php

namespace App\Models\shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Address;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brands_id',
        'email',
        'phone',
        'birthday',
    ];

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
