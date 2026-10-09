<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Administratora dati tiek ņemti no vides mainīgajiem.
        $adminName = env('ADMIN_NAME');
        $adminEmail = env('ADMIN_EMAIL');
        $adminPassword = env('ADMIN_PASSWORD');

        // Ja administratora dati nav norādīti,
        // seeder neizveido kontu ar nedrošu noklusējuma paroli.
        if (!$adminName && !$adminEmail && !$adminPassword) {
            $this->command?->warn(
                'Administrators nav izveidots. '
                . 'Norādi ADMIN_NAME, ADMIN_EMAIL un ADMIN_PASSWORD.'
            );

            return;
        }

        // Ja norādīta tikai daļa datu, pārtrauc darbību.
        if (!$adminName || !$adminEmail || !$adminPassword) {
            throw new RuntimeException(
                'Administratora izveidei nepieciešami '
                . 'ADMIN_NAME, ADMIN_EMAIL un ADMIN_PASSWORD.'
            );
        }

        if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException(
                'ADMIN_EMAIL nav derīga e-pasta adrese.'
            );
        }

        if (
            strlen($adminPassword) < 8 ||
            !preg_match('/[A-Z]/', $adminPassword) ||
            !preg_match('/[0-9]/', $adminPassword)
        ) {
            throw new RuntimeException(
                'ADMIN_PASSWORD jābūt vismaz 8 simbolus garai, '
                . 'ar vismaz vienu lielo burtu un vienu ciparu.'
            );
        }

        $existingUser = User::where('email', $adminEmail)->first();

        // Neļauj nejauši pārvērst parastu lietotāju par administratoru.
        if ($existingUser && $existingUser->role !== 'admin') {
            throw new RuntimeException(
                'Norādītais ADMIN_EMAIL jau pieder citam lietotājam.'
            );
        }

        // Esošam administratoram paroli nemaina.
        if ($existingUser) {
            $this->command?->info(
                'Administratora konts jau eksistē.'
            );

            return;
        }

        User::create([
            'name' => $adminName,
            'email' => $adminEmail,
            'password' => Hash::make($adminPassword),
            'role' => 'admin',
        ]);

        $this->command?->info(
            'Administratora konts veiksmīgi izveidots!'
        );
    }
}
