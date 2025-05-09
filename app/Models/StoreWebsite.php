<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreWebsite extends Model
{
    protected $table = 'store_website';

    protected $primaryKey = 'website_id';
    
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'website_id',
        'code',
        'name',
    ];
}
