<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sparziel extends Model
{
    protected $table = 'sparziel';
    protected $primaryKey = 'sparzielid';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 
        'anlagedatum', 
        'zielbetrag', 
        'zieldatum',
    ];

    public function sparzielAnlegen(float $zielbetrag, $zieldatum, int $userId): void
    {
        $this->user_id = $userId;
        $this->anlagedatum = now();
        $this->zielbetrag = $zielbetrag;
        $this->zieldatum = $zieldatum;
        $this->save();
    }

    public function sparzielBerechnen(float $aktuellerBetrag): float
    {
        $restbetrag = $this->zielbetrag - $aktuellerBetrag;
        $verbleibendMonat = now()->diffInMonths($this->zieldatum);

        if ($verbleibendMonat > 0) {
            return $restbetrag / $verbleibendMonat;
        }

        return 0;
    }

    public function preview(float $aktuellerBetrag)
    {
        $restbetrag = $this->zielbetrag - $aktuellerBetrag;

        $previewData = [
            'aktuellerBetrag'->$aktuellerBetrag,
            'restbetrah'->$restbetrag
        ];
        
        return $previewData;
    }
}
