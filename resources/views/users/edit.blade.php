@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Usuário</h2>

                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nome Completo *
                            </label>
                            <input type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $user->name) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                E-mail *
                            </label>
                            <input type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', $user->email) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Telefone
                            </label>
                            <input type="tel"
                                name="phone"
                                id="phone"
                                value="{{ old('phone', $user->phone) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="(11) 99999-9999">
                            @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700">
                                Observações
                            </label>
                            <textarea name="notes"
                                id="notes"
                                rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $user->notes) }}</textarea>
                            @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informações do Usuário</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">Status:</span>
                                <span class="{{ $user->is_active ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $user->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </div>
                            <div>
                                <span class="font-medium">Último login:</span>
                                <span>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca' }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Criado em:</span>
                                <span>{{ $user->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Criado por:</span>
                                <span>{{ $user->creator ? $user->creator->name : 'Sistema' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <!-- Buttons -->
                    <div class="flex flex-col-reverse md:flex-row justify-end mt-8 gap-4 md:gap-4">
                        <a href="{{ route('users.index') }}"
                            class="w-full md:w-auto bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-center">
                            Voltar
                        </a>
                        <button type="submit"
                            class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Atualizar Usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection