<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tabla extends Model {
    protected $table = 'tabla';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'desc'];
    public $timestamps = false;
}