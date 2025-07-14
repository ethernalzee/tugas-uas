<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Book;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('atmin'),
            'role' => 'admin',
        ]);

        // Create member user
        User::create([
            'name' => 'Member Test',
            'email' => 'member@gmail.com',
            'password' => bcrypt('member'),
            'role' => 'member',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Fiksi', 'description' => 'Buku-buku fiksi dan novel'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku-buku non-fiksi'],
            ['name' => 'Teknologi', 'description' => 'Buku-buku tentang teknologi'],
            ['name' => 'Sejarah', 'description' => 'Buku-buku sejarah'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample books
        $books = [
            [
                'title' => 'Laravel untuk Pemula',
                'author' => 'John Doe',
                'isbn' => '978-0123456789',
                'category_id' => 3,
                'stock' => 5,
                'available_stock' => 5,
                'description' => 'Buku panduan Laravel untuk pemula',
            ],
            [
                'title' => 'Sejarah Indonesia',
                'author' => 'Jane Smith',
                'isbn' => '978-0987654321',
                'category_id' => 4,
                'stock' => 3,
                'available_stock' => 3,
                'description' => 'Buku tentang sejarah Indonesia',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
