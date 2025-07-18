<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    protected $table = 'places';
    protected $id = 'id';
    protected $fillable = ['name'];
    public $timestamps = false;
}
