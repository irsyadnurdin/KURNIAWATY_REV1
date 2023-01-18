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
                    Satuan Item
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
            <table id="datatable_measure" class="table table-hover table-striped nowrap" style="width: 100%;">
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>

<div id="modal_measure" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <a type="button" class="close" href="javascript:$('#modal_measure').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <form id="form_measure_action" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="measure_code">Kode Satuan Item (*)</label>
                        <input id="measure_code" name="measure_code" type="text" class="form-control" placeholder="Masukkan Kode Satuan Item..." required="">
                    </div>
                    <div class="form-group">
                        <label for="measure_name">Nama Satuan Item (*)</label>
                        <input id="measure_name" name="measure_name" type="text" class="form-control" placeholder="Masukkan Nama Satuan Item..." required="">
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="javascript:$('#modal_measure').modal('hide')">Tutup</a>
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
        $("#menu-item").addClass("mm-active");
        $("#menu-item-ul").addClass("mm-show");
        $("#menu-measure-ul-li").addClass("mm-active");
    })
</script>

<script>
    $(function() {
        var messageTop = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis deserunt laboriosam molestias vitae, ipsa nostrum, delectus obcaecati numquam ipsum ea, dolor rerum eos expedita placeat natus aperiam nam amet vero.";
        var fileName = "Data Satuan Item"
        $("#datatable_item").attr("data-export-title", fileName);

        var buttonCommon = {
            init: function(dt, node, config) {
                var table = dt.table().context[0].nTable;
                if (table) config.title = $(table).data('export-title')
            },
            title: 'default title'
        };

        var table = $("#datatable_measure").DataTable({
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
                url: "<?= base_url("measure/get_measure") ?>",
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
                    title: "Kode Satuan Item",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.measure_code ? data.measure_code : "-");
                    },
                },
                {
                    mData: null,
                    title: "Nama Satuan Item",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.measure_name ? data.measure_name : "-");
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
            $("#datatable_measure tbody").on("click", "#edit_data", function() {
                var current_row = $(this).parents("tr");
                if (current_row.hasClass("child")) {
                    current_row = current_row.prev();
                }
                var data = table.row(current_row).data();

                $("#measure_code").val(data["measure_code"]);
                $("#measure_name").val(data["measure_name"]);
                $("#form_measure_action").attr("act", "edit");
                $(".modal-title").html("Edit Data Satuan Item");
                $("#measure_code").prop("readonly", true);

                $("#modal_measure").modal("show");
            });
        }
    })
</script>

<script>
    if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") {
        $("#add_data").on("click", function(e) {
            e.preventDefault();

            $("#measure_code").val("");
            $("#measure_name").val("");
            $("#form_measure_action").attr("act", "add");
            $(".modal-title").html("Tambah Data Satuan Item");
            $("#measure_code").prop("readonly", false);

            $("#modal_measure").modal("show");

            return false;
        })

        $("#form_measure_action").submit(function(e) {
            e.preventDefault();

            var act = $("#form_measure_action").attr("act");

            if (act == "add") {
                var url = "<?= base_url("measure/insert_measure") ?>";
            } else {
                var url = "<?= base_url("measure/update_measure") ?>";
            }

            var formData = new FormData(this);

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

                            $("#datatable_measure").DataTable().ajax.reload();
                            $("#modal_measure").modal("hide");
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