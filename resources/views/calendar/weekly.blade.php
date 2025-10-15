@extends('layouts.app')

@section('title', 'Calendário Semanal')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Week Navigation -->
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('calendar.weekly', ['date' => $previousWeek->format('Y-m-d')]) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-chevron-left mr-2"></i> Semana Anterior
                    </a>

                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $startOfWeek->format('d/m/Y') }} - {{ $endOfWeek->format('d/m/Y') }}
                    </h2>

                    <a href="{{ route('calendar.weekly', ['date' => $nextWeek->format('Y-m-d')]) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                        Próxima Semana <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                </div>

                <!-- TABELA DA MANHÃ -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-center mb-6">
                            <i class="fas fa-sun text-yellow-500 text-xl mr-3"></i>
                            <h2 class="text-2xl font-bold text-gray-800">CONSULTAS DA MANHÃ</h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-3 sm:gap-4">
                            @foreach($weekDays as $day)
                            <div class="border rounded-lg {{ $day->isToday() ? 'bg-blue-50 border-blue-300 shadow-sm' : 'bg-white border-gray-200' }} shadow-sm">
                                <!-- Cabeçalho do dia -->
                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-3 sm:p-4 border-b text-center">
                                    <div class="text-sm font-semibold text-gray-700">{{ $day->format('d/m') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        @php
                                        $daysPt = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
                                        $dayNumber = $day->dayOfWeek;
                                        @endphp
                                        {{ $daysPt[$dayNumber] }}
                                    </div>
                                </div>

                                <!-- Conteúdo da manhã -->
                                <div class="p-2 sm:p-3">
                                    <div class="min-h-20 sm:min-h-24 space-y-2">
                                        @php
                                        $dayAppointments = $appointments[$day->format('Y-m-d')] ?? collect();
                                        $morningAppointments = $dayAppointments->filter(function($appointment) {
                                        return $appointment->datetime->format('H:i') < '12:00' ;
                                            });
                                            @endphp

                                            @forelse($morningAppointments as $appointment)
                                            @if($appointment->missed)
                                            <a href="{{ route('appointments.edit', $appointment) }}"
                                                class="block bg-red-50 border border-red-200 hover:bg-red-100 hover:border-red-300 rounded-lg p-2 transition-all duration-200 cursor-pointer group relative shadow-sm">
                                                <div class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full shadow">
                                                    <i class="fas fa-times mr-1"></i>Faltou
                                                </div>
                                                <div class="font-medium text-red-800 group-hover:text-red-900 text-sm sm:text-base line-through">
                                                    {{ $appointment->patient_name }}
                                                    <i class="fas fa-edit ml-1 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                                </div>
                                                <div class="text-xs sm:text-sm text-red-600 group-hover:text-red-700">
                                                    {{ $appointment->datetime->format('H:i') }}
                                                </div>
                                                <div class="text-xs text-red-500 group-hover:text-red-600 mt-1">
                                                    {{ $appointment->phone_number }}
                                                </div>
                                                @if($appointment->dentist_name)
                                                <div class="text-xs text-red-700 group-hover:text-red-800 mt-1 font-medium">
                                                    {{ $appointment->dentist_name }}
                                                </div>
                                                @endif
                                            </a>
                                            @else
                                            <a href="{{ route('appointments.edit', $appointment) }}"
                                                class="block {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'bg-orange-50 border-orange-200 hover:bg-orange-100 hover:border-orange-300' : 'bg-green-50 border-green-200 hover:bg-green-100 hover:border-green-300' }} border rounded-lg p-2 transition-all duration-200 cursor-pointer group shadow-sm">
                                                <div class="font-medium {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'text-orange-800 group-hover:text-orange-900' : 'text-green-800 group-hover:text-green-900' }} text-sm sm:text-base">
                                                    {{ $appointment->patient_name }}
                                                    <i class="fas fa-edit ml-1 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                                </div>
                                                <div class="text-xs sm:text-sm {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'text-orange-600 group-hover:text-orange-700' : 'text-green-600 group-hover:text-green-700' }}">
                                                    {{ $appointment->datetime->format('H:i') }}
                                                </div>
                                                <div class="text-xs {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'text-orange-500 group-hover:text-orange-600' : 'text-green-500 group-hover:text-green-600' }} mt-1">
                                                    {{ $appointment->phone_number }}
                                                </div>
                                                @if($appointment->dentist_name)
                                                <div class="text-xs {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'text-orange-700 group-hover:text-orange-800' : 'text-green-700 group-hover:text-green-800' }} mt-1 font-medium">
                                                    {{ $appointment->dentist_name }}
                                                </div>
                                                @endif
                                            </a>
                                            @endif
                                            @empty
                                            <div class="text-center text-gray-400 text-xs py-4 bg-gray-50 rounded-lg border border-gray-100">
                                                <i class="fas fa-coffee text-gray-300 mb-1 block text-lg"></i>
                                                Nenhuma consulta
                                            </div>
                                            @endforelse
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- TABELA DA TARDE -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-center mb-6">
                            <i class="fas fa-moon text-indigo-500 text-xl mr-3"></i>
                            <h2 class="text-2xl font-bold text-gray-800">CONSULTAS DA TARDE</h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-3 sm:gap-4">
                            @foreach($weekDays as $day)
                            <div class="border rounded-lg {{ $day->isToday() ? 'bg-blue-50 border-blue-300 shadow-sm' : 'bg-white border-gray-200' }} shadow-sm">
                                <!-- Cabeçalho do dia -->
                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-3 sm:p-4 border-b text-center">
                                    <div class="text-sm font-semibold text-gray-700">{{ $day->format('d/m') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        @php
                                        $daysPt = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
                                        $dayNumber = $day->dayOfWeek;
                                        @endphp
                                        {{ $daysPt[$dayNumber] }}
                                    </div>
                                </div>

                                <!-- Conteúdo da tarde -->
                                <div class="p-2 sm:p-3">
                                    <div class="min-h-20 sm:min-h-24 space-y-2">
                                        @php
                                        $dayAppointments = $appointments[$day->format('Y-m-d')] ?? collect();
                                        $afternoonAppointments = $dayAppointments->filter(function($appointment) {
                                        return $appointment->datetime->format('H:i') >= '12:00';
                                        });
                                        @endphp

                                        @forelse($afternoonAppointments as $appointment)
                                        @if($appointment->missed)
                                        <a href="{{ route('appointments.edit', $appointment) }}"
                                            class="block bg-red-50 border border-red-200 hover:bg-red-100 hover:border-red-300 rounded-lg p-2 transition-all duration-200 cursor-pointer group relative shadow-sm">
                                            <div class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full shadow">
                                                <i class="fas fa-times mr-1"></i>Faltou
                                            </div>
                                            <div class="font-medium text-red-800 group-hover:text-red-900 text-sm sm:text-base line-through">
                                                {{ $appointment->patient_name }}
                                                <i class="fas fa-edit ml-1 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                            </div>
                                            <div class="text-xs sm:text-sm text-red-600 group-hover:text-red-700">
                                                {{ $appointment->datetime->format('H:i') }}
                                            </div>
                                            <div class="text-xs text-red-500 group-hover:text-red-600 mt-1">
                                                {{ $appointment->phone_number }}
                                            </div>
                                            @if($appointment->dentist_name)
                                            <div class="text-xs text-red-700 group-hover:text-red-800 mt-1 font-medium">
                                                {{ $appointment->dentist_name }}
                                            </div>
                                            @endif
                                        </a>
                                        @else
                                        <a href="{{ route('appointments.edit', $appointment) }}"
                                            class="block {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'bg-orange-50 border-orange-200 hover:bg-orange-100 hover:border-orange-300' : 'bg-green-50 border-green-200 hover:bg-green-100 hover:border-green-300' }} border rounded-lg p-2 transition-all duration-200 cursor-pointer group shadow-sm">
                                            <div class="font-medium {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'text-orange-800 group-hover:text-orange-900' : 'text-green-800 group-hover:text-green-900' }} text-sm sm:text-base">
                                                {{ $appointment->patient_name }}
                                                <i class="fas fa-edit ml-1 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                            </div>
                                            <div class="text-xs sm:text-sm {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'text-orange-600 group-hover:text-orange-700' : 'text-green-600 group-hover:text-green-700' }}">
                                                {{ $appointment->datetime->format('H:i') }}
                                            </div>
                                            <div class="text-xs {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'text-orange-500 group-hover:text-orange-600' : 'text-green-500 group-hover:text-green-600' }} mt-1">
                                                {{ $appointment->phone_number }}
                                            </div>
                                            @if($appointment->dentist_name)
                                            <div class="text-xs {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'text-orange-700 group-hover:text-orange-800' : 'text-green-700 group-hover:text-green-800' }} mt-1 font-medium">
                                                {{ $appointment->dentist_name }}
                                            </div>
                                            @endif
                                        </a>
                                        @endif
                                        @empty
                                        <div class="text-center text-gray-400 text-xs py-4 bg-gray-50 rounded-lg border border-gray-100">
                                            <i class="fas fa-coffee text-gray-300 mb-1 block text-lg"></i>
                                            Nenhuma consulta
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Add Button -->
<a href="{{ route('appointments.create') }}"
    class="fixed bottom-8 right-8 bg-blue-500 hover:bg-blue-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg transition-all duration-300">
    <i class="fas fa-plus text-xl"></i>
</a>
@endsection