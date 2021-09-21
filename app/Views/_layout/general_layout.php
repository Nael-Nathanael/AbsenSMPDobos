<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "SMP Don Bosco Manado - SIABSEN" ?></title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("/assets/css/bootstrap.css") ?>">

    <link rel="stylesheet" href="<?= base_url("/assets/vendors/iconly/bold.css") ?>">

    <link rel="stylesheet" href="<?= base_url("/assets/vendors/perfect-scrollbar/perfect-scrollbar.css") ?>">

    <link rel="stylesheet" href="<?= base_url("/assets/vendors/bootstrap-icons/bootstrap-icons.css") ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
          integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="<?= base_url("/assets/css/app.css") ?>">
    <?= $this->renderSection('styles') ?>
    <link rel="shortcut icon" href="<?= base_url("/assets/images/favicon.svg") ?>" type="image/x-icon">

    <style>
        .card-title {
            margin-bottom: 0;
        }

        .fa {
            margin-right: 0.25em;
        }

        .form-helper {
            line-height: 1.2;
        }
    </style>
</head>

<body>
<div id="app">
    <!-- Sidebar -->
    <?= $this->include('_layout/sidebar') ?>
    <!-- End Sidebar -->

    <!-- Main -->
    <div id="main">
        <header class="mb-3 d-flex justify-content-xl-end justify-content-between">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
            <a href="<?= route_to("auth.logout") ?>" class="btn btn-outline-danger">
                <i class="fa fa-power-off"></i> Log out
            </a>
        </header>

        <!-- Content -->
        <?= $this->renderSection('content') ?>
        <!-- End Content -->

        <!-- Footer -->
        <?= $this->include('_layout/footer') ?>
        <!-- End Footer -->
    </div>
    <!-- End Main -->
</div>

<script src="<?= base_url("/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js") ?>"></script>
<script src="<?= base_url("/assets/js/bootstrap.bundle.min.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?= $this->renderSection('javascript') ?>

<script src="<?= base_url("/assets/js/main.js") ?>"></script>

<?php if (session()->getFlashdata("success") !== null): ?>
    <script>
        Swal.fire("Berhasil", "<?= session()->getFlashdata("success")?>", "success");
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata("error") !== null): ?>
    <script>
        Swal.fire("Gagal", "<?= session()->getFlashdata("error")?>", "error");
    </script>
<?php endif; ?>

<script>
    async function postData(url = '', data = {}) {
        const response = await fetch(url, {
            method: 'POST',
            body: data
        });
        return response.json(); // parses JSON response into native JavaScript objects
    }
</script>


</body>
</html>
