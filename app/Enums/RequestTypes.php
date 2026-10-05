<?php

namespace App\Enums;

enum RequestTypes:string {
	case DayOff = 'congés';
	case Recovery = 'récuperation';
}