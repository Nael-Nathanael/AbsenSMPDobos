<?php
$uri = service('uri')->getSegments();
$uri0 = $uri[0] ?? '';
$uri1 = $uri[1] ?? '';
$uri2 = $uri[2] ?? '';
$uri3 = $uri[3] ?? '';

?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="<?= base_url() ?>">
                        SI-ABSEN
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <?php if (isAdmin()): ?>
                    <li class="sidebar-item <?= ($uri0 == 'admin' && $uri1 == '') ? 'active' : '' ?> ">
                        <a href="<?= route_to("admin.panel") ?>" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>
                            Daftar Kelas
                        </span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= ($uri0 == 'admin' && $uri1 == 'tanggal') ? 'active' : '' ?> ">
                        <a href="<?= route_to("admin.panel.tanggal") ?>" class='sidebar-link'>
                            <i class="bi bi-calendar"></i>
                            <span>
                            Daftar Tanggal Absen
                        </span>
                        </a>
                    </li>
                <?php elseif (isGuru()): ?>
                    <li class="sidebar-item <?= ($uri0 == 'guru' && $uri1 == '') ? 'active' : '' ?> ">
                        <a href="<?= route_to("guru.panel") ?>" class='sidebar-link'>
                            <i class="bi bi-calendar"></i>
                            <span>
                            Panel Absen
                        </span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= ($uri0 == 'guru' && $uri1 == 'ringkasan') ? 'active' : '' ?> ">
                        <a href="<?= route_to("guru.panel.ringkasan") ?>" class='sidebar-link'>
                            <i class="bi bi-files"></i>
                            <span>
                            Ringkasan Absen
                        </span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
