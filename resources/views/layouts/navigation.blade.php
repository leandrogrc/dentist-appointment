<nav class="bg-white border-b border-gray-100" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-tooth mr-2"></i>Consultório Dr. Nelson
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('calendar.weekly')" :active="request()->routeIs('calendar.weekly')">
                        Calendário
                    </x-nav-link>
                    <x-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.index')">
                        Todas as Consultas
                    </x-nav-link>

                    <!-- Link para Gerenciar Usuários (apenas para super admin) -->
                    @auth
                    @if(auth()->user()->isSuperAdmin())
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        <i class="fas fa-users mr-1"></i> Usuários
                    </x-nav-link>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                        style="display: none;">
                        <div class="py-1">
                            <a
                                href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-edit mr-2 w-4 text-center"></i>Perfil
                            </a>

                            <!-- Link para Usuários no Dropdown (apenas para super admin) -->
                            @if(auth()->user()->isSuperAdmin())
                            <a
                                href="{{ route('users.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-users mr-2 w-4 text-center"></i>Gerenciar Usuários
                            </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2 w-4 text-center"></i>Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div class="sm:hidden flex items-center">
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <i class="fas fa-bars mr-2"></i>
                        Menu
                        <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Mobile Dropdown Menu -->
                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                        style="display: none;">

                        <!-- Navigation Links -->
                        <div class="py-2 border-b border-gray-100">
                            <a
                                href="{{ route('calendar.weekly') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('calendar.weekly') ? 'bg-blue-50 text-blue-700' : '' }}">
                                <i class="fas fa-calendar-alt mr-3 w-4 text-center"></i>Calendário
                            </a>
                            <a
                                href="{{ route('appointments.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('appointments.index') ? 'bg-blue-50 text-blue-700' : '' }}">
                                <i class="fas fa-list-alt mr-3 w-4 text-center"></i>Todas as Consultas
                            </a>

                            <!-- Link para Usuários no Mobile (apenas para super admin) -->
                            @if(auth()->user()->isSuperAdmin())
                            <a
                                href="{{ route('users.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                                <i class="fas fa-users mr-3 w-4 text-center"></i>Gerenciar Usuários
                            </a>
                            @endif
                        </div>

                        <!-- User Info -->
                        <div class="py-2 px-4 border-b border-gray-100">
                            <div class="text-xs font-medium text-gray-500">Logado como</div>
                            <div class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                        </div>

                        <!-- User Actions -->
                        <div class="py-2">
                            <a
                                href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-edit mr-3 w-4 text-center"></i>Meu Perfil
                            </a>

                            <!-- Link adicional para Usuários (apenas para super admin) -->
                            @if(auth()->user()->isSuperAdmin())
                            <a
                                href="{{ route('users.create') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-plus mr-3 w-4 text-center"></i>Novo Usuário
                            </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-3 w-4 text-center"></i>Sair da Conta
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>