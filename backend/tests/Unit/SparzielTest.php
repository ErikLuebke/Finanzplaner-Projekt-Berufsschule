<?php

namespace Tests\Unit;

use App\Models\Sparziel;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class SparzielTest extends TestCase
{
    public function test_sparzielBerechnen_gibt_monatlichen_sparbetrag_zurueck(): void
    {
        Carbon::setTestNow('2026-01-01 00:00:00');

        $sparziel = new Sparziel();
        $sparziel->zielbetrag = 1200;
        $sparziel->zieldatum = '2026-04-01';

        $ergebnis = $sparziel->sparzielBerechnen(0);

        $this->assertEquals(400.0, $ergebnis);

        Carbon::setTestNow();
    }

    public function test_sparzielBerechnen_gibt_null_zurueck_wenn_zieldatum_erreicht(): void
    {
        Carbon::setTestNow('2026-01-01 00:00:00');

        $sparziel = new Sparziel();
        $sparziel->zielbetrag = 1200;
        $sparziel->zieldatum = '2026-01-01';

        $ergebnis = $sparziel->sparzielBerechnen(0);

        $this->assertEquals(0, $ergebnis);

        Carbon::setTestNow();
    }
}
