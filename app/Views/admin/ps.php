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
                    Struktur Produk
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
                                    <a href="<?= base_url("/" . $locale . "/admin/ps_add") ?>" class="nav-link">
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
            <table id="datatable_ps" class="table table-hover table-striped nowrap" style="width: 100%;">
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>

<div id="modal_ps" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <table id="datatable_ps_detail" class="table table-hover table-striped nowrap" style="width: 100%;">
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("javascript") ?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#menu-ps").addClass("mm-active");
        $("#menu-ps-ul").addClass("mm-show");
        $("#menu-ps-ul-li").addClass("mm-active");
    })
</script>

<script>
    var formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "IDR",
    });

    $(function() {
        var url = "<?= base_url("ps/get_ps") ?>";

        var messageTop = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis deserunt laboriosam molestias vitae, ipsa nostrum, delectus obcaecati numquam ipsum ea, dolor rerum eos expedita placeat natus aperiam nam amet vero.";
        var fileName = "Data Struktur Produk"
        $("#datatable_ps").attr("data-export-title", fileName);

        var buttonCommon = {
            init: function(dt, node, config) {
                var table = dt.table().context[0].nTable;
                if (table) config.title = $(table).data('export-title')
            },
            title: 'default title'
        };

        var table = $("#datatable_ps").DataTable({
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
                            return "Struktur Produk [" + Object.values(data)[0] + "]";
                        }
                    }),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll()
                }
            },
            columnDefs: [{
                responsivePriority: 1,
                targets: [
                    -1,
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
                url: url,
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
                    }
                },
                {
                    mData: null,
                    title: "Kode Item",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.item_code ? data.item_code : "-");
                    }
                },
                {
                    mData: null,
                    title: "Nama Item",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.item_name ? data.item_name : "-");
                    }
                },
                {
                    mData: null,
                    title: "Detail",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        html += "<button style='font-size: 10px;' class='btn btn-primary mr-2' id='detail_ps' title='Detail Product Structure'><i class='fa fa-eye'></i></button>";

                        if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") {
                            html += "<button style='font-size: 10px;' class='btn btn-primary' id='delete_data' title='Delete Data'><i class='fa fa-trash'></i></button>";
                        }

                        return html;
                    }
                },
            ],
        });

        $("#datatable_ps tbody").on("click", "#detail_ps", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            (async () => {
                await $("#modal_ps").modal("show");

                // $("#datatable_ps_detail").DataTable().destroy();
                // $("#datatable_ps_detail").html("");

                await $("#datatable_ps_detail").DataTable({
                    destroy: true,
                    keys: true,
                    autoFill: true,
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
                                    return "Shift Details [" + Object.values(data)[0] + "]";
                                }
                            }),
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll()
                        }
                    },
                    columnDefs: [{
                        responsivePriority: 1,
                        targets: [
                            -1,
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
                    }, ],
                    // processing: true,
                    // serverSide: true,
                    // serverMethod: "POST",
                    ajax: {
                        url: "<?= base_url("ps/get_ps_detail") ?>" + "/" + data["ps_item"],
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
                            }
                        },
                        {
                            mData: null,
                            title: "Kode Item",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.ps_child_item ? data.ps_child_item : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Nama Item",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.item_name ? data.item_name : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Kuantitas",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.ps_qty ? `${Number(data.ps_qty).toFixed(0)} ${data.item_measure}` : "-");
                            }
                        },
                    ],
                });
            })()
        });

        $("#datatable_ps tbody").on("click", "#delete_data", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            // $("#ps_uuid").val();
            // alert(data["item_code"])

            Swal.fire({
                title: 'Hapus Data!',
                text: "Apakah Kamu Yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url("ps/delete_ps") ?>',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
                        },
                        data: {
                            ps_item: data["item_code"],
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

                                    $("#datatable_ps").DataTable().ajax.reload();
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
                                    text: "Unknown error, the page will reload!",
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

<?= $this->endSection() ?>