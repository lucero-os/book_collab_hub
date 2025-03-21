<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function createSection(Request $request)
    {
        $request->validate([
            'bookId' => 'required|integer',
            'name' => 'required|string',
            'parentId' => 'integer',
        ]);
        $data = $request->only('bookId', 'name', 'parentId');

        $this->bookService->createSection($data);

        return response()->json(['message' => 'Section created'], 200);
    }
}
