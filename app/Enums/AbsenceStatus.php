<?php

namespace App\Enums;

enum AbsenceStatus:string {
	case Pending = 'pending';
	case Approved = 'approved';
	case Rejected = 'rejected';
	case Canceled = 'canceled';

	public function label(): string
    {
        return match ($this) {
            self::Pending => 'En attente',
            self::Approved => 'Acceptée',
            self::Rejected => 'Refusée',
            self::Canceled => 'Annulée',
        };
    }
}