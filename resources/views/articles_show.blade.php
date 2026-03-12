<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Article Detail - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <style>
        pre {
            background-color: #1e293b; /* dark blue-gray */
            color: #f8fafc; /* light text */
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            font-family: monospace;
        }
        code {
            background-color: #e0e7ff; /* light purple */
            padding: 0.2rem 0.4rem;
            border-radius: 0.3rem;
            font-family: monospace;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="max-w-4xl mx-auto py-10 px-4">
        <a href="{{ route('admin.articles.index') }}" class="mb-6 inline-block text-blue-600 hover:underline">&larr; Back to Article List</a>

        <div class="bg-white shadow rounded-xl p-6">
            <h1 class="text-2xl font-bold mb-2">{{ $article->title }}</h1>
            <p class="text-sm text-gray-500 mb-4">
                By {{ $article->user->firstName ?? 'N/A' }} {{ $article->user->lastName ?? '' }} |
                Submitted on {{ $article->created_at->format('M d, Y') }}
            </p>
@if ($article->image_url)
    <img src="{{ $article->image_url }}" alt="Article Image" class="w-full rounded-lg mb-6">
@else
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/HelloWorld.svg/2560px-HelloWorld.svg.png" alt="No image" class="w-full rounded-lg mb-6">
@endif

            <div class="prose max-w-none">
                {!! \Illuminate\Support\Str::markdown($article->body ?? '') !!}
            </div>
        </div>
    </div> 
</body>
</html>
