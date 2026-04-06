<button class="sidebar-toggle" onclick="toggleSidebar()" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Enhanced Sidebar Navigation -->
    <div class="sidebar">
        <button class="sidebar-close-btn" onclick="document.querySelector('.sidebar').classList.remove('active')" " name="sidebarCloseBtn">
            <i class="fas fa-times"></i>
        </button>
        <!-- User Profile Section -->
        <div class="user-profile">
            <img src="https://ui-avatars.com/api/?name=Admin&background=007bff&color=fff" alt="User" class="user-avatar">
            <div class="user-info">
                <span class="user-name">Admin</span>
                <span class="user-role">Administrator</span>
            </div>
        </div>

    <!-- Menu Items -->
        <ul class="sidebar-menu">
            <li>
               <a href="{{ secure_url("tikets") }}" class="{{ request()->routeIs('tikets.index') ? 'active' : '' }}" style="margin-right: 6px">
            <i class="fas fa-ticket-alt"></i> Manajemen Tiket
        </a>
            </li>
            <li>
            <a href="{{ route('validasi') }}" class="{{ request()->routeIs('validasi') ? 'active' : '' }}">
                <i class="fas fa-check-circle"></i> Validasi Tiket
            </a>
        </li>







            <li class="divider"></li>



           <li>
                <form id="logout-form" action="{{ secure_url('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
           </li>
        </ul>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            v1.0.0 &copy; 2023
        </div>
    </div>
