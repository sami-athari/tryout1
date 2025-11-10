@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">
        User Accounts
    </h1>

    <div class="mb-6 text-center">
        <span class="text-lg text-gray-700">
            Total registered accounts:
            <strong class="text-blue-600">{{ $total }}</strong>
        </span>
    </div>

    <div class="bg-white border rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">#</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Date Created</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-900">
                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8 text-red-500">
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex justify-center">
        {{ $users->links('pagination::tailwind') }}
    </div>

    <div class="mt-10 text-center">
        <a href="{{ route('admin.dashboard') }}"
           class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 inline-block">
            ← Back to Dashboard
        </a>
    </div>
</div>
@endsection

