@extends('layouts.app')

@section('title', 'Editar Consulta')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Consulta</h2>

                <!-- Informações da Consulta -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Informações da Consulta</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Paciente:</span>
                            <span class="text-gray-900">{{ $appointment->patient_name }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Telefone:</span>
                            <span class="text-gray-900">{{ $appointment->phone_number }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Data:</span>
                            <span class="text-gray-900">{{ $appointment->datetime->format('d/m/Y') }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Horário:</span>
                            <span class="text-gray-900">{{ $appointment->datetime->format('H:i') }}</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Patient Name -->
                        <div>
                            <label for="patient_name" class="block text-sm font-medium text-gray-700">
                                Nome do Paciente *
                            </label>
                            <input type="text"
                                name="patient_name"
                                id="patient_name"
                                value="{{ old('patient_name', $appointment->patient_name) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('patient_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">
                                Telefone *
                            </label>
                            <input type="tel"
                                name="phone_number"
                                id="phone_number"
                                value="{{ old('phone_number', $appointment->phone_number) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="(11) 9 9999-9999"
                                required
                                maxlength="15">
                            @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date and Time -->
                        <div class="md:col-span-2">
                            <label for="datetime" class="block text-sm font-medium text-gray-700">
                                Data e Hora *
                            </label>
                            <input type="datetime-local"
                                name="datetime"
                                id="datetime"
                                value="{{ old('datetime', $appointment->datetime->format('Y-m-d\TH:i')) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('datetime')
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
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $appointment->notes) }}</textarea>
                            @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-between items-center mt-8">
                        <!-- Botão de Excluir -->
                        <button type="button"
                            onclick="openDeleteModal()"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg flex items-center transition duration-200">
                            <i class="fas fa-trash mr-2"></i> Cancelar Consulta
                        </button>

                        <!-- Botões de Ação -->
                        <div class="flex space-x-4">
                            <a href="{{ route('appointments.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                                Voltar
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center transition duration-200">
                                <i class="fas fa-save mr-2"></i> Atualizar Consulta
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Formulário de Exclusão -->
                <form id="delete-form" action="{{ route('appointments.destroy', $appointment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
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

            <h3 class="text-lg font-medium text-gray-900 mt-2">Excluir Consulta</h3>

            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Tem certeza que deseja excluir a consulta de <strong>{{ $appointment->patient_name }}</strong>?
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Data: <strong>{{ $appointment->datetime->format('d/m/Y H:i') }}</strong>
                </p>
                <p class="text-sm text-red-500 mt-3 font-medium">
                    Esta ação não pode ser desfeita!
                </p>
            </div>

            <div class="flex justify-center space-x-4 mt-4">
                <button onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                    Cancelar
                </button>
                <button onclick="confirmDelete()"
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200 flex items-center">
                    <i class="fas fa-trash mr-2"></i> Excluir
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.getElementById('phone_number');

        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            // Aplica a máscara: (99) 9 9999-9999
            if (value.length <= 10) {
                // Formato antigo: (99) 9999-9999
                value = value.replace(/^(\d{2})(\d{0,4})(\d{0,4})/, '($1) $2$3');
                if (value.length > 9) {
                    value = value.replace(/(\d{4})(\d{1,4})/, '$1-$2');
                }
            } else {
                // Formato novo: (99) 9 9999-9999
                value = value.replace(/^(\d{2})(\d{0,1})(\d{0,4})(\d{0,4})/, '($1) $2 $3$4');
                if (value.length > 9) {
                    value = value.replace(/(\d{4})(\d{1,4})/, '$1-$2');
                }
            }

            e.target.value = value;
        });

        phoneInput.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace') {
                return true;
            }
        });
    });

    // Funções para o modal de exclusão
    function openDeleteModal() {
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }

    function confirmDelete() {
        document.getElementById('delete-form').submit();
    }

    // Fechar modal ao clicar fora
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('delete-modal');
        if (e.target === modal) {
            closeDeleteModal();
        }
    });
</script>
@endpush
@endsection