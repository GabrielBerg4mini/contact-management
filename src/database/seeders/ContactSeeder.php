<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            ['name' => 'Maria Oliveira', 'contact' => '912345678', 'email' => 'maria@example.com'],
            ['name' => 'João Pereira', 'contact' => '923456789', 'email' => 'joao@example.com'],
            ['name' => 'Ana Fernandes', 'contact' => '934567890', 'email' => 'ana@example.com'],
        ];

        foreach ($contacts as $data) {
            Contact::updateOrCreate(['email' => $data['email']], $data);
        }
    }
}
