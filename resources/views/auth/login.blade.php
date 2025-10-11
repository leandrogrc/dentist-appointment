<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso ao Sistema - Clínica de Ortodontia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="font-sans bg-gradient-to-br from-blue-50 to-cyan-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full grid grid-cols-1 lg:grid-cols-2 bg-white rounded-2xl shadow-2xl overflow-hidden">

            <!-- Coluna Esquerda - Ilustração/Branding -->
            <div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-br from-blue-600 to-cyan-500 text-white p-12">
                <div class="text-center">
                    <!-- Ícone Dental Estilizado -->
                    <div class="mb-8">
                        <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-tooth text-4xl text-white"></i>
                        </div>
                        <h1 class="text-3xl font-bold mb-2">Consultório<span class="font-light"></span></h1>
                        <p class="text-blue-100 text-lg">Nelson B. Carmo</p>
                    </div>

                    <!-- Características -->
                    <div class="space-y-4 mt-8 text-left">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar-check text-sm"></i>
                            </div>
                            <span class="text-blue-100">Agendamento Inteligente</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-line text-sm"></i>
                            </div>
                            <span class="text-blue-100">Gestão de Pacientes</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-shield-alt text-sm"></i>
                            </div>
                            <span class="text-blue-100">Segurança e Privacidade</span>
                        </div>
                    </div>

                    <!-- Quote -->
                    <div class="mt-12 p-4 bg-white/10 rounded-lg">
                        <p class="text-blue-100 italic text-sm">
                            "Transformando sorrisos, organizando consultas"
                        </p>
                    </div>
                </div>
            </div>

            <!-- Coluna Direita - Formulário de Login -->
            <div class="p-8 sm:p-12">
                <!-- Header Mobile -->
                <div class="lg:hidden text-center mb-8">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-tooth text-2xl text-white"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Consultório</h1>
                    <p class="text-gray-600">Nelson B. Carmo</p>
                </div>

                <!-- Título -->
                <div class="text-center lg:text-left mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Bem-vindo de volta</h2>
                    <p class="text-gray-600 mt-2">Acesse sua conta para continuar</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span class="text-green-700 text-sm">{{ session('status') }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-500"></i>E-mail
                        </label>
                        <div class="relative">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('email') border-red-500 @enderror"
                                placeholder="seu@email.com">
                            @error('email')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            @enderror
                        </div>
                        @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-500"></i>Senha
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('password') border-red-500 @enderror"
                                placeholder="Sua senha">
                            @error('password')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            @enderror
                        </div>
                        @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-1"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-cyan-500 text-white py-3 px-4 rounded-lg font-semibold hover:from-blue-700 hover:to-cyan-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 transform hover:-translate-y-0.5 shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i> Acessar Sistema
                    </button>
                </form>

                <!-- Informações de Suporte -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Problemas para acessar?
                            <a href="mailto:contato.leandrogarcia@gmail.com" class="text-blue-600 hover:text-blue-500 font-medium">
                                Contate o suporte
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500">
                        &copy; {{ date('Y') }} Consultório Dr. Nelson B. Carmo. Todos os direitos reservados.<br>
                        <span class="text-gray-400">Sistema seguro e criptografado</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para melhorias de UX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Adiciona loading no botão de submit
            const form = document.querySelector('form');
            const submitBtn = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', function() {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Acessando...';
                submitBtn.disabled = true;
            });

            // Efeito de foco nos inputs
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-blue-200');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-blue-200');
                });
            });
        });
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        input:focus {
            outline: none;
        }

        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Animação suave para o gradiente */
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .bg-gradient-to-br {
            background-size: 200% 200%;
            animation: gradientShift 15s ease infinite;
        }
    </style>
</body>

</html>