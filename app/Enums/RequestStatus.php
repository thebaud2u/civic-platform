<?php

namespace App\Enums;

enum RequestStatus:string {
	case Pending = 'en attente';
	case Approved = 'acceptée';
	case Rejected = 'refusée';
	case Canceled = 'annulée';
}