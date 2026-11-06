    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion - All in One by Eva</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <style>
            body {
                font-family: Arial, sans-serif;
            }

            .burgundy {
                background: #780D25;
            }

            .text-burgundy {
                color: #780D25;
            }
        </style>
    </head>
   <body class="min-h-screen flex items-center justify-center md:justify-end p-4 md:pr-[4%]
    bg-[url('/images/image.png')] bg-[length:99%_100%] bg-center bg-no-repeat"> 
    

        <!-- CARTE DE CONNEXION : à droite sur grand écran, centrée sur mobile -->
       <div class="w-full max-w-[450px] min-h-[600px] bg-white/95 rounded-2xl shadow-xl p-9">

            <!-- En-tête -->
            <div class="text-center mb-6">
                <i class="fa-solid fa-lock text-burgundy text-3xl mb-2"></i>
               <h2 class="text-2xl font-bold text-burgundy">
                    Connexion
                </h2>
                <p class="text-burgundy text-sm mt-1">
                    Accédez à votre espace
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf

                <!-- E-mail -->
                <div class="mb-6">
                    <div class="flex items-center border border-gray-200 rounded-xl px-4 bg-white">
                        <i class="fa-solid fa-envelope text-burgundy"></i>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Adresse e-mail"
                            class="w-full p-3 outline-none bg-transparent text-sm placeholder:text-burgundy"
                            required>
                    </div>
                </div>

                <!-- Mot de passe -->
                <div class="mb-6">
                    <div class="flex items-center border border-gray-200 rounded-xl px-4 bg-white">
                        <i class="fa-solid fa-lock text-burgundy"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Mot de passe"
                           class="w-full p-3 outline-none bg-transparent text-sm placeholder:text-burgundy"
                            required>
                        <button type="button" onclick="togglePassword()">
                            <i id="eye" class="fa-solid fa-eye text-gray-500"></i>
                        </button>
                    </div>
                </div>

                <!-- Se souvenir de moi / Mot de passe oublié -->
                <div class="flex items-center justify-between mb-5 text-xs">
                    <label class="flex items-center gap-2 text-burgundy cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300">
                        Se souvenir de moi
                    </label>
                    <a href="#" class="text-burgundy hover:underline">
                        Mot de passe oublié ?
                    </a>
                </div>

                <!-- Bouton -->
                <button type="submit"
                    class="burgundy text-white w-full py-3 rounded-xl font-semibold hover:opacity-90 transition flex items-center justify-center gap-2">
                    Se connecter
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </form>

            <!-- Séparateur -->
            <div class="flex items-center gap-3 my-8">
                <div class="flex-1 border-t border-gray-200"></div>
                <span class="text-gray-400 text-xs">ou</span>
                <div class="flex-1 border-t border-gray-200"></div>
            </div>

            <!-- Contacter le salon (remplace le numéro par celui du salon, format international sans + ni espaces) -->
            <a href="https://wa.me/221000000000" target="_blank" rel="noopener"
            class="flex items-center justify-center gap-2 w-full py-3 mt-2 rounded-xl bg-red-100 hover:bg-red-200 transition text-sm text-burgundy font-bold">
            <i class="fab fa-whatsapp text-green-500 text-lg"></i>
            Contacter le salon
            </a>

            <p class="text-center text-gray-400 text-xs mt-10">
                All in One by Eva © 2026
            </p>

        </div>

        <script>
            function togglePassword() {
                const password = document.getElementById('password');
                const eye = document.getElementById('eye');

                if (password.type === 'password') {
                    password.type = 'text';
                    eye.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    password.type = 'password';
                    eye.classList.replace('fa-eye-slash', 'fa-eye');
                }
            }
        </script>

    </body>
    </html>
