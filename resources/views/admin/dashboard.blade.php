@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600">{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white border rounded-lg p-6 hover:shadow-lg transition">
            <h2 class="text-sm text-gray-600 mb-2">Products</h2>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Produk::count() }}</p>
        </div>

        <div class="bg-white border rounded-lg p-6 hover:shadow-lg transition">
            <h2 class="text-sm text-gray-600 mb-2">Categories</h2>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Kategori::count() }}</p>
        </div>

        <div class="bg-white border rounded-lg p-6 hover:shadow-lg transition">
            <h2 class="text-sm text-gray-600 mb-2">Users</h2>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::where('role','user')->count() }}</p>
        </div>

        <div class="bg-white border rounded-lg p-6 hover:shadow-lg transition">
            <h2 class="text-sm text-gray-600 mb-2">Transactions</h2>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Transaction::count() }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <a href="{{ route('admin.produk.index') }}" class="bg-blue-600 text-white p-6 rounded-lg text-center font-semibold hover:bg-blue-700 transition">
                Manage Products
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="bg-blue-600 text-white p-6 rounded-lg text-center font-semibold hover:bg-blue-700 transition">
                Manage Categories
            </a>
            <a href="{{ route('chat.index') }}" class="bg-blue-600 text-white p-6 rounded-lg text-center font-semibold hover:bg-blue-700 transition">
                View Messages
            </a>
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-white border rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">System Information</h2>
        <ul class="space-y-2 text-gray-700">
            <li>✓ System running normally</li>
            <li>✓ <span class="font-semibold">{{ \App\Models\User::where('role','user')->count() }}</span> active users</li>
            <li>✓ Check product stock regularly</li>
        </ul>
    </div>
</div>
@endsection

