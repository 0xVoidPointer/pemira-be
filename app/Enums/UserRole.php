<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'ADMIN';
    case SuperAdmin = 'SUPER_ADMIN';
    case Mahasiswa = 'MAHASISWA';
}
