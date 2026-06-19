<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'SMK ABC Library' }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    @livewireStyles
</head>
<body>
    <div class="app-shell">
        <div class="sidebar">
            <div class="sidebar-brand">
                <div class="mark">&#10086;</div>
                <div>
                    <div class="name">SMK ABC Library</div>
                    <div class="sub">{{ auth()->user()->isAdmin() ? 'Staff Console' : 'Student Portal' }}</div>
                </div>
            </div>

            <div class="nav-section">
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="icon">&#9632;</span><span>Dashboard</span>
                    </a>
                    <a href="{{ route('catalog.index') }}" class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}">
                        <span class="icon">&#9633;</span><span>Catalog</span>
                    </a>
                    <a href="{{ route('admin.checkouts') }}" class="nav-link {{ request()->routeIs('admin.checkouts') ? 'active' : '' }}">
                        <span class="icon">&#8635;</span><span>Active Checkouts</span>
                    </a>
                    <a href="{{ route('admin.holds') }}" class="nav-link {{ request()->routeIs('admin.holds') ? 'active' : '' }}">
                        <span class="icon">&#9873;</span><span>Holds Queue</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                        <span class="icon">&#8801;</span><span>Reports</span>
                    </a>
                    <a href="{{ route('admin.books.add') }}" class="nav-link {{ request()->routeIs('admin.books.add') ? 'active' : '' }}">
                        <span class="icon">+</span><span>Add Book</span>
                    </a>
                @else
                    <a href="{{ route('catalog.index') }}" class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}">
                        <span class="icon">&#9633;</span><span>Browse Catalog</span>
                    </a>
                    <a href="{{ route('my-books') }}" class="nav-link {{ request()->routeIs('my-books') ? 'active' : '' }}">
                        <span class="icon">&#9495;</span><span>My Books</span>
                    </a>
                    <a href="{{ route('my-holds') }}" class="nav-link {{ request()->routeIs('my-holds') ? 'active' : '' }}">
                        <span class="icon">&#9873;</span><span>My Holds</span>
                    </a>
                @endif
            </div>

            <div class="sidebar-footer">
                <div class="user-chip">
                    <div class="user-avatar">{{ auth()->user()->initials() }}</div>
                    <div class="user-meta">
                        <div class="uname">{{ auth()->user()->full_name }}</div>
                        <div class="urole">{{ auth()->user()->role }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-link-muted">Sign out</button>
                </form>
            </div>
        </div>

        <div class="main">
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>
