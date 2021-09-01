<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BookResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BooksController extends Controller
{
    public function read(int $id): ?BookResource
    {
        $book = \App\Models\Books::findOrFail($id);
        return new BookResource($book);
    }

    public function delete(int $id): Response
    {
        $book = \App\Models\Books::findOrFail($id);
        $book->delete();
        return response()->noContent();
    }

    public function create(Request $request): BookResource
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'description' => 'nullable'
        ]);
        $book = \App\Models\Books::create($request->all());
        return new BookResource($book);
    }

    public function list(Request $request)
    {
        $order = 'desc';
        $sortBy = 'id';
        $request->validate([
            'sort_by' => 'nullable|in:title,author,id',
            'order_by' => 'nullable|in:asc,desc',
            'search' => 'nullable|max:255'
        ]);
        $books = new \App\Models\Books();
        if ($request->search) {
            $search = preg_replace('/[[:blank:]]+/', '%', $request->search);
            $books = $books->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")->orWhere('author', 'LIKE', "%$search%");
            });
        }
        if ($request->sort_by) {
            $sortBy = $request->sort_by;
        }
        if ($request->order_by) {
            $order = $request->order_by;
        }
        $books = $books->orderBy($sortBy, $order)->paginate(10);
        return BookResource::collection($books);
    }

    public function update(Request $request, $id): Response
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'description' => 'nullable'
        ]);
        $book = \App\Models\Books::findOrFail($id);
        $book->update($request->all());
        return response()->noContent();
    }
}
