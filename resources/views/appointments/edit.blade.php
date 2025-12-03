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
                        @if($appointment->dentist_name)
                        <div>
                            <span class="font-medium text-gray-700">Dentista:</span>
                            <span class="text-gray-900">{{ $appointment->dentist_name }}</span>
                        </div>
                        @endif
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
                        <div>
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

                        <!-- Dentist Responsible -->
                        <div>
                            <label for="dentist_name" class="block text-sm font-medium text-gray-700">
                                Dentista Responsável *
                            </label>
                            <select name="dentist_name"
                                id="dentist_name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="">Selecione um dentista</option>
                                <option value="Dr. Nelson" {{ old('dentist_name', $appointment->dentist_name) == 'Dr. Nelson' ? 'selected' : '' }}>
                                    Dr. Nelson
                                </option>
                                <option value="Dra. Alessandra" {{ old('dentist_name', $appointment->dentist_name) == 'Dra. Alessandra' ? 'selected' : '' }}>
                                    Dra. Alessandra
                                </option>
                            </select>
                            @error('dentist_name')
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
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $appointment->notes) }}
                            </textarea>
                            <span class="text-xs text-gray-500">As observações ficarão ao lado do nome do paciente no calendário.</span>
                            @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="missed" class="block text-sm font-medium text-gray-700 mb-2">
                                Status da Consulta
                            </label>
                            <label for="missed" class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="missed" value="0">
                                <input type="checkbox"
                                    name="missed"
                                    id="missed"
                                    value="1"
                                    class="sr-only peer"
                                    {{ old('missed', $appointment->missed) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-500"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Marcar como ausente</span>
                            </label>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col-reverse md:flex-row justify-between items-center mt-8 gap-4 md:gap-0">
                        <!-- Botão de Excluir -->
                        <button type="button"
                            onclick="openDeleteModal()"
                            class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg flex items-center justify-center transition duration-200">
                            <i class="fas fa-trash mr-2"></i> Cancelar Consulta
                        </button>

                        <!-- Botões de Ação -->
                        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                            <a href="{{ route('appointments.index') }}"
                                class="w-full md:w-auto bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-center transition duration-200">
                                Voltar
                            </a>
                            <button type="submit"
                                class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center justify-center transition duration-200">
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
                <p class="text-sm text-gray-500 mt-2">
                    Dentista: <strong>{{ $appointment->dentist_responsible ?? 'Não definido' }}</strong>
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