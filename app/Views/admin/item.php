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
                    Item
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
            <table id="datatable_item" class="table table-hover table-striped nowrap" style="width: 100%;">
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>

<div id="modal_item" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <a type="button" class="close" href="javascript:$('#modal_item').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <form id="form_item_action" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="item_code">Kode Item (*)</label>
                        <input id="item_code" name="item_code" type="text" class="form-control" placeholder="Masukkan Kode Item..." required="">
                    </div>
                    <div class="form-group">
                        <label for="item_name">Nama Item (*)</label>
                        <input id="item_name" name="item_name" type="text" class="form-control" placeholder="Masukkan Nama Item..." required="">
                    </div>
                    <div class="form-group">
                        <label for="item_desc">Deskripsi Item</label>
                        <textarea id="item_desc" name="item_desc" class="form-control" rows="3" placeholder="Masukkan Deskripsi Item..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="item_group">Grup Item (*)</label>
                        <select id="item_group" name="item_group" class="form-control" required="">
                            <option value="">Pilih Grup Item...</option>
                            <?php foreach ($item_group_es as $item_group) : ?>
                                <option value=<?= $item_group['itemg_code'] ?>> <?= $item_group['itemg_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="item_type">Tipe Item (*)</label>
                        <select id="item_type" name="item_type" class="form-control" required="">
                            <option value="">Pilih Tipe Item...</option>
                            <option value="JL">Jual</option>
                            <option value="BL">Beli</option>
                            <option value="JB">Jual & Beli</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="item_measure">Satuan Item (*)</label>
                        <select id="item_measure" name="item_measure" class="form-control" required="">
                            <option value="">Pilih Satuan Item...</option>
                            <?php foreach ($measure_es as $measure) : ?>
                                <option value=<?= $measure['measure_code'] ?>> <?= $measure['measure_code'] . ' (' . $measure['measure_name'] . ')' ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="javascript:$('#modal_item').modal('hide')">Tutup</a>
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
        $("#menu-item").addClass("mm-active");
        $("#menu-item-ul").addClass("mm-show");
        $("#menu-item-ul-li").addClass("mm-active");
    })
</script>

<script>
    $(function() {
        var messageTop = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis deserunt laboriosam molestias vitae, ipsa nostrum, delectus obcaecati numquam ipsum ea, dolor rerum eos expedita placeat natus aperiam nam amet vero.";
        var fileName = "Item Data"
        $("#datatable_item").attr("data-export-title", fileName);

        var buttonCommon = {
            init: function(dt, node, config) {
                var table = dt.table().context[0].nTable;
                if (table) config.title = $(table).data('export-title')
            },
            title: 'default title'
        };

        var table = $("#datatable_item").DataTable({
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
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return "SQ Details [" + Object.values(data)[0] + "]";
                        }
                    }),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll()
                }
            },
            columnDefs: [{
                responsivePriority: 1,
                targets: [
                    -1,
                    -2,
                    -3,
                    -4,
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
                url: "<?= base_url("item/get_item/all") ?>",
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
                    title: "Kode Item",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.item_code ? data.item_code : "-");
                    },
                },
                {
                    mData: null,
                    title: "Nama Item",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.item_name ? data.item_name : "-");
                    },
                },
                {
                    mData: null,
                    title: "Deskripsi",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.item_desc ? data.item_desc : "-");
                    },
                },
                {
                    mData: null,
                    title: "Tipe Item",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.item_type ? data.item_type : "-");
                    },
                },
                {
                    mData: null,
                    title: "Grup Item",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.itemg_name ? data.itemg_name : "-");
                    },
                },
                {
                    mData: null,
                    title: "Stok",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.item_type == "JL" ? "-" : (data.item_stock ? `${data.item_stock} ${data.item_measure}` : "-"));
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
                            if (data.item_active == "Y") {
                                html += "<a id='active_action' href='' actv='N'><i class='fa fa-power-off' style='color:#1cc88a'></i></a>";
                            } else {
                                html += "<a id='active_action' href='' actv='Y'><i class='fa fa-power-off' style='color:#e74a3b'></i></a>";
                            }
                        } else {
                            if (data.item_active == "Y") {
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
                    title: "Gambar",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        html += "<button style='font-size: 10px;' class='btn btn-primary mr-2' id='popup_image' title='Popup Image' img='" + data.item_image + "'><i class='fa fa-image'></i></button>";
                        if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") {
                            html += "<button style='font-size: 10px;' class='btn btn-primary' id='edit_image' title='Edit Image'><i class='fa fa-cog'></i></button>";
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
                            html += "<button style='font-size: 10px;' class='btn btn-primary mr-2' id='edit_data' title='Edit Data'><i class='fa fa-edit'></i></button>";
                        }

                        return html;
                    },
                },
            ],
        });

        $("#datatable_item tbody").on("click", "#popup_image", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            Swal.fire({
                title: data["item_name"],
                imageUrl: "<?= base_url("_img/item") ?>" + "/" + $(this).attr("img"),
                imageHeight: "90%",
                imageAlt: data["item_name"],
                showConfirmButton: false,
            })
        });

        if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") {
            $("#datatable_item tbody").on("click", "#edit_data", function() {
                var current_row = $(this).parents("tr");
                if (current_row.hasClass("child")) {
                    current_row = current_row.prev();
                }
                var data = table.row(current_row).data();

                $("#item_code").val(data["item_code"]);
                $("#item_name").val(data["item_name"]);
                $("#item_desc").val(data["item_desc"]);
                $("#item_group").val(data["item_group"]);
                $("#item_type").val(data["item_type"]);
                $("#item_measure").val(data["item_measure"]);

                $("#form_item_action").attr("act", "edit");
                $(".modal-title").html("Edit Data Item");
                $("#item_code").prop("readonly", true);
                $("#item_measure").prop("disabled", true);

                $("#modal_item").modal("show");
            });

            $("#datatable_item tbody").on("click", "#active_action", function(e) {
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
                            url: "<?= base_url("item/update_active") ?>",
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
                            },
                            data: {
                                item_code: data["item_code"],
                                item_active: active,
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

                                        $("#datatable_item").DataTable().ajax.reload();
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

            $("#datatable_item tbody").on("click", "#edit_image", function() {
                (async () => {
                    var current_row = $(this).parents("tr");
                    if (current_row.hasClass("child")) {
                        current_row = current_row.prev();
                    }
                    var data = table.row(current_row).data();

                    var item_image = $(this).attr("img");

                    const {
                        value: file
                    } = await Swal.fire({
                        title: "Pilih Gambar Item",
                        input: "file",
                        inputAttributes: {
                            "accept": "image/*",
                            "aria-label": "Unggah gambar item..."
                        }
                    });

                    if (file) {
                        var formData = new FormData();
                        var item_image_new = $(".swal2-file")[0].files[0];
                        formData.append("item_code", data["item_code"]);
                        // formData.append("item_image", item_image);
                        formData.append("item_image", item_image_new);

                        $.ajax({
                            type: "POST",
                            url: "<?= base_url("item/update_item_image") ?>",
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

                                        $("#datatable_item").DataTable().ajax.reload();
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
                    }
                })();
            });
        }
    })
</script>

<script>
    if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") {
        $("#add_data").on("click", function(e) {
            e.preventDefault();

            $("#item_code").val("");
            $("#item_name").val("");
            $("#item_desc").val("");
            $("#item_group").val("ITMG-DEFAULT");
            $("#item_type").val("JL");
            $("#item_measure").val("");

            $("#form_item_action").attr("act", "add");
            $(".modal-title").html("Tambah Data Item");
            $("#item_code").prop("readonly", false);
            $("#item_measure").prop("disabled", false);

            $("#modal_item").modal("show");

            return false;
        })


        $("#form_item_action").submit(function(e) {
            e.preventDefault();

            var act = $("#form_item_action").attr("act");

            if (act == "add") {
                var url = "<?= base_url("item/insert_item") ?>";
            } else {
                var url = "<?= base_url("item/update_item") ?>";
            }

            var formData = new FormData(this);
            // formData.append("cus_active", "Y");

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

                            $("#datatable_item").DataTable().ajax.reload();
                            $("#modal_item").modal("hide");
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