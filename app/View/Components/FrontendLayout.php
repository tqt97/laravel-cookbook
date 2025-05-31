<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Tag;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontendLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Get all tags with belonging posts
        $tags = Tag::query()
            ->withCount('posts')
            ->having('posts_count', '>', 0)
            ->latest('posts_count')
            ->get();

        // Get all categories with belonging posts and published posts
        $categories = Category::query()
            ->with(['posts' => fn ($q) => $q->published()])
            ->active()
            ->withCount([
                'posts as published_posts_count' => fn ($q) => $q->published(),
            ])
            ->having('published_posts_count', '>', 0)
            ->latest('published_posts_count')
            ->get();

        return view(
            'layouts.frontend-layout',
            [
                'tags' => $tags,
                'categories' => $categories,
            ]
        );
    }
}
