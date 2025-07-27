<div class="sidebar-menu">
  <ul class="menu">
    <li class="sidebar-title">Menu</li>
    <li class="sidebar-item {{ request()->is('dashboard', 'dashboard/*') ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->is('jurusan', 'jurusan/*') ? 'active' : '' }} ">
      <a href="{{ route('jurusan.index') }}" class='sidebar-link'>
        <i class="fas fa-graduation-cap"></i>
        <span>Jurusan</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->is('kelas', 'kelas/*') ? 'active' : '' }} ">
      <a href="{{ route('kelas.index') }}" class='sidebar-link'>
        <i class="fas fa-school"></i>
        <span>Kelas</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->is('kandidat', 'kandidat/*') ? 'active' : '' }} ">
      <a href="{{ route('kandidat.index') }}" class='sidebar-link'>
        <i class="fas fa-users"></i>
        <span>Kandidat</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->is('pemilih', 'pemilih/*') ? 'active' : '' }} ">
      <a href="{{ route('pemilih.index') }}" class='sidebar-link'>
        <i class="fas fa-user"></i>
        <span>Pemilih</span>
      </a>
    </li>
    <li class="sidebar-title">Setting</li>
    <li class="sidebar-item {{ request()->is('hasil') ? 'active' : '' }} ">
      <a href="{{ route('hasil') }}" class='sidebar-link'>
        <i class="fas fa-chart-bar"></i>
        <span>Hasil</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->is('user', 'user/*') ? 'active' : '' }} ">
      <a href="{{ route('user.index') }}" class='sidebar-link'>
        <i class="fas fa-id-badge"></i>
        <span>User</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->is('configs') ? 'active' : '' }} ">
      <a href="{{ route('config.index') }}" class='sidebar-link'>
        <i class="fas fa-cogs"></i>
        <span>Konfigurasi</span>
      </a>
    </li>
  </ul>
</div>
