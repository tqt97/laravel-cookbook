<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeRequest;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(HomeRequest $request): View
    {
        $requestValidated = $request->validated();

        $posts = Post::query()->with(['category:id,name', 'user:id,name'])
            ->published()
            ->filter($requestValidated)
            ->sort($requestValidated)
            ->paginate($requestValidated['limit'] ?? 10)
            ->withQueryString();

        return view('home', [
            'posts' => $posts,
        ]);
    }
}
