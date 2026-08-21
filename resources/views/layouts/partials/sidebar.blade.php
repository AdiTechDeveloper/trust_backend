<aside class="sidebar" id="sidebar">

    {{-- Logo Section --}}
    <div class="logo_image">
        <img src="{{ asset('assets/admin/images/logo.png') }}" alt="Temple Trust" onerror="this.style.display='none'">
        {{-- <span class="logo-text">Temple Trust</span> --}}
    </div>

    <div class="sidebar-menu">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="bi bi-people"></i> <span>Member</span>
                </a>
            </li>

             <li class="nav-item">
                <a href="{{ route('admin.pooja.index') }}" class="nav-link">
                    <i class="bi bi-flower1"></i> <span>Pooja</span>
                </a>
            </li>

              <li class="nav-item">
                <a href="{{ route('admin.video.index') }}" class="nav-link">
                    <i class="bi bi-camera-video"></i> <span>Video</span>
                </a>
            </li>

             <li class="nav-item">
                <a href="{{ route('admin.puja-booking.index') }}" class="nav-link">
                    <i class="bi bi-calendar-check"></i> <span>Puja Bookings</span>
                </a>
            </li>

                <li class="nav-item">
                <a href="{{ route('admin.gallery.index') }}" class="nav-link">
                    <i class="bi bi-images"></i> <span>Gallery</span>
                </a>
            </li>


            {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-person-badge"></i> <span>Temple Members</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-file-earmark-text"></i> <span>Membership Applications</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-cash-coin"></i> <span>Donations</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-tags"></i> <span>Donation Categories</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-calendar-check"></i> <span>Puja Booking</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-calendar-event"></i> <span>Events</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-images"></i> <span>Gallery</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-newspaper"></i> <span>News</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-chat-quote"></i> <span>Testimonials</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-file-earmark"></i> <span>Pages</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-images"></i> <span>Sliders</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-bell"></i> <span>Notifications</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <span class="sidebar-heading">Administration</span>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-person-gear"></i> <span>Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-shield-lock"></i> <span>Roles & Permissions</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-gear"></i> <span>Settings</span>
                </a>
            </li> --}}

        </ul>
    </div>

</aside>