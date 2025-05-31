<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        $content = collect([
            '<h2>'.fake()->sentence().'</h2>',
            '<p>'.fake()->paragraph(8).'</p>',
            '<p>'.fake()->paragraph(7).'</p>',
            '<blockquote>'.fake()->sentence(12).'</blockquote>',
            '<h3>'.fake()->sentence().'</h3>',
            '<ul>'.collect(range(1, 4))
                ->map(fn () => '<li>'.fake()->sentence(6).'</li>')
                ->implode('').'</ul>',
            '<p>'.fake()->paragraph(6).'</p>',
            '<img src="'.fake()->imageUrl(800, 400, 'nature').'" alt="'.fake()->word().'">',
            '<p>'.fake()->paragraph(7).'</p>',
        ])->implode("\n\n");

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence(),
            'content' => $content,
            'is_featured' => fake()->boolean(),
            'is_published' => $isPublished = fake()->boolean(),
            'published_at' => $isPublished ? now() : null,
        ];
    }
}
