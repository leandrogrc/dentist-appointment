@extends('layouts.app')

@section('title', 'Calendário Semanal')

@section('content')
<div class="py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-6 bg-white border-b border-gray-200">

                <!-- Week Navigation -->
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('calendar.weekly', ['date' => $previousWeek->format('Y-m-d')]) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 sm:px-4 py-2 rounded-lg flex items-center text-sm sm:text-base">
                        <i class="fas fa-chevron-left mr-1 sm:mr-2"></i>
                        <span class="hidden sm:inline">Semana Anterior</span>
                        <span class="sm:hidden">Anterior</span>
                    </a>

                    <h2 class="text-lg sm:text-2xl font-bold text-gray-800 text-center">
                        {{ $startOfWeek->format('d/m/Y') }} - {{ $endOfWeek->format('d/m/Y') }}
                    </h2>

                    <a href="{{ route('calendar.weekly', ['date' => $nextWeek->format('Y-m-d')]) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 sm:px-4 py-2 rounded-lg flex items-center text-sm sm:text-base">
                        <span class="hidden sm:inline">Próxima Semana</span>
                        <span class="sm:hidden">Próxima</span>
                        <i class="fas fa-chevron-right ml-1 sm:ml-2"></i>
                    </a>
                </div>

                <!-- Weekly Calendar -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-3 sm:gap-4">
                    @foreach($weekDays as $day)
                    <div class="border rounded-lg {{ $day->isToday() ? 'bg-blue-50 border-blue-300' : 'bg-gray-50' }}">
                        <!-- Day Header -->
                        <div class="bg-gray-100 p-2 sm:p-3 border-b text-center">
                            <div class="font-semibold text-gray-800 text-sm sm:text-base">
                                {{ $day->translatedFormat('D') }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600 mt-1">
                                {{ $day->format('d/m') }}
                                @if($day->isToday())
                                <span class="inline-block w-2 h-2 bg-blue-500 rounded-full ml-1"></span>
                                @endif
                            </div>
                        </div>

                        <!-- Day Sections -->
                        <div class="divide-y">
                            <!-- Morning Section (00:00 - 11:59) -->
                            <div class="p-2 sm:p-3">
                                <div class="text-xs font-semibold text-gray-500 mb-2 flex items-center">
                                    <i class="fas fa-sun text-yellow-500 mr-1"></i>
                                    Manhã
                                </div>
                                <div class="min-h-20 sm:min-h-24">
                                    @php
                                    $dayAppointments = $appointments[$day->format('Y-m-d')] ?? collect();
                                    $morningAppointments = $dayAppointments->filter(function($appointment) {
                                    return $appointment->datetime->format('H:i') < '12:00' ;
                                        });
                                        @endphp

                                        @foreach($morningAppointments as $appointment)
                                        <a href="{{ route('appointments.edit', $appointment) }}"
                                        class="block bg-green-100 border border-green-300 rounded p-2 mb-2 hover:bg-green-200 hover:border-green-400 transition-all duration-200 cursor-pointer group">
                                        <div class="font-medium text-green-800 group-hover:text-green-900 text-sm sm:text-base">
                                            {{ $appointment->patient_name }}
                                            <i class="fas fa-edit ml-1 text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="text-xs sm:text-sm text-green-600 group-hover:text-green-700">
                                            {{ $appointment->datetime->format('H:i') }}
                                        </div>
                                        <div class="text-xs text-green-500 mt-1 group-hover:text-green-600">
                                            {{ $appointment->phone_number }}
                                        </div>
                                        </a>
                                        @endforeach

                                        @if($morningAppointments->isEmpty())
                                        <div class="text-center text-gray-400 text-xs py-3">
                                            Nenhuma consulta
                                        </div>
                                        @endif
                                </div>
                            </div>

                            <!-- Afternoon Section (12:00 - 23:59) -->
                            <div class="p-2 sm:p-3">
                                <div class="text-xs font-semibold text-gray-500 mb-2 flex items-center">
                                    <i class="fas fa-sun text-blue-500 mr-1"></i>
                                    Tarde
                                </div>
                                <div class="min-h-20 sm:min-h-24">
                                    @php
                                    $afternoonAppointments = $dayAppointments->filter(function($appointment) {
                                    return $appointment->datetime->format('H:i') >= '12:00';
                                    });
                                    @endphp

                                    @foreach($afternoonAppointments as $appointment)
                                    <a href="{{ route('appointments.edit', $appointment) }}"
                                        class="block bg-green-100 border border-green-300 rounded p-2 mb-2 hover:bg-green-200 hover:border-green-400 transition-all duration-200 cursor-pointer group">
                                        <div class="font-medium text-green-800 group-hover:text-green-900 text-sm sm:text-base">
                                            {{ $appointment->patient_name }}
                                            <i class="fas fa-edit ml-1 text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                        </div>
                                        <div class="text-xs sm:text-sm text-green-600 group-hover:text-green-700">
                                            {{ $appointment->datetime->format('H:i') }}
                                        </div>
                                        <div class="text-xs text-green-500 mt-1 group-hover:text-green-600">
                                            {{ $appointment->phone_number }}
                                        </div>
                                    </a>
                                    @endforeach

                                    @if($afternoonAppointments->isEmpty())
                                    <div class="text-center text-gray-400 text-xs py-3">
                                        Nenhuma consulta
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Add Button -->
<a href="{{ route('appointments.create') }}"
    class="fixed bottom-6 right-6 sm:bottom-8 sm:right-8 bg-blue-500 hover:bg-blue-600 text-white w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 z-50">
    <i class="fas fa-plus text-lg sm:text-xl"></i>
</a>

<style>
    /* Garantir que os links sejam clicáveis em todo o card */
    .min-h-20 a,
    .min-h-24 a {
        display: block;
        text-decoration: none;
    }
</style>
@endsection