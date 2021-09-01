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

    public function update(Request $request, int $id): Response
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

    public function export(Request $request)
    {

        $request->validate([
            "columns" => "required",
            "columns.*"  => "required|string|distinct|in:title,author,id",
            "export_type" => "required|in:csv,xml"
        ]);

        $columns = $request->columns;
        $export_type = $request->export_type;
        $books = \App\Models\Books::get($columns);

        if ($export_type == 'xml') {
            $xml = new \XMLWriter();
            $xml->openMemory();
            $xml->startDocument();
            $xml->startElement('books');
            foreach ($books as $book) {
                $xml->startElement('data');
                foreach ($book->getAttributes() as $key => $val) {
                    $xml->writeAttribute($key, $val);
                }
                $xml->endElement();
            }
            $xml->endElement();
            $xml->endDocument();
            $content = $xml->outputMemory();
            $xml = null;

            return response()->streamDownload(function () use ($content) {
                echo $content;
            }, 'books.xml');
        } else {
            $fileName = 'books.csv';
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $column_headers = [];
            foreach ($columns as $col) {
                $column_headers[] = ucfirst(strtolower($col));
            }

            $callback = function () use ($books, $column_headers) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $column_headers);

                foreach ($books as $book) {
                    $row = [];
                    foreach ($book->getAttributes() as $key => $val) {
                        $key = ucfirst(strtolower($key));
                        $row[$key] = $val;
                    }

                    fputcsv($file, $row);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
    }
}
