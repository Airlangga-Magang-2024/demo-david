<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
       'street',
       'zip',
       'city',
       'country',
       'state',
       'addressable_id',
       'addressable_type',
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
