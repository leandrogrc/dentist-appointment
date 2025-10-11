<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            <i class="fas fa-user-edit mr-2"></i>Informações do Perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Atualize as informações do seu perfil e endereço de e-mail.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
            <input type="text" name="name" id="name"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
            <input type="email" name="email" id="email"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="email"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Success Message -->
        @if (session('status') === 'profile-updated')
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">Perfil atualizado com sucesso!</span>
        </div>
        @endif

        <!-- Submit Button -->
        <div class="flex items-center gap-4">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center transition duration-200">
                <i class="fas fa-save mr-2"></i> Salvar
            </button>
        </div>
    </form>
</section>