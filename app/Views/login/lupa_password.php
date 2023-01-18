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
                            <div>Lupa kata sandi Anda?</div>
                            <span>Gunakan formulir di bawah ini untuk memulihkannya.</span>
                        </h4>
                        <div>
                            <form class="lupa_password">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="user_name" class="">Username</label>
                                            <input id="user_name" name="user_name" class="form-control" type="text" placeholder="Masukkan nama pengguna Anda..." required>
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
                                            Pulihkan Kata Sandi
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
    $('.lupa_password').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '<?= base_url('login/auth_lupa_password') ?>',
            data: new FormData(this),
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
                        showConfirmButton: false,
                        timer: 2000
                    })

                    $('#user_branch_code').val("");
                    $('#user_name').val("");
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
                        window.location.assign('<?= base_url('login/lupa_password') ?>');
                    }
                })
            }
        });

        return false;
    });
</script>

<?= $this->endSection() ?>