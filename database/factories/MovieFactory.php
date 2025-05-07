<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Movie;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(rand(3, 6)); // Judul film acak
        $slug = Str::slug($title); // Membuat slug dari judul

        return [
            'title' => $title, // Judul film
            'slug' => $slug, // Slug dari judul
            'synopsis' => fake()->paragraph(rand(5, 10)), // Deskripsi film
            'category_id' => Category::inRandomOrder()->first(), // ID kategori acak
            'year' => fake()->year(), // Tahun rilis film
            'actors' => fake()->name() . ', ' . fake('id')->name(), // Nama dua aktor
            'cover_image' => 'https://picsum.photos/seed/' . Str::random(10) . '/480/640', // Gambar sampul film
            'created_at' => now(), // Waktu pembuatan
            'updated_at' => now(), // Waktu pembaruan
        ];
    }
}
