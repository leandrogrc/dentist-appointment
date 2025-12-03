@extends('layouts.app')

@section('title', 'Calendário Semanal')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Week Navigation -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 md:gap-0">
                    <a href="{{ route('calendar.weekly', ['date' => $previousWeek->format('Y-m-d')]) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center w-full md:w-auto justify-center">
                        <i class="fas fa-chevron-left mr-2"></i> Semana Anterior
                    </a>

                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 text-center">
                        {{ $startOfWeek->format('d/m/Y') }} - {{ $endOfWeek->format('d/m/Y') }}
                    </h2>

                    <a href="{{ route('calendar.weekly', ['date' => $nextWeek->format('Y-m-d')]) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center w-full md:w-auto justify-center">
                        Próxima Semana <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                </div>

                <!-- MOBILE/TABLET VIEW (By Day) -->
                <div class="lg:hidden space-y-6 mb-6">
                    @foreach($weekDays as $day)
                    <div class="{{ $day->isToday() ? 'bg-blue-50 border-blue-300 ring-1 ring-blue-300' : 'bg-white border-gray-200' }} overflow-hidden shadow-sm rounded-lg border">
                        <!-- Day Header -->
                        <div class="bg-gray-50 p-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="font-bold text-lg text-gray-800">{{ $day->format('d/m/Y') }}</div>
                            <div class="text-sm font-medium text-gray-500">
                                @php
                                $daysPt = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
                                echo $daysPt[$day->dayOfWeek];
                                @endphp
                            </div>
                        </div>

                        <div class="p-4 space-y-4">
                            @php
                            $dayAppointments = $appointments[$day->format('Y-m-d')] ?? collect();
                            $morningAppointments = $dayAppointments->filter(fn($a) => $a->datetime->format('H:i') < '12:00');
                            $afternoonAppointments = $dayAppointments->filter(fn($a) => $a->datetime->format('H:i') >= '12:00');
                            @endphp

                            <!-- Morning -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-sun text-yellow-500 mr-2"></i>
                                    <h3 class="font-semibold text-gray-700">Manhã</h3>
                                </div>
                                <div class="space-y-2">
                                    @forelse($morningAppointments as $appointment)
                                        @include('calendar.partials.appointment-card', ['appointment' => $appointment])
                                    @empty
                                        <div class="text-gray-400 text-sm italic">Nenhuma consulta</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Afternoon -->
                            <div>
                                <div class="flex items-center mb-2 mt-4">
                                    <i class="fas fa-moon text-indigo-500 mr-2"></i>
                                    <h3 class="font-semibold text-gray-700">Tarde</h3>
                                </div>
                                <div class="space-y-2">
                                    @forelse($afternoonAppointments as $appointment)
                                        @include('calendar.partials.appointment-card', ['appointment' => $appointment])
                                    @empty
                                        <div class="text-gray-400 text-sm italic">Nenhuma consulta</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- TABELA DA MANHÃ (Desktop) -->
                <div class="hidden lg:block bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
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
                                                @include('calendar.partials.appointment-card', ['appointment' => $appointment])
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

                <!-- TABELA DA TARDE (Desktop) -->
                <div class="hidden lg:block bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
                                            @include('calendar.partials.appointment-card', ['appointment' => $appointment])
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