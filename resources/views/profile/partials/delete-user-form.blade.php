<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>Excluir Conta
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente apagados.
            Antes de excluir sua conta, faça o download de quaisquer dados ou informações que deseja manter.
        </p>
    </header>

    <!-- Delete Account Button -->
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="flex items-center">
        <i class="fas fa-trash mr-2"></i> Excluir Conta
    </x-danger-button>

    <!-- Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                Tem certeza que deseja excluir sua conta?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Esta ação não pode ser desfeita. Isso excluirá permanentemente sua conta e removerá todos os dados.
            </p>

            <div class="mt-6">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Digite sua senha para confirmar
                </label>
                <input type="password"
                    name="password"
                    id="password"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Sua senha">
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <x-secondary-button x-on:click="$dispatch('close')">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </x-secondary-button>

                <x-danger-button type="submit" class="flex items-center">
                    <i class="fas fa-trash mr-2"></i> Excluir Conta
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>