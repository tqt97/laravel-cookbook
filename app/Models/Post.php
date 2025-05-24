<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'image_path',
        'category_id',
        'is_featured',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function boot(): void
    {
        parent::boot();
        static::deleting(function (Post $post) {
            if ($post->isForceDeleting()) {
                $oldImage = $post->image_path;

                if ($oldImage && ! ImageHelper::delete($oldImage)) {
                    throw new \RuntimeException("Delete image fail: {$oldImage}");
                }
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the URL of the image associated with this post, or a default
     * placeholder image if no image is associated.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : asset('assets/images/no-image.png');
    }

    /**
     * Scope the query to include soft deleted models or only the trashed ones.
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        return match ($status) {
            'trashed' => $query->onlyTrashed(),
            'all' => $query->withTrashed(),
            default => $query,
        };
    }

    /**
     * Scope the query to include only featured posts.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope the query to include only published posts.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to enable search functionality.
     *
     * @param  string|null  $search  The search term to filter the query results by title.
     */
    public function scopeSearch(Builder $query, $search): Builder
    {
        return $query->when($search, function ($q) use ($search) {
            $q->whereLike('title', '%'.$search.'%');
        });
    }

    /**
     * Scope a query to enable filtering posts by search term, category and/or tag.
     *
     * @param  array  $filters  The filters to apply to the query.
     *                          - `search`: The search term to filter the query results by title.
     *                          - `category`: The category slug to filter the query results by category.
     *                          - `tag`: The tag slug to filter the query results by tag.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, fn ($q, $search) => $q->where('title', 'like', "%$search%"))
            ->when($filters['category'] ?? null, function ($q, $category) {
                $q->whereHas('category', fn ($q) => $q->where('slug', $category));
            })
            ->when($filters['tag'] ?? null, function ($q, $tag) {
                $q->whereHas('tags', fn ($q) => $q->where('slug', $tag));
            });
    }

    /**
     * Scope a query to apply sorting based on specified options.
     *
     * @param  array  $sortOptions  The sorting options to apply to the query.
     *                              - `sort`: The column to sort by (default is 'created_at').
     *                              - `direction`: The direction of the sort, either 'asc' or 'desc' (default is 'desc').
     */
    public function scopeSort(Builder $query, array $sortOptions): Builder
    {
        return $query->orderBy($sortOptions['sort'] ?? 'created_at', $sortOptions['direction'] ?? 'desc');
    }
}
