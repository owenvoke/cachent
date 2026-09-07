<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

            <flux:spacer />

            {{-- Uploading is public, so the header has to serve guests too. --}}
            @auth
                <x-desktop-user-menu />
            @else
                <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                    <flux:navbar.item :href="route('login')" wire:navigate>
                        {{ __('Log in') }}
                    </flux:navbar.item>

                    @if (Route::has('register'))
                        <flux:navbar.item :href="route('register')" wire:navigate>
                            {{ __('Register') }}
                        </flux:navbar.item>
                    @endif
                </flux:navbar>
            @endauth
        </flux:header>

        {{-- Mobile menu --}}
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>

                @guest
                    <flux:sidebar.item :href="route('login')" wire:navigate>
                        {{ __('Log in') }}
                    </flux:sidebar.item>

                    @if (Route::has('register'))
                        <flux:sidebar.item :href="route('register')" wire:navigate>
                            {{ __('Register') }}
                        </flux:sidebar.item>
                    @endif
                @endguest
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/owenvoke/cachent" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>
        </flux:sidebar>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
