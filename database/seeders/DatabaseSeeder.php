<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample admin user if not exists
        if (!User::where('email', 'admin@stylevora.com')->exists()) {
            User::create([
                'name' => 'Admin Stylevora',
                'email' => 'admin@stylevora.com',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]);
        }

        // Create sample user if not exists
        if (!User::where('email', 'user@stylevora.com')->exists()) {
            User::create([
                'name' => 'User Stylevora',
                'email' => 'user@stylevora.com',
                'password' => bcrypt('password'),
                'is_admin' => false,
            ]);
        }

        // Create categories
        $categories = [
            [
                'name' => 'Baju Pria',
                'slug' => 'baju-pria',
                'description' => 'Koleksi baju pria lengkap dengan berbagai pilihan model dan warna',
            ],
            [
                'name' => 'Baju Wanita',
                'slug' => 'baju-wanita',
                'description' => 'Koleksi baju wanita terbaru dengan desain modern dan trendi',
            ],
            [
                'name' => 'Celana',
                'slug' => 'celana',
                'description' => 'Berbagai jenis celana untuk pria dan wanita',
            ],
            [
                'name' => 'Aksesori',
                'slug' => 'aksesori',
                'description' => 'Aksesori fashion lengkap untuk melengkapi penampilan Anda',
            ],
            [
                'name' => 'Sepatu',
                'slug' => 'sepatu',
                'description' => 'Koleksi sepatu casual, formal, dan olahraga',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        // Create sample products
        $admin = User::where('email', 'admin@stylevora.com')->first();
        $batuPria = Category::where('slug', 'baju-pria')->first();
        $batuWanita = Category::where('slug', 'baju-wanita')->first();
        $celana = Category::where('slug', 'celana')->first();
        $aksesori = Category::where('slug', 'aksesori')->first();
        $sepatu = Category::where('slug', 'sepatu')->first();

        $products = [
            // Baju Pria
            [
                'category_id' => $batuPria->id,
                'name' => 'Kaos Polos Pria Premium',
                'slug' => 'kaos-polos-pria-premium',
                'description' => 'Kaos polos pria dengan bahan premium 100% cotton yang nyaman dan tahan lama',
                'price' => 79000,
                'stock' => 50,
                'image' => 'images/products/1768643724_kaos pria.jpeg',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            [
                'category_id' => $batuPria->id,
                'name' => 'Kemeja Casual Pria',
                'slug' => 'kemeja-casual-pria',
                'description' => 'Kemeja casual untuk pria dengan desain modern dan warna pilihan',
                'price' => 129000,
                'stock' => 35,
                'image' => 'images/products/1768666524_kemeja.jpg',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            // Baju Wanita
            [
                'category_id' => $batuWanita->id,
                'name' => 'Blouse Wanita Elegans',
                'slug' => 'blouse-wanita-elegans',
                'description' => 'Blouse wanita dengan potongan elegan dan bahan berkualitas tinggi',
                'price' => 149000,
                'stock' => 40,
                'image' => 'images/products/1768666080_bloose.jpg',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            [
                'category_id' => $batuWanita->id,
                'name' => 'Dress Wanita Kasual',
                'slug' => 'dress-wanita-kasual',
                'description' => 'Dress kasual wanita cocok untuk harian dengan desain yang nyaman',
                'price' => 189000,
                'stock' => 30,
                'image' => 'images/products/1768666486_dress.jpg',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            // Celana
            [
                'category_id' => $celana->id,
                'name' => 'Celana Jeans Pria',
                'slug' => 'celana-jeans-pria',
                'description' => 'Celana jeans pria dengan kualitas terbaik dan desain modern',
                'price' => 199000,
                'stock' => 45,
                'image' => 'images/products/1768666143_jeans.jpg',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            [
                'category_id' => $celana->id,
                'name' => 'Celana Legging Wanita',
                'slug' => 'celana-legging-wanita',
                'description' => 'Celana legging wanita dengan bahan stretch yang nyaman',
                'price' => 99000,
                'stock' => 60,
                'image' => 'images/products/1768666249_legging.jpg',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            // Aksesori
            [
                'category_id' => $aksesori->id,
                'name' => 'Topi Baseball',
                'slug' => 'topi-baseball',
                'description' => 'Topi baseball dengan desain keren untuk berbagai acara',
                'price' => 59000,
                'stock' => 80,
                'image' => 'images/products/1768666335_topi.jpg',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            [
                'category_id' => $aksesori->id,
                'name' => 'Tas Selempang',
                'slug' => 'tas-selempang',
                'description' => 'Tas selempang dengan material berkualitas dan desain stylish',
                'price' => 179000,
                'stock' => 25,
                'image' => 'images/products/1768666377_tas.jpg',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            // Sepatu
            [
                'category_id' => $sepatu->id,
                'name' => 'Sneakers Casual',
                'slug' => 'sneakers-casual',
                'description' => 'Sneakers casual dengan kenyamanan maksimal untuk penggunaan sehari-hari',
                'price' => 299000,
                'stock' => 40,
                'image' => 'images/products/1768666424_sneakers.jpg',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
            [
                'category_id' => $sepatu->id,
                'name' => 'Sandal Jepit',
                'slug' => 'sandal-jepit',
                'description' => 'Sandal jepit dengan desain simple dan nyaman',
                'price' => 49000,
                'stock' => 100,
                'image' => 'images/products/1768666459_sendal.jpg',
                'created_by' => $admin->id,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}
