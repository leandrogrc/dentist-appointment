@if($appointment->missed)
<a href="{{ route('appointments.edit', $appointment) }}"
    class="block bg-red-50 border border-red-200 hover:bg-red-100 hover:border-red-300 rounded-lg p-2 transition-all duration-200 cursor-pointer group relative shadow-sm">
    <div class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full shadow">
        <i class="fas fa-times mr-1"></i>Faltou
    </div>
    <div class="font-medium text-red-800 group-hover:text-red-900 text-sm sm:text-base line-through">
        {{ $appointment->patient_name }} {{ $appointment->notes ? ' - ' . $appointment->notes : '' }}
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
        {{ $appointment->patient_name }} {{ $appointment->notes ? ' - ' . $appointment->notes : '' }}
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
