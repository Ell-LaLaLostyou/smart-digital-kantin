<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Canteen;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CanteenSeeder extends Seeder
{
    public function run(): void
    {
        $canteens = [
            [
                'name' => 'Kantin Bu Eka',
                'slug' => 'kantin-bu-eka',
                'description' => 'Menyediakan aneka nasi rames, ayam goreng, dan minuman segar dengan harga terjangkau.',
                'image_url' => 'canteens/canteen1.png',
                'admin_email' => 'eka@kantin.com',
            ],
            [
                'name' => 'Kantin Pak Imam',
                'slug' => 'kantin-pak-imam',
                'description' => 'Spesialis mie ayam, bakso, dan soto betawi asli yang lezat dan higienis.',
                'image_url' => 'canteens/canteen2.png',
                'admin_email' => 'imam@kantin.com',
            ],
            [
                'name' => 'Kantin Bu Iis',
                'slug' => 'kantin-bu-iis',
                'description' => 'Camilan sehat, gorengan hangat, dan berbagai jajanan pasar tradisional.',
                'image_url' => 'canteens/canteen3.png',
                'admin_email' => 'iis@kantin.com',
            ],
        ];

        foreach ($canteens as $data) {
            // 1. Create or Update Canteen
            $canteen = Canteen::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'image_url' => $data['image_url'],
                ]
            );

            // 2. Create or Update Admin for this Canteen
            $admin = User::updateOrCreate(
                ['email' => $data['admin_email']],
                [
                    'name' => 'Admin ' . $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'canteen_id' => $canteen->id,
                ]
            );

            // 3. Add Sample Menus
            $menus = [
                ['name' => 'Nasi Rames Ayam', 'price' => 15000, 'category' => 'Makanan', 'image' => 'menus/nasi_rames.png'],
                ['name' => 'Mie Ayam Special', 'price' => 12000, 'category' => 'Makanan', 'image' => 'menus/mie_ayam.png'],
                ['name' => 'Es Teh Manis', 'price' => 3000, 'category' => 'Minuman', 'image' => 'menus/es_teh.png'],
            ];

            foreach ($menus as $m) {
                \App\Models\Menu::updateOrCreate(
                    ['name' => $m['name'] . ' (' . $canteen->name . ')'],
                    [
                        'price' => $m['price'],
                        'category' => $m['category'],
                        'image' => $m['image'],
                        'description' => 'Menu lezat dari ' . $canteen->name,
                        'status' => 'available',
                        'canteen_id' => $canteen->id
                    ]
                );
            }
        }

        // Link existing users without canteen (if any) to the first canteen as default
        User::whereNull('canteen_id')->where('role', 'admin')->update([
            'canteen_id' => Canteen::first()->id
        ]);
    }
}
