<div class="page-sidebar-wrapper">
  <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
  <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
  <div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
      <li class="start" id="page_home">
        <a href="{{ url('data') }}">
        <i class="icon-home"></i>
        <span class="title">Data</span>
        <span id='selpage_home'></span>
        </a>
      </li>
      {{-- <li id="page_laporan">
        <a href="#">
        <i class="icon-share-alt"></i>
        <span class="title">Laporan</span>
        <span id='selpage_laporan'></span>
        <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
          @if(in_array(Session::get('level'),[1,2,88]) or Session::get('organisasi[2]')!=null)
          <li id='page_laporanpengukuranlingkerja'>
            <a href="{{ url('/pengukuranlingkerja') }}">PLK - Pengukuran</a>
          </li>
          @endif
          @if(in_array(Session::get('level'),[1,2]) or Session::get('organisasi[1]')!=null)
          <li id='page_laporanpengukuranchart'>
            <a href="{{ url('/pengukuranchart/0000/0000/0000') }}">PLK - Dashboard</a>
          </li>
          @endif
          @if(in_array(Session::get('level'),[1,2]) or Session::get('organisasi[1]')!=null)
          <li><hr></li>
          <li id='page_laporaninspeksistok'>
            <a href="{{ url('/inspeksip3k/') }}">P3K - Inspeksi Kotak</a>
          </li>
          @endif
          @if(in_array(Session::get('level'),[1,2]))
          <li id='page_laporanstok'>
            <a href="{{ url('/datastokp3k') }}">P3K - Data Stok</a>
          </li>
          <!-- <li id='page_laporanbroadcastp3k'>
            <a href="{{ url('/broadcastp3k') }}">P3K - Email Broadcast</a>
          </li> -->
          @endif
        </ul>
      </li>
      @if(in_array(Session::get('level'),[1,2]))
      <li id="page_setting">
        <a href="#">
        <i class="icon-settings"></i>
        <span class="title">Setting</span>
        <span id='selpage_setting'></span>
        <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
          <li id='page_settinguserplk'>
            <a href="{{ url('/userplk') }}">PLK - User</a>
          </li>
          <li id='page_settinglokasiukur'>
            <a href="{{ url('/organisasiplk') }}">PLK - Lokasi Pengukuran</a>
          </li>
          <li id='page_settingjenisukur'>
            <a href="{{ url('/jenispengukuran') }}">PLK - Jenis Pengukuran</a>
          </li>
          <li id='page_settingnab'>
            <a href="{{ url('/nab') }}">PLK - Nilai Ambang Batas</a>
          </li>
          <li class="divider"><hr></li>
          <li id='page_settinguserp3k'>
            <a href="{{ url('/userp3k') }}">P3K - User</a>
          </li>
          <li id='page_settinglokasikotak'>
            <a href="{{ url('/organisasip3k') }}">P3K - Lokasi Kotak</a>
          </li>
          <li id='page_settingisikotak'>
            <a href="{{ url('/p3k') }}">P3K - Isi Kotak</a>
          </li>
          <li class="divider"><hr></li>
          <li id='page_settinguseradmin'>
            <a href="{{ url('/useradmin') }}">Admin - User</a>
          </li>
        </ul>
      </li> --}}
      {{-- @endif --}}
    </ul>
    <!-- END SIDEBAR MENU -->
  </div>
</div>
