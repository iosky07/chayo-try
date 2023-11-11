@php
    $links = [
        [
            "href" => "admin.dashboard",
            "text" => "Dashboard",
            "is_multi" => false,
        ],
        [
            "href" => [
                [
                    "section_text" => "User",
                    "section_icon" => "fa fa-users",
                    "section_list" => [
                        ["href" => "admin.user", "text" => "Data User"],
                        ["href" => "admin.user.new", "text" => "Buat User"]
                    ]
                ],
                [
                    "section_text" => "Billing",
                    "section_icon" => "fa fa-file",
                    "section_list" => [
                        ["href" => "admin.blog.index", "text" => "Data Billing"],
                        ["href" => "admin.blog.create", "text" => "Buat Billing"]
                    ]
                ],
                [
                    "section_text" => "Keuangan",
                    "section_icon" => "fa fa-file",
                    "section_list" => [
                        ["href" => "admin.regulation.index", "text" => "Data Keuangan"],
                        ["href" => "admin.regulation.create", "text" => "Buat Keuangan"]
                    ]
                ],

            ],
            "text" => "Manajemen Website",
            "is_multi" => true,
        ],
    ];
    $navigation_links = json_decode(json_encode($links), FALSE);
@endphp

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">
                <img class="d-inline-block" width="32px" height="30.61px" src="" alt="">
            </a>
        </div>
{{--        {{ $navigation_links }}--}}
        @foreach ($navigation_links as $link)
{{--            {{ $link }}--}}
        <ul class="sidebar-menu">
            <li class="menu-header">{{ $link->text }}</li>
            @if (!$link->is_multi)
            <li class="{{ Request::routeIs($link->href) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route($link->href) }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @else
                @foreach ($link->href as $section)
                    @php
                    $routes = collect($section->section_list)->map(function ($child) {
                        return Request::routeIs($child->href);
                    })->toArray();

                    $is_active = in_array(true, $routes);
                    @endphp

                    <li class="dropdown {{ ($is_active) ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-bar"></i> <span>{{ $section->section_text }}</span></a>
                        <ul class="dropdown-menu">
                            @foreach ($section->section_list as $child)
                                <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}"><a class="nav-link" href="#">{{ $child->text }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endif
        </ul>
        @endforeach
    </aside>
</div>
