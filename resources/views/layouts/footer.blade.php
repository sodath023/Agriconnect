 <footer class="bg-gray-900 text-gray-300 p-8 mt-12 border-t border-gray-800">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">🌾 Agriconnect</h3>
                    <p class="text-sm">Connectez producteurs et acheteurs agricoles pour une commerce plus équitable et local.</p>
                </div>
                <!-- Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Navigation</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-green-400 transition">Accueil</a></li>
                        <li><a href="{{ route('catalogue') }}" class="hover:text-green-400 transition">Catalogue</a></li>
                        <li><a href="{{ route('panier') }}" class="hover:text-green-400 transition">Panier</a></li>
                    </ul>
                </div>
                <!-- Support -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-green-400 transition">Aide & FAQ</a></li>
                        <li><a href="#" class="hover:text-green-400 transition">Contact</a></li>
                        <li><a href="#" class="hover:text-green-400 transition">Conditions</a></li>
                    </ul>
                </div>
                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <p class="text-sm">Email: info@agriconnect.com</p>
                    <p class="text-sm">Tel: +229 XX XX XX XX</p>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-6 text-center text-sm">
                <p>&copy; 2026 Agriconnect. Tous droits réservés. | Plateforme agricole de confiance</p>
            </div>
        </div>
    </footer>