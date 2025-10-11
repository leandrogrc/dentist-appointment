@extends('layouts.app')

@section('title', 'Gerenciar Usuários')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Gerenciar Usuários do Sistema</h2>
                    <a href="{{ route('users.create') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-user-plus mr-2"></i> Novo Usuário
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-3 px-4 text-left">Usuário</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Criado por</th>
                                <th class="py-3 px-4 text-left">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                    @if($user->isSuperAdmin())
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Admin
                                    </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if(!$user->id == 1)
                                    <div class="text-sm text-gray-700">{{ $auth->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->created_at->format('d/m/Y') }}</div>
                                    @else
                                    <span class="text-gray-400 text-sm">Sistema</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        @if(!$user->isSuperAdmin() || auth()->user()->isSuperAdmin())
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Editar
                                        </a>

                                        <button onclick="openResetModal({{ $user->id }}, '{{ $user->name }}')"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm flex items-center">
                                            <i class="fas fa-key mr-1"></i> Senha
                                        </button>

                                        @if(!$user->isSuperAdmin())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja excluir o usuário {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm flex items-center">
                                                <i class="fas fa-trash mr-1"></i> Excluir
                                            </button>
                                        </form>
                                        @endif
                                        @else
                                        <span class="text-gray-400 text-sm">Ações limitadas</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($users->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-users text-4xl mb-4"></i>
                        <p class="text-lg">Nenhum usuário cadastrado.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para redefinir senha -->
<div id="reset-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <i class="fas fa-key text-blue-600 text-xl"></i>
            </div>

            <h3 class="text-lg font-medium text-gray-900 mt-2">Redefinir Senha</h3>

            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="user-name-text">
                    Redefinir senha para: <strong id="reset-user-name"></strong>
                </p>

                <form id="reset-form" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 text-left">Nova Senha</label>
                        <input type="password" name="password" id="password" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 text-left">Confirmar Senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </form>
            </div>

            <div class="flex justify-center space-x-4 mt-4">
                <button onclick="closeResetModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                    Cancelar
                </button>
                <button onclick="submitResetForm()"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i> Redefinir
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentUserId = null;

    function openResetModal(userId, userName) {
        currentUserId = userId;
        document.getElementById('reset-user-name').textContent = userName;
        document.getElementById('reset-form').action = `/users/${userId}/reset-password`;
        document.getElementById('reset-modal').classList.remove('hidden');
    }

    function closeResetModal() {
        document.getElementById('reset-modal').classList.add('hidden');
        currentUserId = null;
    }

    function submitResetForm() {
        if (currentUserId) {
            document.getElementById('reset-form').submit();
        }
    }

    // Fechar modal ao clicar fora
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('reset-modal');
        if (e.target === modal) {
            closeResetModal();
        }
    });
</script>
@endsection