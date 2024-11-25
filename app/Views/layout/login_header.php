<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login') ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/custom.css'); ?>">
    <link rel="icon" href="<?= base_url('assets/images/avi2.png'); ?>" type="image/png">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</head>

<body class="hold-transition login-page" style="background-color: #ffffff;">
<div class="login-box">
        <div class="login-logo">
            <img src="<?= base_url('assets/images/AVI.png'); ?>" alt="AVI Logo" style="max-width: 70%; margin-bottom: 10px;">
        </div>
        <div class="card bg-white login-card-body">
            <p class="login-box-msg"><strong>Sign In</strong></p>

            <form action="<?= site_url('loginMe') ?>" method="post" autocomplete="off">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Username" name="name" required autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" id="currentPassword" name="password" required autocomplete="new-password">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-default" id="toggleNewPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>

            <p class="mb-1">
                <a href="<?= base_url('register') ?>">Register</a>
            </p>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <script>
            swal({
                title: "Login Failed",
                text: "<?= session()->getFlashdata('error') ?>",
                icon: "error",
                button: "OK",
            });
        </script>
    <?php endif; ?>

    <!-- jQuery -->
    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleNewPassword = document.getElementById('toggleNewPassword');
            const newPasswordInput = document.getElementById('currentPassword');

            toggleNewPassword.addEventListener('click', function () {
                if (newPasswordInput.type === 'password') {
                    newPasswordInput.type = 'text';
                    toggleNewPassword.querySelector('i').classList.remove('fa-eye');
                    toggleNewPassword.querySelector('i').classList.add('fa-eye-slash');
                } else {
                    newPasswordInput.type = 'password';
                    toggleNewPassword.querySelector('i').classList.remove('fa-eye-slash');
                    toggleNewPassword.querySelector('i').classList.add('fa-eye');
                }
            });

            // SweetAlert for error messages
            <?php if (session()->getFlashdata('error')): ?>
                swal("Login Failed", "<?= session()->getFlashdata('error') ?>", "error");
            <?php endif; ?>
        });
    </script>

    <style>
        .btn-primary {
            background-color: #0069aa;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #025f99;
            color: #fff;
        }
    </style>
</body>

</html>
