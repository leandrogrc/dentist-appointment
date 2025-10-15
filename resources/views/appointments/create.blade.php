@extends('layouts.app')

@section('title', 'Nova Consulta')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Agendar Nova Consulta</h2>

                <form action="{{ route('appointments.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Patient Name -->
                        <div>
                            <label for="patient_name" class="block text-sm font-medium text-gray-700">
                                Nome do Paciente *
                            </label>
                            <input type="text"
                                name="patient_name"
                                id="patient_name"
                                value="{{ old('patient_name') }}"
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
                                value="{{ old('phone_number') }}"
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
                                value="{{ old('datetime') }}"
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
                                <option value="Dr. Nelson" {{ old('dentist_name') == 'Dr. Nelson' ? 'selected' : '' }}>
                                    Dr. Nelson
                                </option>
                                <option value="Dra. Alessandra" {{ old('dentist_name') == 'Dra. Alessandra' ? 'selected' : '' }}>
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
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                            @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-4 mt-8">
                        <a href="{{ route('calendar.weekly') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg flex items-center">
                            <i class="fas fa-save mr-2"></i> Agendar Consulta
                        </button>
                    </div>
                </form>
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

        // Permite navegação com teclas de seta e delete
        phoneInput.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace') {
                return true;
            }
        });
    });
</script>
@endpush
@endsection