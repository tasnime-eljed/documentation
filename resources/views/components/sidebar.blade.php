<aside class="w-64 bg-gray-100 min-h-screen p-4">

    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
        📚 DevDocs
    </h2>

    <ul class="space-y-3">

        <li>
            <a href="{{ route('admin.dashboard') }}" class="block hover:bg-gray-200 p-2 rounded">
                🏠 Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('admin.projects.index') }}" class="block hover:bg-gray-200 p-2 rounded">
                📁 Projets
            </a>
        </li>

        <li>
            <a href="{{ route('admin.categories.index') }}" class="block hover:bg-gray-200 p-2 rounded">
                📂 Catégories
            </a>
        </li>

        <li>
            <a href="{{ route('admin.documentations.index') }}" class="block hover:bg-gray-200 p-2 rounded">
                📄 Documentation
            </a>
        </li>

        <li>
            <a href="{{ route('favoris.index') }}" class="block hover:bg-gray-200 p-2 rounded">
                ⭐ Favoris
            </a>
        </li>

    </ul>

</aside>
