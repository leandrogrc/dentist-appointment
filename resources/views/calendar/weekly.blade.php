@extends('layouts.app')

@section('title', 'Calendário Semanal')

@section('content')
<div class="py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-6 bg-white border-b border-gray-200">

                <div class="flex justify-between items-center mb-6">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-3 sm:gap-4">
                    @foreach($weekDays as $day)
                    <div class="border rounded-lg {{ $day->isToday() ? 'bg-blue-50 border-blue-300' : 'bg-gray-50' }}">
                        <div class="bg-gray-100 p-2 sm:p-3 border-b text-center">
                        </div>

                        <div class="divide-y">
                            <div class="p-2 sm:p-3">
                                <div class="text-xs font-semibold text-gray-500 mb-2 flex items-center">
                                    <i class="fas fa-sun text-yellow-500 mr-1"></i>
                                    Manhã
                                </div>
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
                                            class="block bg-red-100 border-red-300 hover:bg-red-200 hover:border-red-400 border rounded p-2 transition-all duration-200 cursor-pointer group relative">
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
                                            class="block {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'bg-orange-100 border-orange-300 hover:bg-orange-200 hover:border-orange-400' : 'bg-green-100 border-green-300 hover:bg-green-200 hover:border-green-400' }} border rounded p-2 transition-all duration-200 cursor-pointer group">
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
                                        <div class="text-center text-gray-400 text-xs py-3">
                                            Nenhuma consulta
                                        </div>
                                        @endforelse
                                </div>
                            </div>

                            <div class="p-2 sm:p-3">
                                <div class="text-xs font-semibold text-gray-500 mb-2 flex items-center">
                                    <i class="fas fa-moon text-indigo-500 mr-1"></i>
                                    Tarde
                                </div>
                                <div class="min-h-20 sm:min-h-24 space-y-2">
                                    @php
                                    $afternoonAppointments = $dayAppointments->filter(function($appointment) {
                                    return $appointment->datetime->format('H:i') >= '12:00';
                                    });
                                    @endphp

                                    @forelse($afternoonAppointments as $appointment)
                                    @if($appointment->missed)
                                    <a href="{{ route('appointments.edit', $appointment) }}"
                                        class="block bg-red-100 border-red-300 hover:bg-red-200 hover:border-red-400 border rounded p-2 transition-all duration-200 cursor-pointer group relative">
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
                                        class="block {{ $appointment->dentist_name == 'Dra. Alessandra' ? 'bg-orange-100 border-orange-300 hover:bg-orange-200 hover:border-orange-400' : 'bg-green-100 border-green-300 hover:bg-green-200 hover:border-green-400' }} border rounded p-2 transition-all duration-200 cursor-pointer group">
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
                                    <div class="text-center text-gray-400 text-xs py-3">
                                        Nenhuma consulta
                                    </div>
                                    @endforelse
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