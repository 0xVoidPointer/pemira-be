<?php

namespace App\Enums;

enum CandidateMemberRole: string
{
    case Individual = 'INDIVIDUAL';
    case Ketua = 'KETUA';
    case Wakil = 'WAKIL';
}
