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
                    Pemasok
                    <div class="page-title-subheading">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur modi maiores error cum incidunt dolores itaque! Ex, ipsum officiis ratione nulla quam aut magnam fugiat deserunt, praesentium laboriosam quis perferendis!
                    </div>
                </div>
            </div>
            <?php if ($_SESSION['session_admin']['user_role'] == "warehouse") : ?>
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
                                        <span> Tambah Data</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <table id="datatable_suplier" class="table table-hover table-striped nowrap" style="width: 100%;">
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>

<div id="modal_suplier" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <a type="button" class="close" href="javascript:$('#modal_suplier').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <form id="form_suplier_action" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sup_code">Kode Pemasok (*)</label>
                        <input id="sup_code" name="sup_code" type="text" class="form-control" placeholder="Masukkan Kode Pemasok..." required="">
                    </div>
                    <div class="form-group">
                        <label for="sup_name">Nama Pemasok (*)</label>
                        <input id="sup_name" name="sup_name" type="text" class="form-control" placeholder="Masukkan Nama Pemasok..." required="">
                    </div>
                    <div class="form-group">
                        <label for="sup_desc">Deskripsi</label>
                        <textarea id="sup_desc" name="sup_desc" class="form-control" rows="3" placeholder="Masukkan Deskripsi..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="sup_address">Alamat Pemasok (*)</label>
                        <textarea id="sup_address" name="sup_address" class="form-control" rows="3" placeholder="Masukkan Alamat Pemasok..." required=""></textarea>
                    </div>
                    <div class="form-group">
                        <label for="sup_phone">Nomor Telepon Pemasok (*)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    +62
                                </div>
                            </div>
                            <input id="sup_phone" name="sup_phone" type="text" class="form-control" placeholder="Masukkan Nomor Telepon Pemasok..." required="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="javascript:$('#modal_suplier').modal('hide')">Tutup</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("javascript") ?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#menu-suplier").addClass("mm-active");
    })
</script>

<script>
    $(function() {
        var messageTop = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis deserunt laboriosam molestias vitae, ipsa nostrum, delectus obcaecati numquam ipsum ea, dolor rerum eos expedita placeat natus aperiam nam amet vero.";
        var fileName = "Data Pemasok"
        $("#datatable_item").attr("data-export-title", fileName);

        var buttonCommon = {
            init: function(dt, node, config) {
                var table = dt.table().context[0].nTable;
                if (table) config.title = $(table).data('export-title')
            },
            title: 'default title'
        };

        var table = $("#datatable_suplier").DataTable({
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
                url: "<?= base_url("suplier/get_suplier/all") ?>",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
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
                    title: "Kode Pemasok",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sup_code ? data.sup_code : "-");
                    },
                },
                {
                    mData: null,
                    title: "Nama Pemasok",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sup_name ? data.sup_name : "-");
                    },
                },
                {
                    mData: null,
                    title: "Deskripsi",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sup_desc ? data.sup_desc : "-");
                    },
                },
                {
                    mData: null,
                    title: "Alamat",
                    render: function(data, row, type, meta) {
                        return (data.sup_address ? data.sup_address : "-");
                    },
                },
                {
                    mData: null,
                    title: "Nomor Telepon",
                    render: function(data, row, type, meta) {
                        return (data.sup_phone ? "+62" + data.sup_phone : "-");
                    },
                },
                {
                    mData: null,
                    title: "Status Aktif",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") {
                            if (data.sup_active == "Y") {
                                html += "<a id='active_action' href='' actv='N'><i class='fa fa-power-off' style='color:#1cc88a'></i></a>";
                            } else {
                                html += "<a id='active_action' href='' actv='Y'><i class='fa fa-power-off' style='color:#e74a3b'></i></a>";
                            }
                        } else {
                            if (data.sup_active == "Y") {
                                html += "<i class='fa fa-check' style='color:#1cc88a'></i>";
                            } else {
                                html += "<i class='fa fa-close' style='color:#e74a3b'></i>";
                            }
                        }

                        return html;
                    },
                },
                {
                    mData: null,
                    title: "Aksi",
                    sortable: false,
                    sClass: "center-datatable",
                    bVisible: ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse" ? true : false),
                    render: function(data, row, type, meta) {
                        let html = "";

                        if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") {
                            html += "<button style='font-size: 10px;' class='btn btn-primary' id='edit_data' title='Edit Data'><i class='fa fa-edit'></i></button>";
                        }

                        return html;
                    }
                }
            ],
        });


        if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") {
            $("#datatable_suplier tbody").on("click", "#edit_data", function() {
                var current_row = $(this).parents("tr");
                if (current_row.hasClass("child")) {
                    current_row = current_row.prev();
                }
                var data = table.row(current_row).data();

                $("#sup_code").val(data["sup_code"]);
                $("#sup_name").val(data["sup_name"]);
                $("#sup_desc").val(data["sup_desc"]);
                $("#sup_address").val(data["sup_address"]);
                $("#sup_phone").val(data["sup_phone"]);
                $("#form_suplier_action").attr("act", "edit");
                $(".modal-title").html("Edit Data Pemasok");
                $("#sup_code").prop("readonly", true);

                $("#modal_suplier").modal("show");
            });


            $("#datatable_suplier tbody").on("click", "#active_action", function(e) {
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
                            url: "<?= base_url("suplier/update_suplier") ?>",
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
                            },
                            data: {
                                sup_code: data["sup_code"],
                                sup_name: data["sup_name"],
                                sup_desc: data["sup_desc"],
                                sup_address: data["sup_address"],
                                sup_phone: data["sup_phone"],
                                sup_active: active,
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

                                        $("#datatable_suplier").DataTable().ajax.reload();
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
        }
    })
</script>

<script>
    if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") {
        $("#add_data").on("click", function(e) {
            e.preventDefault();

            $("#sup_code").val("");
            $("#sup_name").val("");
            $("#sup_desc").val("");
            $("#sup_address").val("");
            $("#sup_phone").val("");
            $("#form_suplier_action").attr("act", "add");
            $(".modal-title").html("Tambah Data Pemasok");
            $("#sup_code").prop("readonly", false);

            $("#modal_suplier").modal("show");

            return false;
        })

        $("#form_suplier_action").submit(function(e) {
            e.preventDefault();

            var act = $("#form_suplier_action").attr("act");

            if (act == "add") {
                var url = "<?= base_url("suplier/insert_suplier") ?>";
            } else {
                var url = "<?= base_url("suplier/update_suplier") ?>";
            }

            var formData = new FormData(this);
            formData.append("sup_active", "Y");

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

                            $("#datatable_suplier").DataTable().ajax.reload();
                            $("#modal_suplier").modal("hide");
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
    }
</script>

<?= $this->endSection() ?>