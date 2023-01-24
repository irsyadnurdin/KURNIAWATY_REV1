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
                    Data Penjualan
                    <div class="page-title-subheading">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur modi maiores error cum incidunt dolores itaque! Ex, ipsum officiis ratione nulla quam aut magnam fugiat deserunt, praesentium laboriosam quis perferendis!
                    </div>
                </div>
            </div>
            <?php if ($_SESSION['session_admin']['user_role'] == "cashier") : ?>
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
                                    <a href="<?= base_url("/" . $locale . "/admin/sq_add") ?>" class="nav-link">
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
            <table id="datatable_sq" class="table table-hover table-striped nowrap" style="width: 100%;">
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>

<div id="modal_sq" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <table id="datatable_sq_detail" class="table table-hover table-striped nowrap" style="width: 100%;">
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("javascript") ?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#menu-sq").addClass("mm-active");
        $("#menu-sq-ul").addClass("mm-show");
        $("#menu-sq-ul-li").addClass("mm-active");
    })
</script>

<script>
    var formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "IDR",
    });

    $(function() {
        var url = "<?= base_url("sq/get_sq") ?>";

        var messageTop = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis deserunt laboriosam molestias vitae, ipsa nostrum, delectus obcaecati numquam ipsum ea, dolor rerum eos expedita placeat natus aperiam nam amet vero.";
        var fileName = "Data Permintaan Pembelian"
        $("#datatable_sq").attr("data-export-title", fileName);

        var buttonCommon = {
            init: function(dt, node, config) {
                var table = dt.table().context[0].nTable;
                if (table) config.title = $(table).data('export-title')
            },
            title: 'default title'
        };

        var table = $("#datatable_sq").DataTable({
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
            // responsive: {
            //     details: {
            //         display: $.fn.dataTable.Responsive.display.modal({
            //             header: function(row) {
            //                 var data = row.data();
            //                 return "Permintaan Pembeliian [" + Object.values(data)[0] + "]";
            //             }
            //         }),
            //         renderer: $.fn.dataTable.Responsive.renderer.tableAll()
            //     }
            // },
            columnDefs: [{
                responsivePriority: 1,
                targets: [
                    -1,
                    -2,
                    -3,
                    -4,
                ],
            }],
            scrollX: true,
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
                    title: "Kode Penjualan",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sq_code ? data.sq_code : "-");
                    }
                },
                {
                    mData: null,
                    title: "Deskripsi",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sq_desc ? data.sq_desc : "-");
                    }
                },
                {
                    mData: null,
                    title: "Nama Kasir",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.user_full_name ? data.user_full_name : "-");
                    }
                },
                {
                    mData: null,
                    title: "Cash Status",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sq_cash_status ? (data.sq_cash_status == "Y" ? "Cash" : "Non Cash") : "-");
                    }
                },
                {
                    mData: null,
                    title: "Total",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sq_total ? formatter.format(data.sq_total) : "-");
                    }
                },
                {
                    mData: null,
                    title: "Add By",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sq_add_by ? data.sq_add_by : "-");
                    }
                },
                {
                    mData: null,
                    title: "Add Date",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sq_add_date ? data.sq_add_date : "-");
                    }
                },
                {
                    mData: null,
                    title: "Update By",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sq_upd_by ? data.sq_upd_by : "-");
                    }
                },
                {
                    mData: null,
                    title: "Update Date",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sq_upd_date ? data.sq_upd_date : "-");
                    }
                },
                {
                    mData: null,
                    title: "Detail",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        html += "<a href='<?= base_url("admin/sq_invoice") ?>/" + data.sq_code + "' target='_blank' style='font-size: 10px;' class='btn btn-primary mr-2'><i class='fa fa-print'></i></a>";
                        html += "<button style='font-size: 10px;' class='btn btn-primary' id='detail_sq' title='Detail Permintaan Pembelian'><i class='fa fa-eye'></i></button>";

                        return html;
                    }
                },
            ],
        });

        $("#datatable_sq tbody").on("click", "#detail_sq", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            (async () => {
                await $("#modal_sq").modal("show");

                // $("#datatable_sq_detail").DataTable().destroy();
                // $("#datatable_sq_detail").html("");

                await $("#datatable_sq_detail").DataTable({
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
                    // responsive: {
                    //     details: {
                    //         display: $.fn.dataTable.Responsive.display.modal({
                    //             header: function(row) {
                    //                 var data = row.data();
                    //                 return "Shift Details [" + Object.values(data)[0] + "]";
                    //             }
                    //         }),
                    //         renderer: $.fn.dataTable.Responsive.renderer.tableAll()
                    //     }
                    // },
                    columnDefs: [{
                        responsivePriority: 1,
                        targets: [
                            -1,
                        ],
                    }],
                    scrollX: true,
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
                        url: "<?= base_url("sq/get_sq_detail") ?>" + "/" + data["sq_code"],
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
                                return (data.sqd_item ? data.sqd_item : "-");
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
                            title: "Deskripsi",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.sqd_desc ? data.sqd_desc : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Kuantitas",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.sqd_qty ? `${Number(data.sqd_qty).toFixed(0)} ${data.item_measure}` : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Harga Satuan",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.sqd_price ? `${formatter.format(data.sqd_price)} / ${data.item_measure}` : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Total",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.sqd_total ? formatter.format(data.sqd_total) : "-");
                            }
                        },
                    ],
                });
            })()
        });
    })
</script>

<?= $this->endSection() ?>