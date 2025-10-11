@extends('layouts.app')

@section('title', 'Todas as Consultas')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Todas as Consultas</h2>
                    <a href="{{ route('appointments.create') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i> Nova Consulta
                    </a>
                </div>

                <!-- Filtro de Busca -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('appointments.index') }}" class="flex gap-4">
                        <div class="flex-1">
                            <input type="text"
                                name="search"
                                id="search"
                                value="{{ request('search') }}"
                                placeholder="Buscar por nome do paciente..."
                                class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                            <i class="fas fa-search mr-2"></i> Buscar
                        </button>
                        @if(request('search'))
                        <a href="{{ route('appointments.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                            <i class="fas fa-times mr-2"></i> Limpar
                        </a>
                        @endif
                    </form>
                </div>

                <!-- Informações de Resultados -->
                @if(request('search'))
                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                    <p class="text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        @if($appointments->total() > 0)
                        Mostrando {{ $appointments->firstItem() }} - {{ $appointments->lastItem() }} de
                        {{ $appointments->total() }} consulta(s) encontrada(s) para "{{ request('search') }}"
                        @else
                        Nenhuma consulta encontrada para "{{ request('search') }}"
                        @endif
                    </p>
                </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-3 px-4 text-left">Paciente</th>
                                <th class="py-3 px-4 text-left">Telefone</th>
                                <th class="py-3 px-4 text-left">Data e Hora</th>
                                <th class="py-3 px-4 text-left">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="font-medium text-gray-900">{{ $appointment->patient_name }}</div>
                                </td>
                                <td class="py-3 px-4">{{ $appointment->phone_number }}</td>
                                <td class="py-3 px-4">
                                    <div class="text-gray-900">{{ $appointment->datetime->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $appointment->datetime->format('H:i') }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('appointments.edit', $appointment) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Editar
                                        </a>
                                        <button type="button"
                                            onclick="openDeleteModal({{ $appointment->id }}, '{{ $appointment->patient_name }}', '{{ $appointment->datetime->format('d/m/Y H:i') }}')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm flex items-center">
                                            <i class="fas fa-trash mr-1"></i> Cancelar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($appointments->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-calendar-times text-4xl mb-4"></i>
                        <p class="text-lg">Nenhuma consulta agendada.</p>
                        @if(request('search'))
                        <p class="text-sm mt-2">Tente alterar os termos da busca.</p>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Paginação -->
                @if($appointments->hasPages())
                <div class="mt-6">
                    {{ $appointments->links() }}
                </div>
                @endif

                <!-- Estatísticas -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-check mr-2 text-green-500"></i>
                            <span>Total de consultas: <strong>{{ $appointments->total() }}</strong></span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2 text-blue-500"></i>
                            <span>Página {{ $appointments->currentPage() }} de {{ $appointments->lastPage() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <!-- Ícone de Alerta -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>

            <h3 class="text-lg font-medium text-gray-900 mt-2">Cancelar Consulta</h3>

            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Tem certeza que deseja cancelar a consulta de <strong id="patient-name"></strong>?
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Data: <strong id="appointment-date"></strong>
                </p>
                <p class="text-sm text-red-500 mt-3 font-medium">
                    Esta ação não pode ser desfeita!
                </p>
            </div>

            <div class="flex justify-center space-x-4 mt-4">
                <button onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                    Manter Consulta
                </button>
                <button onclick="confirmDelete()"
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200 flex items-center">
                    <i class="fas fa-trash mr-2"></i> Cancelar Consulta
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Formulário de Exclusão (hidden) -->
<form id="delete-form" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    let currentAppointmentId = null;

    // Função para abrir o modal de exclusão
    function openDeleteModal(appointmentId, patientName, appointmentDate) {
        currentAppointmentId = appointmentId;

        // Atualiza as informações no modal
        document.getElementById('patient-name').textContent = patientName;
        document.getElementById('appointment-date').textContent = appointmentDate;

        // Atualiza o action do formulário
        document.getElementById('delete-form').action = `/appointments/${appointmentId}`;

        // Mostra o modal
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    // Função para fechar o modal
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
        currentAppointmentId = null;
    }

    // Função para confirmar a exclusão
    function confirmDelete() {
        if (currentAppointmentId) {
            document.getElementById('delete-form').submit();
        }
    }

    // Fechar modal ao clicar fora
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('delete-modal');
        if (e.target === modal) {
            closeDeleteModal();
        }
    });

    // Fechar modal com a tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endpush
@endsection