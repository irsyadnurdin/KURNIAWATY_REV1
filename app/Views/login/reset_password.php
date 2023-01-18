<?= $this->extend('login/layout/login_layout') ?>

<?= $this->section('content') ?>

<div class="app-container app-theme-white body-tabs-shadow">
    <div class="app-container">
        <div class="h-100">
            <div class="h-100 no-gutters row">
                <div class="d-none d-lg-block col-lg-4">
                    <?= $this->include('login/layout/slider') ?>
                </div>
                <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                    <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                        <div class="app-logo"></div>
                        <h4>
                            <div>Reset ulang password!</div>
                            <span>Gunakan formulir di bawah ini untuk memulihkannya.</span>
                        </h4>
                        <div>
                            <form class="reset_password">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="password" class="">Buat Kata Sandi Baru</label>
                                            <input id="password" name="password" class="form-control" type="password" placeholder="Masukkan kata sandi baru Anda..." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="re_password" class="">Konfirmasi password Anda</label>
                                            <input id="re_password" name="re_password" class="form-control" type="password" placeholder="Konfirmasi kata sandi baru Anda..." required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 d-flex align-items-center">
                                    <h6 class="mb-0">
                                        <a href="<?php echo base_url('login') ?>" class="text-primary">
                                            Masuk ke akun yang ada
                                        </a>
                                    </h6>
                                    <div class="ml-auto">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            Reset Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('javascript') ?>

<script>
    $('.reset_password').submit(function(e) {
        e.preventDefault();

        var password = $('#password').val();
        var re_password = $('#re_password').val();

        if (password == re_password) {
            var formData = new FormData(this);
            formData.append('user_id', "<?= $user['user_id'] ?>");

            $.ajax({
                type: 'POST',
                url: '<?= base_url('login/auth_reset_password') ?>',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: data.t_message,
                            text: data.message,
                        }).then((result) => {
                            if (result.value) {
                                window.location.assign('<?= base_url('login') ?>');
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: data.t_message,
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Kesalahan tidak diketahui, halaman akan dimuat ulang!',
                    }).then((result) => {
                        if (result.value) {
                            window.location.assign('<?= base_url('login/reset_password/' . $user['user_token']) ?>');
                        }
                    })
                }
            });
        } else {
            $('#re_password').val("");
            $('#re_password').focus();

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Kata sandi yang Anda masukkan tidak sama!',
                showConfirmButton: false,
                timer: 2000
            })
        }

        return false;
    });
</script>

<?= $this->endSection() ?>