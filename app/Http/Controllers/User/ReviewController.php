<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
    'produk_id' => 'required|exists:produks,id',
    'rating' => 'required|integer|min:1|max:5',
    'komentar' => 'nullable|string',
    'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
]);



        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('reviews', 'public');
        }

        $validated['user_id'] = \Illuminate\Support\Facades\Auth::id();

        Review::create($validated);

        return redirect()->back()->with('success', 'Review berhasil dikirim!');
    }
}
