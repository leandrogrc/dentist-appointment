<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            <i class="fas fa-lock mr-2"></i>Atualizar Senha
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Certifique-se de que sua conta está usando uma senha longa e aleatória para se manter segura.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Senha Atual</label>
            <input type="password" name="current_password" id="current_password"
                autocomplete="current-password"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('current_password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha</label>
            <input type="password" name="password" id="password"
                autocomplete="new-password"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nova Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                autocomplete="new-password"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('password_confirmation')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Success Message -->
        @if (session('status') === 'password-updated')
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">Senha atualizada com sucesso!</span>
        </div>
        @endif

        <!-- Submit Button -->
        <div class="flex items-center gap-4">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center transition duration-200">
                <i class="fas fa-key mr-2"></i> Atualizar Senha
            </button>
        </div>
    </form>
</section>