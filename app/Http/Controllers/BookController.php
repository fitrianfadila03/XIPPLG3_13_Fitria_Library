<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Menyimpan buku baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:books',
            'writer' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:9999',
        ]);

        try {
            $book = Book::create($request->all());

            return response()->json([
                'message' => 'Buku berhasil dibuat.',
                'book' => $book,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pembuatan buku gagal', 'error' => $e->getMessage()], 500);
        }
    }

    // Menampilkan semua buku
    public function index()
    {
        $books = Book::with(['user', 'category'])->get();
        return response()->json($books, 200);
    }

    // Menampilkan buku berdasarkan ID
    public function show($id)
    {
        $book = Book::with(['user', 'category'])->findOrFail($id);
        return response()->json($book, 200);
    }

    // Memperbarui buku
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255|unique:books,title,' . $id,
            'writer' => 'sometimes|string|max:255',
            'user_id' => 'sometimes|exists:users,id',
            'category_id' => 'sometimes|exists:categories,id',
            'publisher' => 'sometimes|string|max:255',
            'year' => 'sometimes|integer|min:1000|max:9999',
        ]);

        try {
            $book = Book::findOrFail($id);
            $book->update($request->all());

            return response()->json([
                'message' => 'Buku berhasil diperbarui.',
                'book' => $book,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pembaruan buku gagal', 'error' => $e->getMessage()], 500);
        }
    }

    // Menghapus buku
    public function destroy($id)
    {
        $book = Book::find($id);
        
        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }
        
        $book->delete();
    
        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }
}