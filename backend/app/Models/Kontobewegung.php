<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontobewegung extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'kontobewegung';
    protected $primaryKey = 'kontobewegungid';

    protected $fillable = [
        'konto_id',
        'kategorie_id',
        'date',
        'fix',
        'geldwert',
    ];

    public function konto() {
        return $this->belongsTo(Konto::class, 'konto_id', 'kontoid');
    }

    public function kategorie() {
        return $this->belongsTo(Kategorie::class, 'kategorie_id', 'kategorieid');
    }
}

