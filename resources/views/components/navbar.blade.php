<nav class="bg-white shadow px-6 py-3 flex justify-between items-center">
    <div class="flex items-center gap-2 font-bold text-lg">
        📚 DevDocs
    </div>

    <div class="flex items-center gap-4">
        @auth
            <span class="text-gray-600">{{ auth()->user()->nom }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-600 hover:underline">Déconnexion</button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}">Connexion</a>
        @endguest
    </div>
</nav>
