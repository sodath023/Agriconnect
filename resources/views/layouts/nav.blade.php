
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold text-green-600"><a href="/" class="hover:text-green-700 transition">🌾 Agriconnect</a></h1>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex gap-6 items-center">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.categories') }}" class="text-gray-700 hover:text-green-600 transition font-medium text-sm">Catégories</a>
                            <a href="{{ route('admin.produits') }}" class="text-gray-700 hover:text-green-600 transition font-medium text-sm">Produits</a>
                        @else
                            <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600 transition font-medium text-sm">Accueil</a>
                            <a href="{{ route('catalogue') }}" class="text-gray-700 hover:text-green-600 transition font-medium text-sm">Catalogue</a>
                        @endif
                    @else
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600 transition font-medium text-sm">Accueil</a>
                        <a href="{{ route('catalogue') }}" class="text-gray-700 hover:text-green-600 transition font-medium text-sm">Catalogue</a>
                    @endauth
                </div>

                <!-- User Profile Section -->
                <div class="flex items-center gap-4">
                    @auth
                        <!-- Panier Icon -->
                        <a href="{{ route('panier') }}" class="relative text-gray-700 hover:text-green-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 8m10 0l2-8m0 0h3.6m-3.6 0a1 1 0 100 2 1 1 0 000-2z"></path>
                            </svg>
                        </a>

                        <!-- Profile Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center gap-2 p-2 rounded-full hover:bg-gray-100 transition focus:outline-none">
                                <!-- Avatar -->
                                <div class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                                <!-- User name -->
                                <span class="hidden sm:block text-sm font-medium text-gray-700">
                                    {{ auth()->user()->name }}
                                </span>
                                <!-- Chevron Down -->
                                <svg class="w-4 h-4 text-gray-600 group-hover:text-green-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <!-- User Info Header -->
                                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                    <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                                    <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                        @if(auth()->user()->role === 'admin')
                                            Administrateur
                                        @elseif(auth()->user()->role === 'producteur')
                                            Producteur
                                        @elseif(auth()->user()->role === 'acheteur')
                                            Acheteur
                                        @else
                                            Utilisateur
                                        @endif
                                    </span>
                                </div>

                                <!-- Menu Items -->
                                <ul class="py-2">
                                    <!-- Admin Menu -->
                                    @if(auth()->user()->role === 'admin')
                                        <li>
                                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2 3l2-3m2 3l2-3m2-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Tableau de Bord
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.moderation') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Modération
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.utilisateurs') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M12 4.354v8.048m0-8.048H8a4 4 0 100 8.048h4m0-8.048h4a4 4 0 110 8.048h-4m0 0v8m0 0H8m4 0h4"></path>
                                                </svg>
                                                Utilisateurs
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.parametres') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Paramètres
                                            </a>
                                        </li>
                                    @elseif(auth()->user()->role === 'producteur')
                                        <!-- Producteur Menu -->
                                        <li>
                                            <a href="{{ route('producteur.dashboard') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2 3l2-3m2 3l2-3m2-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Tableau de Bord
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('producteur.creer-annonce') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Créer Annonce
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('producteur.mes-produits') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4v-10m0-10l8 4v10l-8 4"></path>
                                                </svg>
                                                Mes Produits
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('producteur.commandes-recues') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m0 0V3a2 2 0 00-2-2h-2a2 2 0 00-2 2v2z"></path>
                                                </svg>
                                                Commandes Reçues
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('producteur.mes-revenus') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Mes Revenus
                                            </a>
                                        </li>
                                    @elseif(auth()->user()->role === 'acheteur')
                                        <!-- Acheteur Menu -->
                                        <li>
                                            <a href="{{ route('acheteur.dashboard') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2 3l2-3m2 3l2-3m2-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Tableau de Bord
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('acheteur.commandes') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                </svg>
                                                Mes Commandes
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('panier') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 8m10 0l2-8m0 0h3.6m-3.6 0a1 1 0 100 2 1 1 0 000-2z"></path>
                                                </svg>
                                                Mon Panier
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Divider -->
                                    <li><div class="border-t border-gray-100 my-2"></div></li>

                                    <!-- Common Items -->
                                    <li>
                                        <a href="#" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Mon Profil
                                        </a>
                                    </li>
                                    <li>
                                        <form method="get" action="{{ route('deconnexion') }}" class="w-full">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Déconnexion
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <!-- Unauthenticated User -->
                        <a href="{{ route('connexion') }}" class="px-4 py-2 text-gray-700 hover:text-white hover:bg-green-600 transition rounded-lg font-medium text-sm">Connexion</a>
                        <a href="{{ route('inscription') }}" class="px-4 py-2 bg-green-600 text-white hover:bg-green-700 transition rounded-lg font-medium text-sm">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

