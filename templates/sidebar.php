<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img src="<?php echo $user['foto']; ?>" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">MHC EVENT</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">


                <!-- Profile Anggota -->
                <li class="nav-item">
                    <a href="./dashboard.php" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <!-- Profile Anggota -->
                <li class="nav-item">
                    <a href="./profile.php" class="nav-link">
                        <i class="nav-icon bi bi-person"></i>
                        <p>
                            Profile Anggota
                        </p>
                    </a>
                </li>

                <!-- Pemain -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-person-bounding-box"></i>
                        <p>
                            Pemain
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="players.php" class="nav-link">
                                <i class="nav-icon bi bi-person-check"></i>
                                <p>Semua Pemain</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Kompetisi -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-trophy"></i>
                        <p>
                            Kompetisi
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- <li class="nav-item">
                            <a href="./tim-kompetisi.html" class="nav-link">
                                <i class="nav-icon bi bi-person-circle"></i>
                                <p>Tim</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./pemain-kompetisi.html" class="nav-link">
                                <i class="nav-icon bi bi-person-plus"></i>
                                <p>Pemain</p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="./official.php" class="nav-link">
                                <i class="nav-icon bi bi-person-fill"></i>
                                <p>Officials</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./pertandingan-kompetisi.html" class="nav-link">
                                <i class="nav-icon bi bi-calendar-check"></i>
                                <p>Pertandingan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Galery -->
                <li class="nav-item">
                    <a href="./galery.html" class="nav-link">
                        <i class="nav-icon bi bi-image"></i>
                        <p>Galery</p>
                    </a>
                </li>

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
