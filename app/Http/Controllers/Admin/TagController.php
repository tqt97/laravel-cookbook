<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\BulkDeleteTagRequest;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Models\Tag;
use App\Traits\HandlesBulkDeletion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class TagController extends Controller
{
    use HandlesBulkDeletion;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tags = Tag::withCount('posts')->latest()->paginate();

        return view('admin.tags.index', [
            'tags' => $tags,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'admin.tags.form',
            [
                'tag' => new Tag,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request): RedirectResponse
    {
        try {
            Tag::query()->create($request->validated());

            return to_route('admin.tags.index')->with('success', __('tag.messages.create_success'));
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return to_route('admin.tags.index')->with('error', __('tag.messages.create_fail'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag): View
    {
        return view('admin.tags.form', [
            'tag' => $tag,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        try {
            $tag->update($request->validated());

            return to_route('admin.tags.index')->with('success', __('tag.messages.update_success'));
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return to_route('admin.tags.index')->with('error', __('tag.messages.update_fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();

            return to_route('admin.tags.index')->with('success', __('tag.messages.delete_success'));
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            return to_route('admin.tags.index')->with('error', __('tag.messages.delete_fail'));
        }
    }

    /**
     * Remove multiple the specified resource from storage.
     */
    public function bulkDelete(BulkDeleteTagRequest $request): RedirectResponse
    {
        return $this->performBulkDeletion($request, Tag::class);
    }

    public function duplicate(Tag $tag): View
    {
        $newTag = $tag->replicate();
        $newTag->name = $tag->name.'-copy';

        return view('admin.tags.form', [
            'tag' => $newTag,
        ]);
    }
}
