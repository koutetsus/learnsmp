<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 gap-4 px-3"
>

    <x-sidebar.link
        title="Dashboard"
        href="{{ route('dashboard') }}"
        :isActive="request()->routeIs('dashboard')"
    >
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link
        title="Users"
        href="{{ route('users.index') }}"
        :isActive="request()->routeIs('users.index')"
    >
        <x-slot name="icon">
            <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link
        title="Roles"
        href="{{ route('roles.index') }}"
        :isActive="request()->routeIs('roles.index')"
    >
        <x-slot name="icon">
            <x-eos-role-binding-o class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link
        title="Permissions"
        href="{{ route('permissions.index') }}"
        :isActive="request()->routeIs('permisssions.index')"
    >
        <x-slot name="icon">
            <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true"/>
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link
        title="Materi"
        href="{{ route('materis.index') }}"
        :isActive="request()->routeIs('materis.index')"
    >
        <x-slot name="icon">
            <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true"/>
        </x-slot>
    </x-sidebar.link>

</x-perfect-scrollbar>
