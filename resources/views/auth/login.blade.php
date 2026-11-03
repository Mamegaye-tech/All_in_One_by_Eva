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
            background: #F8F3EF;
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
<body class="min-h-screen flex items-center justify-center p-5">
<div class="bg-white rounded-3xl shadow-xl overflow-hidden
                flex flex-col md:flex-row max-w-5xl w-full">
  <!-- Image -->
        <div class="relative w-full h-screen">
    <img
        src="{{ asset('images/image.png') }}"
        class="absolute inset-0 w-full h-full object-cover"
        alt="Salon de beauté">

    <div class="absolute inset-0 bg-black/10 flex items-end p-10">
        <div class="text-white">
            <!-- votre texte ici -->
        </div>
    </div>
</div>
        </div>
        </div>
        <!-- Formulaire de connexion -->
        <div class="md:w-1/2 p-8 md:p-14 flex flex-col justify-center">
        <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-burgundy">
                    Connexion !
                </h2>
                <p class="text-gray-500 mt-2">
                    Connectez-vous à votre espace
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf

                <div class="mb-5">
                    <label class="block text-gray-700 mb-2">
                        Adresse e-mail
                    </label>

                    <div class="flex items-center border rounded-xl px-4">
                        <i class="fa-solid fa-envelope text-burgundy"></i>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Votre adresse e-mail"
                            class="w-full p-3 outline-none"
                            required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">
                        Mot de passe
                    </label>

                    <div class="flex items-center border rounded-xl px-4">
                        <i class="fa-solid fa-lock text-burgundy"></i>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Votre mot de passe"
                            class="w-full p-3 outline-none"
                            required>

                        <button type="button" onclick="togglePassword()">
                            <i id="eye" class="fa-solid fa-eye text-gray-500"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"class="burgundy text-white w-full py-3 rounded-xl
                           font-semibold hover:opacity-90 transition">Se connecter</button>
            </form>

            <p class="text-center text-gray-400 text-sm mt-8">
                © 2026 All in One by Eva
            </p>

        </div>
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