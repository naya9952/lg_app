<?php
?>
<script>
function goMenu(actionURL) {
	var goMenu = document.getElementById('menuForm01');
	goMenu.action = actionURL;
	goMenu.submit();
}

</script>
<form name="menuForm01" id="menuForm01" method="post">
<input type="hidden" name="userID" id="userID" value="<?php echo($_REQUEST["userID"]);?>">
<input type="hidden" name="sessID" id="sessID" value="<?php echo($_REQUEST["sessID"]);?>">
<input type="hidden" name="ime" id="ime" value="">
</form>


    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="javascript:goMenu('index.php');">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">IoT Dashboard</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="javascript:goMenu('index.php');">
        <i class="fas fa-chart-pie"></i>
          <span>통합 대시보드</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        	모니터링 화면
      </div>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="javascript:goMenu('dashboardPC.php');">
        <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>전체 디바이스 현황</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="javascript:goMenu('statusChartPC2.php');">
          <i class="fas fa-fw fa-chart-line"></i>
          <span>개별 디바이스 상태</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="javascript:goMenu('imeEvent_all.php');">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>전체 디바이스 이벤트</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Admin 화면
      </div>


      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="javascript:goMenu('imeList.php');">
          <i class="fas fa-fw fa-table"></i>
          <span>디바이스 관리</span></a>
      </li>
      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="javascript:goMenu('userList.php');">
          <i class="fas fa-fw fa-users-cog"></i>
          <span>사용자 관리</span></a>
      </li>
      

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>