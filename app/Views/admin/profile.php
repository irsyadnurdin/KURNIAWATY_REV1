<?= $this->extend("admin/layout/admin_layout") ?>

<?= $this->section("content") ?>

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-science icon-gradient bg-happy-itmeo"></i>
                </div>
                <div>
                    Profil Saya
                    <div class="page-title-subheading">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nam eligendi quae eius perspiciatis. Totam quo sunt dignissimos qui aspernatur doloribus dolorum molestiae excepturi aut, facere delectus necessitatibus maiores eos blanditiis?
                    </div>
                </div>
            </div>
            <div class="page-title-actions">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="card-shadow-primary profile-responsive card-border mb-3 card">
                <div class="dropdown-menu-header">
                    <div class="dropdown-menu-header-inner bg-focus">
                        <div class="menu-header-image opacity-3" style="background-image: url('<?= base_url("/temp_admin/assets/images/dropdown-header/city4.jpg") ?>');">
                        </div>
                        <div class="menu-header-content btn-pane-right">
                            <form method="post">
                                <div class="avatar-icon-wrapper mr-2 avatar-icon-xl">
                                    <label for="upload_image">
                                        <div class="avatar-icon rounded">
                                            <img src="<?= base_url("/_img/profile/" . $user_mstr["user_image"]) ?>" id="uploaded_image" class="img-responsive img-circle" />
                                        </div>
                                        <div class="overlay">
                                            <div class="text">Mengunggah</div>
                                        </div>
                                        <input id="upload_image" class="upload_image" name="upload_image" type="file" style="display:none" accept="image/*" />
                                    </label>
                                </div>
                            </form>

                            <div>
                                <h5 class="menu-header-title">
                                    <?php echo $user_mstr["user_full_name"]; ?>
                                </h5>
                                <h6 class="menu-header-subtitle">
                                    <?php echo $user_mstr["role_name"]; ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-12 col-lg-6 col-xl-8">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Pengaturan Akun Saya</h5>
                    <div class="mb-3 text-center">
                        <div role="group" class="btn-group-sm nav btn-group">
                            <a data-toggle="tab" href="#profile-setting" class="btn-shadow active btn btn-primary">
                                Pengaturan Profil
                            </a>
                            <a data-toggle="tab" href="#password-setting" class="btn-shadow  btn btn-primary">
                                Pengaturan Kata Sandi
                            </a>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile-setting" role="tabpanel">
                            <form id="edit_profile" class="col-12">
                                <div class="form-group">
                                    <label>User ID</label>
                                    <div>
                                        <input type="text" value="<?php echo $user_mstr["user_id"]; ?>" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user_name">Username (*)</label>
                                    <div>
                                        <input id="user_name" name="user_name" type="text" value="<?php echo $user_mstr["user_name"]; ?>" class="form-control" placeholder="Masukkan nama pengguna Anda..." required="" pattern="[a-zA-Z0-9_]{1,}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user_full_name">Nama Lengkap (*)</label>
                                    <div>
                                        <input id="user_full_name" name="user_full_name" type="text" value="<?php echo $user_mstr["user_full_name"]; ?>" class="form-control" placeholder="Masukkan nama lengkap Anda..." required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user_email">Email (*)</label>
                                    <div>
                                        <input id="user_email" name="user_email" type="email" value="<?php echo $user_mstr["user_email"]; ?>" class="form-control" placeholder="Masukkan email Anda..." required="">
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        Perbaharui
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="password-setting" role="tabpanel">
                            <form id="edit_password" class="col-12">
                                <div class="form-group">
                                    <label for="user_password_reset">Kata Sandi (*)</label>
                                    <div>
                                        <input id="user_password_reset" name="user_password_reset" class="form-control" type="password" placeholder="Masukkan kata sandi baru Anda..." required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Ulangi Kata Sandi (*)</label>
                                    <div>
                                        <input id="confirm_password" name="confirm_password" class="form-control" type="password" placeholder="Konfirmasi kata sandi baru Anda..." required>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        Simpan
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">

        </div>

    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>

<div id="modal_cropper" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div style="width: 100%; min-height: 50vh; max-height: 70vh;">
                    <img src="" id="sample_image" />
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-secondary" data-dismiss="modal" href="javascript:$('#modal_cropper').modal('hide')">Tutup</a>
                <button type="button" id="crop_image" class="btn btn-primary">Pangkas & Simpan perubahan</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("javascript") ?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#menu-profile").addClass("mm-active");
    })
</script>

<script>
    $(document).ready(function() {
        var $modal = $("#modal_cropper");
        var image = document.getElementById("sample_image");
        var cropper;

        $("#upload_image").change(function(event) {
            var files = event.target.files;

            var done = function(url) {
                image.src = url;
                $modal.modal("show");
            };

            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function(event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $modal.on("shown.bs.modal", function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                preview: ".preview",
                autoCropArea: 1
            });
        }).on("hidden.bs.modal", function() {
            cropper.destroy();
            cropper = null;
        });

        $("#crop_image").click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 500,
                height: 500
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url("user/update_user_image") ?>",
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
                        },
                        data: {
                            user_id: "<?= $user_mstr["user_id"] ?>",
                            user_image: base64data,
                        },
                        // processData: false,
                        // contentType: false,
                        // cache: false,
                        // async: false,
                        success: function(data) {
                            if (data.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: data.t_message,
                                    text: data.message,
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.assign("<?= current_url() ?>");
                                    }
                                })
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: data.t_message,
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Kesalahan tidak diketahui, halaman akan dimuat ulang!",
                            }).then((result) => {
                                if (result.value) {
                                    window.location.assign("<?= current_url() ?>");
                                }
                            })
                        }
                    });
                };
            });
        });
    });
</script>

<script type="text/javascript">
    $("#edit_profile").submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("user_id", "<?= $user_mstr["user_id"] ?>");

        $.ajax({
            type: "POST",
            url: "<?= base_url("user/update_user") ?>",
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
            },
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: data.t_message,
                        text: data.message,
                    }).then((result) => {
                        if (result.value) {
                            window.location.assign("<?= current_url() ?>");
                        }
                    })
                } else {
                    Swal.fire({
                        icon: "error",
                        title: data.t_message,
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            },
            error: function() {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Kesalahan tidak diketahui, halaman akan dimuat ulang!",
                }).then((result) => {
                    if (result.value) {
                        window.location.assign("<?= current_url() ?>");
                    }
                })
            }
        })

        return false;
    });

    $("#edit_password").submit(function(e) {
        e.preventDefault();

        var user_password_reset = $("#user_password_reset").val();
        var confirm_password = $("#confirm_password").val();

        if (user_password_reset == confirm_password) {
            var formData = new FormData(this);
            formData.append("user_id_reset", "<?= $user_mstr["user_id"] ?>");

            $.ajax({
                type: "POST",
                url: "<?= base_url("user/update_password") ?>",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
                },
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: data.t_message,
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        })

                        $("#user_password_reset").val("");
                        $("#confirm_password").val("");
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: data.t_message,
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Kesalahan tidak diketahui, halaman akan dimuat ulang!",
                    }).then((result) => {
                        if (result.value) {
                            window.location.assign("<?= current_url() ?>");
                        }
                    })
                }
            });
        } else {
            $("#confirm_password").val("");
            $("#confirm_password").focus();

            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Kata sandi yang Anda masukkan tidak sama!",
                showConfirmButton: false,
                timer: 2000
            })
        }

        return false;
    });
</script>

<?= $this->endSection() ?>