<ul class="nav">
    <li class="nav-item">
        <x-nav-link class="nav-link" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>
    </li>

    @can('viewAny', 'App\Model\User')
    <li class="nav-item">
        <x-nav-link class="nav-link" :href="route('users.index')" :active="request()->routeIs('users.index')">
            {{ __('Users') }}
        </x-nav-link>
    </li>
    @endcan

    <li class="nav-item">
        <x-nav-link class="nav-link" :href="route('campaigns.index')" :active="request()->routeIs('campaigns.index')">
            {{ __('Campaigns') }}
        </x-nav-link>
    </li>

</ul>

