<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img style="border-radius: 20%;" width="40" src="images/loho.png" alt="">
        </div>
        <div class="sidebar-brand-text mx-3"><span class="text-success">KU</span> activity notifications</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">หน้าการจัดการ</div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">

        <a class="nav-link collapsed " href="msEvent.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>จัดการกิจกรรม</span>
        </a>
    </li>
    <li class="nav-item">

        <a class="nav-link collapsed " href="msLocaion.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>จัดการสถานที่</span>
        </a>
    </li>
    <li class="nav-item">

        <a class="nav-link collapsed " href="msRoom.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>จัดการห้อง</span>
        </a>
    </li>
    <li class="nav-item">

        <a class="nav-link collapsed " href="msPersonel.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>จัดการบุคลากร</span>
        </a>
    </li>
    <li class="nav-item">

        <a class="nav-link collapsed " href="msFaculty.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>จัดการหน่วยงานหลัก</span>
        </a>
    </li>
    <li class="nav-item">

        <a class="nav-link collapsed " href="msBranch.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>จัดการหน่วยงานย่อย</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle  border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
</ul>
<!-- End of Sidebar -->
<script>
    const navs = document.querySelectorAll("a.nav-link");
    navs.forEach((nav) => {
        //ถ้า deploy แล้วต้องมาลบ /project-fn/ ออก
        if ("/project-fn/" + nav.attributes[1].value == location.pathname) {
            nav.parentElement.classList.add("active");
        } else {
            if (location.pathname === "/project-fn/addEvent.php" || location.pathname === "/project-fn/editEvent.php") {
                if (nav.attributes[1].value == 'msEvent.php') {
                    nav.parentElement.classList.add("active");
                }
            } else {
                nav.parentElement.classList.remove("active");
            }
        }
    })
</script>