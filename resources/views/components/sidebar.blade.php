@php
$links = [
[
"href" => "dashboard",
"icon" => "fire",
"text" => "Dashboard",
"is_multi" => false,
],
[
"href" => [
[
"section_text" => "Manage",
"section_list" => [
["href" => "product-master.index", "text" => "Product Master"],
["href" => "setting.index", "text" => "Settings"],
["href" => "banks.index", "text" => "Banks"],
]
]
],
"text" => "User",
"is_multi" => true,
],
[
"href" => "users.index",
"icon" => "users",
"text" => "Users",
"is_multi" => false,
],
[
"href" => "customer.index",
"icon" => "users",
"text" => "Customers",
"is_multi" => false,
],
[
"href" => "invoice.index",
"icon" => "file",
"text" => "Invoices",
"is_multi" => false,
],
[
"href" => "invoice-performa.index",
"icon" => "file",
"text" => "Profoma Invoices",
"is_multi" => false,
],
];
$navigation_links = array_to_object($links);

@endphp

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                <img class="d-inline-block" width="32px" height="30.61px" src="{{ asset('globe.png') }}" alt="">
            </a>
        </div>
        @foreach ($navigation_links as $link)
        <ul class="sidebar-menu">
            {{-- <li class="menu-header">{{ $link->text }}</li> --}}
            @if (!$link->is_multi)
            <li class="{{ Request::routeIs($link->href) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route($link->href) }}"><i class="fas fa-{{ $link->icon }}"></i><span>{{ $link->text }}</span></a>
            </li>
            @else
            @foreach ($link->href as $section)
            @php $routes = collect($section->section_list)->map(function ($child) {
            return Request::routeIs($child->href);
            })->toArray();

            $is_active = in_array(true, $routes);
            @endphp

            <li class="dropdown {{ ($is_active) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-bar"></i> <span>{{ $section->section_text }}</span></a>
                <ul class="dropdown-menu">
                    @foreach ($section->section_list as $child)
                    <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}"><a class="nav-link" href="{{ route($child->href) }}">{{ $child->text }}</a></li>
                    @endforeach
                </ul>
            </li>
            @endforeach
            @endif
        </ul>
        @endforeach
    </aside>
</div>