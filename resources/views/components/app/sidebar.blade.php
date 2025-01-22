<div>
    <!-- Sidebar backdrop (mobile only) -->
    <div
        class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
        aria-hidden="true"
        x-cloak
    ></div>
    <!-- Sidebar -->
    <div
        id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'"
        @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false"
        x-cloak="lg"
    >

        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block" href="{{ route('dashboard') }}">
                <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <!-- Gradient Definitions -->
                        <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#4F46E5" />
                            <stop offset="100%" stop-color="#9333EA" />
                        </linearGradient>
                        <linearGradient id="gradient2" x1="100%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#3B82F6" />
                            <stop offset="100%" stop-color="#1D4ED8" />
                        </linearGradient>
                    </defs>

                    <!-- Background Circle -->
                    <circle cx="16" cy="16" r="16" fill="url(#gradient1)" />

                    <!-- Central Node -->
                    <circle cx="16" cy="16" r="6" fill="url(#gradient2)" />

                    <!-- Network Nodes -->
                    <circle cx="10" cy="10" r="2" fill="#FFFFFF" />
                    <circle cx="22" cy="10" r="2" fill="#FFFFFF" />
                    <circle cx="10" cy="22" r="2" fill="#FFFFFF" />
                    <circle cx="22" cy="22" r="2" fill="#FFFFFF" />

                    <!-- Connecting Lines -->
                    <line x1="10" y1="10" x2="16" y2="16" stroke="#FFFFFF" stroke-width="1" />
                    <line x1="22" y1="10" x2="16" y2="16" stroke="#FFFFFF" stroke-width="1" />
                    <line x1="10" y1="22" x2="16" y2="16" stroke="#FFFFFF" stroke-width="1" />
                    <line x1="22" y1="22" x2="16" y2="16" stroke="#FFFFFF" stroke-width="1" />
                </svg>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                </h3>
                <ul class="mt-3">

                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['dashboard'])){{ 'bg-slate-900' }}@endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['inbox'])){{ 'hover:text-slate-200' }}@endif"
                        @if(Route::is('dashboard')){{ '!text-indigo-500' }}@endif"
                        href="{{ route('dashboard') }}"
                        wire:navigate>
                        <div class="flex items-center">
                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                <path class="fill-current @if(in_array(Request::segment(1), ['dashboard'])){{ 'text-indigo-500' }}@else{{ 'text-slate-400' }}@endif" d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0z" />
                                <path class="fill-current @if(in_array(Request::segment(1), ['dashboard'])){{ 'text-indigo-600' }}@else{{ 'text-slate-600' }}@endif" d="M12 3c-4.963 0-9 4.037-9 9s4.037 9 9 9 9-4.037 9-9-4.037-9-9-9z" />
                                <path class="fill-current @if(in_array(Request::segment(1), ['dashboard'])){{ 'text-indigo-200' }}@else{{ 'text-slate-400' }}@endif" d="M12 15c-1.654 0-3-1.346-3-3 0-.462.113-.894.3-1.285L6 6l4.714 3.301A2.973 2.973 0 0112 9c1.654 0 3 1.346 3 3s-1.346 3-3 3z" />
                            </svg>
                            <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                        </div>
                        </a>
                    </li>

                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['network-show'])){{ 'bg-slate-900' }}@endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['inbox'])){{ 'hover:text-slate-200' }}@endif"
                        @if(Route::is('network-show')){{ '!text-indigo-500' }}@endif"
                        href="{{ route('network-show') }}"
                        wire:navigate>
                        <div class="flex items-center">
                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                <path class="fill-current @if(in_array(Request::segment(1), ['network-show'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"  d="M20 7a.75.75 0 01-.75-.75 1.5 1.5 0 00-1.5-1.5.75.75 0 110-1.5 1.5 1.5 0 001.5-1.5.75.75 0 111.5 0 1.5 1.5 0 001.5 1.5.75.75 0 110 1.5 1.5 1.5 0 00-1.5 1.5A.75.75 0 0120 7zM4 23a.75.75 0 01-.75-.75 1.5 1.5 0 00-1.5-1.5.75.75 0 110-1.5 1.5 1.5 0 001.5-1.5.75.75 0 111.5 0 1.5 1.5 0 001.5 1.5.75.75 0 110 1.5 1.5 1.5 0 00-1.5 1.5A.75.75 0 014 23z"></path>
                                <path class="fill-current @if(in_array(Request::segment(1), ['network-show'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif"  d="M17 23a1 1 0 01-1-1 4 4 0 00-4-4 1 1 0 010-2 4 4 0 004-4 1 1 0 012 0 4 4 0 004 4 1 1 0 010 2 4 4 0 00-4 4 1 1 0 01-1 1zM7 13a1 1 0 01-1-1 4 4 0 00-4-4 1 1 0 110-2 4 4 0 004-4 1 1 0 112 0 4 4 0 004 4 1 1 0 010 2 4 4 0 00-4 4 1 1 0 01-1 1z"></path>
                            </svg>
                            <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">My Network</span>
                        </div>
                        </a>
                    </li>

                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if(in_array(Request::segment(1), ['devices.show'])){{ 'bg-slate-900' }}@endif">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['inbox'])){{ 'hover:text-slate-200' }}@endif"
                        @if(Route::is('devices.show')){{ '!text-indigo-500' }}@endif"
                        href="{{ route('devices.show') }}"
                        wire:navigate>
                        <div class="flex items-center">
                            <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Networking Device Icon -->
                                <path class="fill-current @if(in_array(Request::segment(1), ['devices.show'])){{ 'text-indigo-500' }}@else{{ 'text-slate-600' }}@endif" d="M20 13C20 14.1046 19.1046 15 18 15H6C4.89543 15 4 14.1046 4 13V5C4 3.89543 4.89543 3 6 3H18C19.1046 3 20 3.89543 20 5V13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path class="fill-current @if(in_array(Request::segment(1), ['devices.show'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M12 15V18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path class="fill-current @if(in_array(Request::segment(1), ['devices.show'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M8 18H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path class="fill-current @if(in_array(Request::segment(1), ['devices.show'])){{ 'text-indigo-300' }}@else{{ 'text-slate-400' }}@endif" d="M8 21H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Devices</span>
                        </div>
                        </a>
                    </li>


                </ul>
            </div>

        </div>

        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="px-3 py-2">
                <button @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                        <path class="text-slate-400" d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-slate-600" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
