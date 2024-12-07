<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 gap-4 px-3"
>
@can('view-dashboard')
    <x-sidebar.link
        title="Dashboard"
        href="{{ route('dashboard') }}"
        :isActive="request()->routeIs('dashboard')"
    >
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endcan

    @can('view-user')
    <x-sidebar.link
        title="Users"
        href="{{ route('users.index') }}"
        :isActive="request()->routeIs('users.index')"
    >
        <x-slot name="icon">
            <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endcan

    @can('view-role')
    <x-sidebar.link
        title="Roles"
        href="{{ route('roles.index') }}"
        :isActive="request()->routeIs('roles.index')"
    >
        <x-slot name="icon">
            <x-eos-role-binding-o class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endcan

    @can('view-permission')
    <x-sidebar.link
        title="Permissions"
        href="{{ route('permissions.index') }}"
        :isActive="request()->routeIs('permissions.index')"
    >
        <x-slot name="icon">
            <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endcan


    @can('view-materi')
    <x-sidebar.link
        title="Materi"
        href="{{ route('materis.index') }}"
        :isActive="request()->routeIs('materis.index')"
    >
        <x-slot name="icon">
            <x-heroicon-o-book-open class="flex-shrink-0 w-6 h-6" aria-hidden="true"/>
        </x-slot>
    </x-sidebar.link>
    @endcan


    @can('view-formtugas')
    <x-sidebar.link
        title="Submitted"
        href="{{ route('submissions.index') }}"
        :isActive="request()->routeIs('submissions.index')"
    >
        <x-slot name="icon">
            <x-heroicon-o-book-open class="flex-shrink-0 w-6 h-6" aria-hidden="true"/>
        </x-slot>
    </x-sidebar.link>
    @endcan

    @can('view-quiz')
    <x-sidebar.link
        title="Quiz"
        href="{{ route('quizzes.index') }}"
        :isActive="request()->routeIs('quizzes.index')"
    >
        <x-slot name="icon">
            <x-heroicon-o-book-open class="flex-shrink-0 w-6 h-6" aria-hidden="true"/>
        </x-slot>
    </x-sidebar.link>
    @endcan

    @can('view-student-scores')
    <x-sidebar.link
    title="Student Score"
    href="{{ route('student-scores') }}"
    :isActive="request()->routeIs('student-scores')"
    >
        <x-slot name="icon">
            <x-heroicon-o-book-open  class="flex-shrink-0 w-6 h-6" aria-hidden="true"/>
        </x-slot>
    </x-sidebar.link>
    @endcan

</x-perfect-scrollbar>
