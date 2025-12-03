@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Cadastrar Novo Usuário</h2>

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nome Completo *
                            </label>
                            <input type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
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
                                value="{{ old('email') }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Senha *
                            </label>
                            <input type="password"
                                name="password"
                                id="password"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                Confirmar Senha *
                            </label>
                            <input type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <!-- Buttons -->
                    <div class="flex flex-col-reverse md:flex-row justify-end mt-8 gap-4 md:gap-4">
                        <a href="{{ route('users.index') }}"
                            class="w-full md:w-auto bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-center">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Cadastrar Usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection