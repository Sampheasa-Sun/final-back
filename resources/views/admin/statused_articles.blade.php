<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Statused Articles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Statused Articles</h1>
                <p class="text-sm text-gray-500">Showing articles with statuses: Published, Draft, or Under Review</p>
            </div>
            <a href="{{ route('admin.articles.index') }}"
                class="inline-block px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700 transition">
                ← Back to Manage Articles
            </a>
        </div>

        <div class="bg-white shadow-sm border rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 border-b text-left">
                    <tr>
                        <th class="px-4 py-3 font-medium text-gray-600">#</th>
                        <th class="px-4 py-3 font-medium text-gray-600">Title</th>
                        <th class="px-4 py-3 font-medium text-gray-600">Author</th>
                        <th class="px-4 py-3 font-medium text-gray-600">Status</th>
                        <th class="px-4 py-3 font-medium text-gray-600">Updated At</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($articles as $article)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $article->id }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $article->title }}</td>
                        <td class="px-4 py-3">
                            @if ($article->user)
                                {{ $article->user->firstName }} {{ $article->user->lastName }}
                            @else
                                <span class="text-gray-400 italic">No Author</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 text-xs rounded-full
                                @if ($article->status === 'published') bg-green-100 text-green-800
                                @elseif ($article->status === 'draft') bg-yellow-100 text-yellow-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ $article->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $article->updated_at->format('M d, Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            No statused articles found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    </div>
</body>

</html>
