<?php

namespace App\Enums;

enum ElectionPeriodStatus: string
{
    case Draft = 'DRAFT';
    case Voting = 'VOTING';
    case Done = 'DONE';
}
