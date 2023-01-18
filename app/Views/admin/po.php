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
                    Pesanan Pembelian
                    <div class="page-title-subheading">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur modi maiores error cum incidunt dolores itaque! Ex, ipsum officiis ratione nulla quam aut magnam fugiat deserunt, praesentium laboriosam quis perferendis!
                    </div>
                </div>
            </div>
            <!-- ADDITIONAL BUTTON -->
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <table id="datatable_po" class="table table-hover table-striped nowrap" style="width: 100%;">
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>

<div id="modal_po" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <table id="datatable_po_detail" class="table table-hover table-striped nowrap" style="width: 100%;">
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("javascript") ?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#menu-po").addClass("mm-active");
        $("#menu-po-ul").addClass("mm-show");
        $("#menu-po-ul-li").addClass("mm-active");
    })
</script>

<script>
    var formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "IDR",
    });

    $(function() {
        var url = "<?= base_url("po/get_po") ?>";

        var messageTop = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis deserunt laboriosam molestias vitae, ipsa nostrum, delectus obcaecati numquam ipsum ea, dolor rerum eos expedita placeat natus aperiam nam amet vero.";
        var fileName = "Data Pesanan Pembelian"
        $("#datatable_po").attr("data-export-title", fileName);

        var buttonCommon = {
            init: function(dt, node, config) {
                var table = dt.table().context[0].nTable;
                if (table) config.title = $(table).data('export-title')
            },
            title: 'default title'
        };

        var table = $("#datatable_po").DataTable({
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
            //                 return "Pesanan Pembelian [" + Object.values(data)[0] + "]";
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
                    title: "Kode Pesanan Pembelian",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.po_code ? data.po_code : "-");
                    }
                },
                {
                    mData: null,
                    title: "Kode Permintaan Pembelian",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.po_pr ? data.po_pr : "-");
                    }
                },
                {
                    mData: null,
                    title: "Nama PO",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.po_name ? data.po_name : "-");
                    }
                },
                {
                    mData: null,
                    title: "Deskripsi",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.po_desc ? data.po_desc : "-");
                    }
                },
                {
                    mData: null,
                    title: "Pemasok",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.sup_name ? data.sup_name : "-");
                    }
                },
                {
                    mData: null,
                    title: "Total",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.po_total ? formatter.format(data.po_total) : "-");
                    }
                },
                {
                    mData: null,
                    title: "Add By",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.po_add_by ? data.po_add_by : "-");
                    }
                },
                {
                    mData: null,
                    title: "Add Date",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.po_add_date ? data.po_add_date : "-");
                    }
                },
                {
                    mData: null,
                    title: "Update By",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.po_upd_by ? data.po_upd_by : "-");
                    }
                },
                {
                    mData: null,
                    title: "Update Date",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.po_upd_date ? data.po_upd_date : "-");
                    }
                },
                {
                    mData: null,
                    title: "Status",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        if (data.po_status == "P") {
                            html += "<i class='fa fa-spinner' style='color:#1cc88a' data-bs-toggle='tooltip' data-bs-html='true' title='Sedang Dalam Proses'></i>";
                        } else if (data.po_status == "F") {
                            html += "<i class='fa fa-check' style='color:#1cc88a'></i>";
                        } else {
                            html += "-";
                        }

                        return html;
                    },
                },
                {
                    mData: null,
                    title: "Konfirmasi Diterima",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        if (("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") && (data.po_status == "P")) {
                            html += "<a id='confirm_po' href=''><i class='fa fa-cog' style='color:#1cc88a'></i></a>";
                        } else {
                            html += "-";
                        }

                        return html;
                    },
                },
                {
                    mData: null,
                    title: "Detail",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        html += "<a href='<?= base_url("admin/po_invoice") ?>/" + data.po_code + "' target='_blank' style='font-size: 10px;' class='btn btn-primary mr-2'><i class='fa fa-print'></i></a>";
                        html += "<button style='font-size: 10px;' class='btn btn-primary' id='detail_po' title='Detail Pesanan Pembelian'><i class='fa fa-eye'></i></button>";

                        return html;
                    }
                },
            ],
        });

        $("#datatable_po tbody").on("click", "#detail_po", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            (async () => {
                await $("#modal_po").modal("show");

                // $("#datatable_po_detail").DataTable().destroy();
                // $("#datatable_po_detail").html("");

                await $("#datatable_po_detail").DataTable({
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
                        url: "<?= base_url("po/get_po_detail") ?>" + "/" + data["po_code"],
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
                                return (data.pod_item ? data.pod_item : "-");
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
                                return (data.pod_desc ? data.pod_desc : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Kuantitas",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.pod_qty ? `${Number(data.pod_qty).toFixed(0)} ${data.item_measure}` : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Harga Satuan",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.pod_price ? `${formatter.format(data.pod_price)} / ${data.item_measure}` : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Total",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.pod_total ? formatter.format(data.pod_total) : "-");
                            }
                        },
                    ],
                });
            })()
        });

        if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") {
            $("#datatable_po tbody").on("click", "#confirm_po", function(e) {
                e.preventDefault();

                var current_row = $(this).parents("tr");
                if (current_row.hasClass("child")) {
                    current_row = current_row.prev();
                }
                var data = table.row(current_row).data();

                Swal.fire({
                    title: "Konfirmasi Pesanan Pembelian Diterima?",
                    // text: "Apakah Kamu Yakin?",
                    icon: "warning",
                    // showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Setujui!',
                    // denyButtonText: 'Deny!',
                }).then((result) => {
                    (async () => {
                        if (result.isConfirmed) {
                            Update_Status(data["po_code"], "F")
                        }
                        // else if (result.isDenied) {
                        //     (async () => {
                        //         Swal.fire('Changes are not saved', '', 'info')
                        //         const {
                        //             value: reason
                        //         } = await Swal.fire({
                        //             title: 'Approve Description!',
                        //             input: 'textarea',
                        //             inputPlaceholder: 'Enter your approve description...',
                        //             showCancelButton: true,
                        //             inputValidator: (value) => {
                        //                 if (!value) {
                        //                     return 'You need to write something!'
                        //                 }
                        //             }
                        //         })

                        //         if (reason) {
                        //             Update_Approve(data["pr_code"], "N", reason, "N")
                        //         }
                        //     })()
                        // }
                    })()
                });
            });
        }
    })

    function Update_Status(po_code, po_status) {
        $.ajax({
            type: "POST",
            url: "<?= base_url("po/confirm_po") ?>",
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
            },
            data: {
                po_code: po_code,
                po_status: po_status,
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

                        $("#datatable_po").DataTable().ajax.reload();
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
</script>

<?= $this->endSection() ?>