<x-guest-layout>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .fda-green-bg {
            background-color: #198754;
        }

        .fda-green-text {
            color: #198754;
        }

        .fda-btn {
            background-color: #198754;
            transition: all 0.3s ease;
        }

        .fda-btn:hover {
            background-color: #146c43;
            transform: translateY(-1px);
        }

        .form-input:focus {
            border-color: #198754;
            box-shadow: 0 0 0 1px #198754;
        }
    </style>

    <div class="min-h-screen flex bg-white">

        <!-- Colonne de Gauche : Image (Disparait sur mobile) -->
        <div class="hidden lg:block lg:w-1/2 bg-cover bg-center relative"
            style="background-image: url('{{ asset('Client/assets/img/forme.png') }}');">
            <div class="absolute inset-0 bg-black bg-opacity-10"></div> <!-- Léger voile sombre pour le contraste si besoin -->
            <div class="absolute bottom-0 left-0 right-0 p-12 text-white bg-gradient-to-t from-black/60 to-transparent">
                <h2 class="text-4xl font-bold mb-2">Fonds de Développement de l'Artisanat</h2>
                <p class="text-lg opacity-90">Accompagner, Former et Financer les artisans du Bénin.</p>
            </div>
        </div>

        <!-- Colonne de Droite : Formulaire -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 sm:p-12 bg-gray-50">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">

                <!-- En-tête avec Logo -->
                <div class="text-center mb-8">
                    <a href="/">
                        <img src="{{ asset('Client/assets/img/lofoFDA.png') }}" alt="Logo FDA" class="h-24 mx-auto mb-4 object-contain">
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800">Bon retour !</h2>
                    <p class="text-gray-500 text-sm mt-2">Veuillez saisir vos coordonnées pour vous connecter.</p>
                </div>

                <x-validation-errors class="mb-4" />

                @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-3 rounded-lg text-center">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <x-input id="email" class="block w-full pl-10 border-gray-300 rounded-lg focus:ring-opacity-50 form-input py-3" type="email" name="email" :value="old('email')" required autofocus placeholder="exemple@fda.bj" />
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <x-input id="password" class="block w-full pl-10 border-gray-300 rounded-lg focus:ring-opacity-50 form-input py-3" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                        </div>
                    </div>

                    <!-- Options : Remember me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center cursor-pointer">
                            <x-checkbox id="remember_me" name="remember" class="text-green-600 focus:ring-green-500 rounded border-gray-300" />
                            <span class="ml-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                        </label>

                        <!-- Lien mot de passe oublié (commenté comme dans l'original, décommentez si besoin) -->
                        {{--
                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-green-700 hover:text-green-900" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                        </a>
                        @endif
                        --}}
                    </div>

                    <!-- Bouton de connexion -->
                    <button type="submit" class="w-full fda-btn text-white font-bold py-3 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        {{ __('Se connecter') }}
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-500">
                    © {{ date('Y') }} FDA. Tous droits réservés.
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>