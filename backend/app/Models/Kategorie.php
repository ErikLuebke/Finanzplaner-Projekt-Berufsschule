<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategorie extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'kategorie';
    protected $primaryKey = 'kategorieid';

    protected $fillable = [
        'bezeichnung',
    ];
}