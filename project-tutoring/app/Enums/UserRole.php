<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'Admin';
    case Guru = 'Guru';
    case Siswa = 'Siswa';

    /**
     * Role yang boleh dipilih saat registrasi atau oleh Admin.
     * Akun Admin hanya dibuat lewat seeder.
     *
     * @return list<self>
     */
    public static function assignable(): array
    {
        return [self::Guru, self::Siswa];
    }
}
