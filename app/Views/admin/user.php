<?= $this->extend("admin/layout/admin_layout") ?>

<?= $this->section("content") ?>

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-config icon-gradient bg-tempting-azure"></i>
                </div>
                <div>
                    Data <?= $title ?>
                    <div class="page-title-subheading">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur modi maiores error cum incidunt dolores itaque! Ex, ipsum officiis ratione nulla quam aut magnam fugiat deserunt, praesentium laboriosam quis perferendis!
                    </div>
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fa fa-business-time fa-w-20"></i>
                        </span>
                        Pilihan Menu
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a id="add_data" class="nav-link">
                                    <i class="nav-link-icon lnr-plus-circle"></i>
                                    <span>Tambah Data <?= $title ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <table id="datatable_user" class="table table-hover table-striped nowrap" style="width: 100%;">
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>

<div id="modal_user" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <a type="button" class="close" href="javascript:$('#modal_user').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <form id="form_user_action" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_id">User ID <?= $title ?> (*)</label>
                        <input id="user_id" name="user_id" type="text" class="form-control" placeholder="Masukkan User ID <?= $title ?>..." required="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                    <div class="form-group">
                        <label for="user_name">Username <?= $title ?> (*)</label>
                        <input id="user_name" name="user_name" type="text" class="form-control" placeholder="Masukkan Username <?= $title ?>..." required="">
                    </div>
                    <div class="form-group">
                        <label for="user_full_name">Nama Lengkap <?= $title ?> (*)</label>
                        <input id="user_full_name" name="user_full_name" type="text" class="form-control" placeholder="Masukkan Nama Lengkap <?= $title ?>..." required="">
                    </div>
                    <div class="form-group" id="form_user_password">
                        <label for="user_password">Password (*)</label>
                        <input id="user_password" name="user_password" type="password" class="form-control" placeholder="Masukkan Password..." required="">
                    </div>
                    <div class="form-group">
                        <label for="user_email">Email <?= $title ?> (*)</label>
                        <input id="user_email" name="user_email" class="form-control input-mask-trigger" data-inputmask="'alias: 'email'" im-insert="true" placeholder="Masukkan Email <?= $title ?>..." pattern="[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*" required="">
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="javascript:$('#modal_user').modal('hide')">Tutup</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal_reset" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Password</h5>
                <a type="button" class="close" href="javascript:$('#modal_reset').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <form id="form_reset_action" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_id_reset">User ID (*)</label>
                        <input id="user_id_reset" name="user_id_reset" type="text" class="form-control" placeholder="Masukkan User ID <?= $title ?>..." required="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" disabled>
                    </div>
                    <div class="form-group">
                        <label for="user_password_reset">Password Baru (*)</label>
                        <input id="user_password_reset" name="user_password_reset" type="password" class="form-control" placeholder="Masukkan Password Baru..." required="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Ulangi Password (*)</label>
                        <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Masukkan Kembali Password Baru..." required="" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="javascript:$('#modal_reset').modal('hide')">Tutup</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("javascript") ?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#menu-user").addClass("mm-active");
        $("#menu-user-ul").addClass("mm-show");
        $("#menu-" + "<?= str_replace("_", "", $role) ?>" + "-ul-li").addClass("mm-active");
    })
</script>

<script>
    $(function() {
        var messageTop = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis deserunt laboriosam molestias vitae, ipsa nostrum, delectus obcaecati numquam ipsum ea, dolor rerum eos expedita placeat natus aperiam nam amet vero.";
        var fileName = "Data <?= $title ?>"
        $("#datatable_item").attr("data-export-title", fileName);

        var buttonCommon = {
            init: function(dt, node, config) {
                var table = dt.table().context[0].nTable;
                if (table) config.title = $(table).data('export-title')
            },
            title: 'default title'
        };

        var table = $("#datatable_user").DataTable({
            // keys: true,
            autoFill: true,
            select: {
                style: "single"
            },
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: true,
            pageLength: 20,
            colReorder: true,
            // fixedColumns: {
            //     left: 2
            // },
            order: [
                [0, "asc"]
            ],
            responsive: true,
            columnDefs: [{
                responsivePriority: 1,
                targets: [
                    -1,
                    -2,
                    -3,
                ],
            }],
            // scrollX: true,
            // scrollY: 400,
            // scrollCollapse: true,
            // scroller      : true, 
            dom: "Blfrtip",
            buttons: [{
                extend: "searchBuilder",
                text: "Filter Data",
                config: {
                    depthLimit: 2
                }
            }, {
                extend: "colvis",
                text: "Column Visibility",
                collectionLayout: "fixed two-column",
                postfixButtons: ["colvisRestore"]
            }, {
                // extend: "csv",
                text: "Export",
                split: [
                    "copy",
                    $.extend(true, {}, buttonCommon, {
                        extend: "pdfHtml5",
                        messageTop: messageTop,
                        exportOptions: {
                            columns: ':visible'
                        },
                        orientation: 'landscape',
                        pageSize: 'A4',
                    }),
                    {
                        extend: "excelHtml5",
                        title: fileName,
                        messageTop: messageTop,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    $.extend(true, {}, buttonCommon, {
                        extend: "print",
                        title: '',
                        header: false,
                        messageTop: messageTop,
                        exportOptions: {
                            columns: ":visible"
                        },
                        autoPrint: false
                    }),
                    {
                        text: "JSON",
                        action: function(e, dt, button, config) {
                            var data = dt.buttons.exportData();

                            $.fn.dataTable.fileSave(
                                new Blob([JSON.stringify(data)]),
                                fileName + ".json"
                            );
                        }
                    }
                ],
            }, ],
            // processing: true,
            // serverSide: true,
            // serverMethod: "POST",
            ajax: {
                type: "POST",
                url: "<?= base_url("user/get_user") ?>",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
                },
                data: {
                    user_role: "<?= $role ?>",
                },
                dataSrc: function(json) {
                    if (json != null) {
                        return json.data
                    } else {
                        return "";
                    }
                }
            },
            // sAjaxDataProp: "",
            aoColumns: [{
                    mData: null,
                    title: "No",
                    sClass: "center-datatable",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    mData: null,
                    title: "User ID",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.user_id ? data.user_id : "-");
                    },
                },
                {
                    mData: null,
                    title: "Username",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.user_name ? data.user_name : "-");
                    },
                },
                {
                    mData: null,
                    title: "Nama Lengkap",
                    render: function(data, row, type, meta) {
                        return (data.user_full_name ? data.user_full_name : "-");
                    },
                },
                {
                    mData: null,
                    title: "Email",
                    render: function(data, row, type, meta) {
                        return (data.user_email ? data.user_email : "-");
                    },
                },
                {
                    mData: null,
                    title: "Role",
                    render: function(data, row, type, meta) {
                        return (data.role_name ? data.role_name : "-");
                    },
                },
                {
                    mData: null,
                    title: "Last Login",
                    render: function(data, row, type, meta) {
                        return (data.user_last_login ? data.user_last_login : "-");
                    },
                },
                {
                    mData: null,
                    title: "Image",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        html += "<button style='font-size: 10px;' class='btn btn-primary mr-2' id='popup_image' title='Popup Image' img='" + data.user_image + "'><i class='fa fa-image'></i></button>";

                        return html;
                    },
                },
                {
                    mData: null,
                    title: "Active",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        if (data.user_active == "Y") {
                            html += "<a id='active_action' href='' actv='N'><i class='fa fa-power-off' style='color:#1cc88a'></i></a>";
                        } else {
                            html += "<a id='active_action' href='' actv='Y'><i class='fa fa-power-off' style='color:#e74a3b'></i></a>";
                        }

                        return html;
                    },
                },
                {
                    mData: null,
                    title: "Action",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        html += "<button style='font-size: 10px;' class='btn btn-primary mr-2' id='edit_data' title='Edit Data'><i class='fa fa-edit'></i></button>";
                        html += "<button style='font-size: 10px;' class='btn btn-primary' id='reset_password' title='Reset Password'><i class='fa fa-lock'></i></button>";

                        return html;
                    }
                }
            ],
        });

        new $.fn.dataTable.FixedHeader(table);

        $("#datatable_user tbody").on("click", "#popup_image", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            Swal.fire({
                title: data["user_full_name"],
                imageUrl: "<?= base_url("_img/profile") ?>" + "/" + $(this).attr("img"),
                imageHeight: "90%",
                imageAlt: data["user_full_name"],
                showConfirmButton: false,
            })
        });

        $("#datatable_user tbody").on("click", "#edit_data", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            $("#user_id").val(data["user_id"]);
            $("#user_name").val(data["user_name"]);
            $("#user_full_name").val(data["user_full_name"]);
            $("#user_email").val(data["user_email"]);
            $("#form_user_action").attr("act", "edit");
            $(".modal-title").html("Edit Data <?= $title ?>");
            $("#user_id").prop("readonly", true);
            $("#form_user_password").hide();
            $("#user_password").prop("disabled", true);

            $("#modal_user").modal("show");
        });

        $("#datatable_user tbody").on("click", "#reset_password", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            $("#user_id_reset").val(data["user_id"]);
            $("#user_id_reset").prop("readonly", true);

            $("#modal_reset").modal("show");
        });

        $("#datatable_user tbody").on("click", "#active_action", function(e) {
            e.preventDefault();

            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            var active = $(this).attr("actv");

            Swal.fire({
                title: (active == "Y" ? "Aktifkan Data!" : "Nonaktifkan Data!"),
                text: "Apakah Kamu Yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, " + (active == "Y" ? "Aktifkan Data" : "Nonaktifkan Data") + "!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url("user/update_user_active") ?>",
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
                        },
                        data: {
                            user_id: data["user_id"],
                            user_active: active,
                        },
                        success: function(data) {
                            if (data.success) {
                                (async () => {
                                    await Swal.fire({
                                        icon: "success",
                                        title: data.t_message,
                                        text: data.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    })

                                    $("#datatable_user").DataTable().ajax.reload();
                                })()
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
                            (async () => {
                                await Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Kesalahan tidak diketahui, halaman akan dimuat ulang!",
                                    showConfirmButton: false,
                                    timer: 2000
                                })

                                window.location.assign("<?= current_url() ?>");
                            })()
                        }
                    });
                }
            });
        });
    })
</script>

<script>
    $("#add_data").on("click", function(e) {
        e.preventDefault();

        $("#user_id").val("");
        $("#user_name").val("");
        $("#user_full_name").val("");
        $("#user_password").val("");
        $("#user_email").val("");
        $("#form_user_action").attr("act", "add");
        $(".modal-title").html("Tambah Data <?= $title ?>");
        $("#user_id").prop("readonly", false);
        $("#form_user_password").show();
        $("#user_password").prop("disabled", false);

        $("#modal_user").modal("show");

        return false;
    })

    $("#form_user_action").submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var act = $("#form_user_action").attr("act");

        if (act == "add") {
            formData.append("user_role", "<?= $role ?>");

            var url = "<?= base_url("user/insert_user") ?>";
        } else {
            var url = "<?= base_url("user/update_user") ?>";
        }

        $.ajax({
            type: "POST",
            url: url,
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
                    (async () => {
                        await Swal.fire({
                            icon: "success",
                            title: data.t_message,
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        })

                        $("#datatable_user").DataTable().ajax.reload();
                        $("#modal_user").modal("hide");
                    })()
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
                (async () => {
                    await Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Kesalahan tidak diketahui, halaman akan dimuat ulang!",
                        showConfirmButton: false,
                        timer: 2000
                    })

                    window.location.assign("<?= current_url() ?>");
                })()
            }
        })

        return false;
    });

    $("#form_reset_action").submit(function(e) {
        e.preventDefault();

        var user_password = $("#user_password_reset").val();
        var confirm_password = $("#confirm_password").val();

        if (user_password == confirm_password) {
            $.ajax({
                type: "POST",
                url: "<?= base_url("user/update_password") ?>",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
                },
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function(data) {
                    if (data.success) {
                        (async () => {
                            await Swal.fire({
                                icon: "success",
                                title: data.t_message,
                                text: data.message,
                                showConfirmButton: false,
                                timer: 2000
                            })

                            $("#datatable_user").DataTable().ajax.reload();
                            $("#modal_reset").modal("hide");
                            $("#user_password_reset").val("");
                            $("#confirm_password").val("");
                        })()
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
                    (async () => {
                        await Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Kesalahan tidak diketahui, halaman akan dimuat ulang!",
                            showConfirmButton: false,
                            timer: 2000
                        })

                        window.location.assign("<?= current_url() ?>");
                    })()
                }
            });
        } else {
            (async () => {
                await Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Password Yang Anda Masukkan Tidak Sama!",
                    showConfirmButton: false,
                    timer: 2000
                })

                $("#confirm_password").val("");
                $("#confirm_password").focus();
            })()
        }

        return false;
    });
</script>

<?= $this->endSection() ?>