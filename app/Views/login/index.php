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
						<h4 class="mb-0">
							<span class="d-block">Selamat Datang,</span>
							<span>Silakan masuk ke akun Anda!</span>
						</h4>
						<!-- <h6 class="mt-3">
							No account?
							<a href="javascript:void(0);" class="text-primary">
								Sign up now
							</a>
						</h6> -->
						<div class="divider row"></div>
						<form class="login">
							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="user_name" class="">Username</label>
										<input id="user_name" name="user_name" class="form-control" type="text" placeholder="Masukkan nama pengguna Anda..." value="<?= (isset($_SESSION['session_remember_me']) ? $_SESSION['session_remember_me']['user_name'] : "") ?>" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="user_password" class="">Password</label>
										<input id="user_password" name="user_password" class="form-control" type="password" placeholder="Masukkan kata sandi pengguna Anda..." value="<?= (isset($_SESSION['session_remember_me']) ? $_SESSION['session_remember_me']['user_password'] : "") ?>" required>
									</div>
								</div>
							</div>
							<div class="position-relative form-check">
								<input id="remember_me" name="remember_me" type="checkbox" class="form-check-input" <?= (isset($_SESSION['session_remember_me']) ? "checked" : "") ?>>
								<label for="remember_me" class="form-check-label">Ingat Saya?</label>
							</div>
							<div class="divider row"></div>
							<div class="d-flex align-items-center">
								<div class="ml-auto">
									<a href="<?php echo base_url('login/lupa_password') ?>" class="btn-lg btn btn-link">
										Lupa Password?</a>
									<button type="submit" value="submit" class="btn btn-primary btn-lg">
										Login ke Dashboard
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

<?= $this->endSection() ?>


<?= $this->section('javascript') ?>

<script>
	$('.login').submit(function(e) {
		e.preventDefault();

		var formData = new FormData(this);

		$.ajax({
			type: 'POST',
			url: '<?= base_url('login/auth') ?>',
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
						showConfirmButton: false,
						timer: 2000
					})

					window.location.assign('<?= base_url('administrator') ?>');
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
						window.location.assign('<?= base_url('login') ?>');
					}
				})
			}
		});

		return false;
	});
</script>

<?= $this->endSection() ?>