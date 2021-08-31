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
        return Response::make("", 204);
    }

    public function create(Request $request): BookResource
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'description' => 'nullable'
        ]);
        $book = \App\Models\Books::create($request->getAll());
        return new BookResource($book);
    }

    public function list(Request $request){
        $request->validate([
            'sort_by' => 'nullable|in:title,author',
            'order_by' => 'nullable|in:asc,desc',
            'search' => 'nullable|max:255'
        ]);
        $books = \App\Models\Books::paginate(10);
        return BookResource::collection($books);
    }
}
