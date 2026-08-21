<header class="topbar">

    <div class="topbar-left">
        {{-- Sidebar toggle button (mobile/tablet ke liye) --}}
        <button class="btn-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>

        {{-- Search Box --}}
        {{-- <div class="topbar-search d-none d-md-block">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search anything...">
        </div> --}}
    </div>

    <div class="topbar-right">

        {{-- Dark/Light Mode Toggle --}}
        <button class="btn-icon" id="themeToggle" title="Toggle Theme">
            <i class="bi bi-moon-stars" id="themeIcon"></i>
        </button>

        {{-- Notification Bell --}}
        <div class="dropdown">
            <button class="btn-icon position-relative" data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <span class="notif-badge">3</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end notif-dropdown">
                <li class="dropdown-header">Notifications</li>
                <li><a class="dropdown-item" href="#">🎂 2 Birthdays today</a></li>
                <li><a class="dropdown-item" href="#">💰 New donation received</a></li>
                <li><a class="dropdown-item" href="#">📋 New membership application</a></li>
            </ul>
        </div>

        {{-- Admin Profile Dropdown --}}
        <div class="dropdown">
            <!-- Inside your topbar/navbar section -->
            <button class="profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if (auth()->check() && auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                        class="profile-img rounded-circle" alt="Profile" width="35" height="35"
                        style="object-fit: cover;">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ auth()->check() ? urlencode(auth()->user()->name) : 'Admin' }}&background=D4A017&color=fff"
                        class="profile-img rounded-circle" alt="Profile" width="35" height="35">
                @endif
                <span class="d-none d-md-inline ms-1">{{ auth()->check() ? auth()->user()->name : 'Admin' }}</span>
            </button>

            {{-- <button class="profile-btn" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?name={{ auth()->check() ? auth()->user()->name : 'Admin' }}&background=D4A017&color=fff"
                    class="profile-img" alt="Profile">
                <span class="d-none d-md-inline">{{ auth()->check() ? auth()->user()->name : 'Admin' }}</span>
                <i class="bi bi-chevron-down"></i>
            </button> --}}
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ url('admin/profile/edit') }}"><i
                            class="bi bi-person me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="{{ url('admin/password/edit') }}"><i class="bi bi-key me-2"></i>Change Password</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>

</header>
