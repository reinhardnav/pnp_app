
{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
{{--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon" style="color:white !important;"></i> {{ trans('backpack::base.dashboard') }}</a></li>--}}
{{--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user" style="color:white !important;"></i> Users</a></li>--}}
{{--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('clients') }}"><i class="nav-icon la la-dollar" style="color:white !important;"></i> Clients</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('proposals') }}"><i class="nav-icon la la-book" style="color:white !important;"></i> Proposals</a></li>--}}
{{---@includeWhen(class_exists(\Backpack\DevTools\DevToolsServiceProvider::class), 'backpack.devtools::buttons.sidebar_item')-}}
{{--@if(backpack_auth()->user()->email == 'matthew@ionline.com.au' || backpack_auth()->user()->email == 'rnavarro@ionline.com.au' )

@endif--}}

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('claimant-entry') }}"><i class="nav-icon la la-pencil-square"></i> Claimant entries</a></li>
<li class="nav-item"><a class="nav-link" href="/admin/reports"><i class="nav-icon la la la-bar-chart"></i> Reports</a></li>
@role('Admin')
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Access</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
@endrole


<!--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('clients') }}"><i class="nav-icon la la-th-list"></i> Clients</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('proposals') }}"><i class="nav-icon la la-th-list"></i> Proposals</a></li>-->
{{--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-th-list"></i> Users</a></li>--}}
