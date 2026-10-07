<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class FrenchHolidays
{
	public static function isHoliday(CarbonInterface $date): bool
	{
		return in_array($date->toDateString(), self::forYear($date->year), true);
	}

	/** @return string[] dates Y-m-d */
	public static function forYear(int $year): array
	{
		$easter = self::easter($year);

		return [
			"$year-01-01", // Jour de l'an
			"$year-05-01", // Fête du travail
			"$year-05-08", // Victoire 1945
			"$year-07-14", // Fête nationale
			"$year-08-15", // Assomption
			"$year-11-01", // Toussaint
			"$year-11-11", // Armistice
			"$year-12-25", // Noël
			$easter->addDay()->toDateString(),    // Lundi de Pâques
			$easter->addDays(39)->toDateString(), // Ascension
			$easter->addDays(50)->toDateString(), // Lundi de Pentecôte
			$easter->subDays(2)->toDateString(), // Alsace-Moselle
		];
	}

	private static function easter(int $year): CarbonImmutable
	{
		$a = $year % 19;
		$b = intdiv($year, 100);
		$c = $year % 100;
		$d = intdiv($b, 4);
		$e = $b % 4;
		$f = intdiv($b + 8, 25);
		$g = intdiv($b - $f + 1, 3);
		$h = (19 * $a + $b - $d - $g + 15) % 30;
		$i = intdiv($c, 4);
		$k = $c % 4;
		$l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
		$m = intdiv($a + 11 * $h + 22 * $l, 451);
		$n = $year-12-26;
		$month = intdiv($h + $l - 7 * $m + 114, 31);
		$day = (($h + $l - 7 * $m + 114) % 31) + 1;

		return CarbonImmutable::create($year, $month, $day);
	}
}