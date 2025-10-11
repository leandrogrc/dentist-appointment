@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Header -->
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-user-circle mr-2"></i>Editar Perfil
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Atualize suas informações de perfil e senha da conta.
                </p>
            </div>
        </div>

        <!-- Update Profile Information -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

    </div>
</div>
@endsection