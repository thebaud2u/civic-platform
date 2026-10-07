<?php

namespace App\Enums;

enum AbsenceType:string {
	case DayOff = 'day_off';
	case Recovery = 'recovery';

	public function label(): string
    {
        return match ($this) {
            self::DayOff => 'Congés',
            self::Recovery => 'Récupération',
        };
    }
}