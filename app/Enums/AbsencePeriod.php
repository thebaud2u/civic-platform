<?php

namespace App\Enums;

enum AbsencePeriod: string
{
	case Morning = 'morning';
	case Afternoon = 'afternoon';

	public function label(): string
    {
        return match ($this) {
            self::Morning => 'Matin',
            self::Afternoon => 'Après-midi',
        };
    }
}