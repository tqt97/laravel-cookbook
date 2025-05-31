<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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
        'view_count',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function boot(): void
    {
        parent::boot();
        static::forceDeleted(function (Post $post) {
            $post->tags()->detach();

            $oldImage = $post->image_path;
            if ($oldImage && ! ImageHelper::delete($oldImage)) {
                throw new \RuntimeException("Delete image fail: {$oldImage}");
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

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function likedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * An attribute to return image URL.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(get: function () {
            return $this->image_path ? Storage::disk('public')->url($this->image_path) : asset('assets/images/no-image.png');
        });
    }

    /**
     * Scope the query to include soft deleted models or only the trashed ones.
     */
    #[Scope]
    protected function status(Builder $query, ?string $status): Builder
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
    #[Scope]
    protected function featured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope the query to include only published posts.
     */
    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to enable search functionality.
     *
     * @param  string|null  $search  The search term to filter the query results by title.
     */
    #[Scope]
    protected function search(Builder $query, $search): Builder
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
    #[Scope]
    protected function filter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, fn ($q, $search) => $q->whereLike('title', "%$search%"))
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
    #[Scope]
    protected function sort(Builder $query, array $sortOptions): Builder
    {
        return $query->orderBy($sortOptions['sort'] ?? 'created_at', $sortOptions['direction'] ?? 'desc');
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'view_count' => 'integer',
        ];
    }
}
