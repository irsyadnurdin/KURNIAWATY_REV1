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
                    Permintaan Pembelian
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
                                    <a href="<?= base_url("/" . $locale . "/admin/pr_add") ?>" class="nav-link">
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
            <table id="datatable_pr" class="table table-hover table-striped nowrap" style="width: 100%;">
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>

<div id="modal_pr" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <table id="datatable_pr_detail" class="table table-hover table-striped nowrap" style="width: 100%;">
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("javascript") ?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#menu-pr").addClass("mm-active");
        $("#menu-pr-ul").addClass("mm-show");
        $("#menu-pr-ul-li").addClass("mm-active");
    })
</script>

<script>
    var formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "IDR",
    });

    $(function() {
        var url = "<?= base_url("pr/get_pr") ?>";

        var messageTop = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis deserunt laboriosam molestias vitae, ipsa nostrum, delectus obcaecati numquam ipsum ea, dolor rerum eos expedita placeat natus aperiam nam amet vero.";
        var fileName = "Data Permintaan Pembelian"
        $("#datatable_pr").attr("data-export-title", fileName);

        var buttonCommon = {
            init: function(dt, node, config) {
                var table = dt.table().context[0].nTable;
                if (table) config.title = $(table).data('export-title')
            },
            title: 'default title'
        };

        var table = $("#datatable_pr").DataTable({
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
                    title: "Kode PR",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.pr_code ? data.pr_code : "-");
                    }
                },
                {
                    mData: null,
                    title: "Nama PR",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.pr_name ? data.pr_name : "-");
                    }
                },
                {
                    mData: null,
                    title: "Deskripsi",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.pr_desc ? data.pr_desc : "-");
                    }
                },
                {
                    mData: null,
                    title: "Nama Pemasok",
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
                        return (data.pr_total ? formatter.format(data.pr_total) : "-");
                    }
                },
                {
                    mData: null,
                    title: "Add By",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.pr_add_by ? data.pr_add_by : "-");
                    }
                },
                {
                    mData: null,
                    title: "Add Date",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.pr_add_date ? data.pr_add_date : "-");
                    }
                },
                {
                    mData: null,
                    title: "Update By",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.pr_upd_by ? data.pr_upd_by : "-");
                    }
                },
                {
                    mData: null,
                    title: "Update Date",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.pr_upd_date ? data.pr_upd_date : "-");
                    }
                },
                {
                    mData: null,
                    title: "Persetujuan",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        if (("<?= $_SESSION['session_admin']['user_role'] ?>" == "owner") && (data.pr_approve == "P")) {
                            html += "<a id='approve_pr' href=''><i class='fa fa-cog' style='color:#1cc88a'></i></a>";
                        } else {
                            if (data.pr_approve == "P") {
                                html += "<i class='fa fa-spinner' style='color:#1cc88a'></i>";
                            } else if (data.pr_approve == "Y") {
                                html += "<i class='fa fa-check' style='color:#1cc88a'></i>";
                            } else {
                                html += "<i class='fa fa-times' style='color:#e74a3b'></i>";
                            }
                        }

                        return html;
                    },
                },
                {
                    mData: null,
                    title: "Catatan",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.pr_approve_desc ? data.pr_approve_desc : "-");
                    }
                },
                {
                    mData: null,
                    title: "Buat PO",
                    sClass: "center-datatable",
                    bVisible: ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse" ? true : false),
                    render: function(data, row, type, meta) {
                        let html = "";
                        // return (data.pr_approve_desc ? data.pr_approve_desc : "-");
                        if (data.pr_create_po == "Y") {
                            html += "<a href='<?= base_url("/" . $locale . "/admin/po_add") ?>" + "/" + data.pr_code + "'><i class='fa fa-plus' style='color:#1cc88a'></i></a>";
                        } else if (data.pr_create_po == "F") {
                            html += "<i class='fa fa-check' style='color:#1cc88a'></i>";
                        } else if (data.pr_create_po == "N") {
                            html += "<i class='fa fa-times' style='color:#e74a3b'></i>";
                        }

                        return html;
                    }
                },
                {
                    mData: null,
                    title: "Detail",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        html += "<button style='font-size: 10px;' class='btn btn-primary' id='detail_pr' title='Detail Permintaan Pembelian'><i class='fa fa-eye'></i></button>";

                        return html;
                    }
                },
            ],
        });

        $("#datatable_pr tbody").on("click", "#detail_pr", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            (async () => {
                await $("#modal_pr").modal("show");

                // $("#datatable_pr_detail").DataTable().destroy();
                // $("#datatable_pr_detail").html("");

                await $("#datatable_pr_detail").DataTable({
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
                        url: "<?= base_url("pr/get_pr_detail") ?>" + "/" + data["pr_code"],
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
                                return (data.prd_item ? data.prd_item : "-");
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
                                return (data.prd_desc ? data.prd_desc : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Kuantitas",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.prd_qty ? `${Number(data.prd_qty).toFixed(0)} ${data.item_measure}` : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Harga Satuan",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.prd_price ? `${formatter.format(data.prd_price)} / ${data.item_measure}` : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Total",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.prd_total ? formatter.format(data.prd_total) : "-");
                            }
                        },
                    ],
                });
            })()
        });

        if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "owner") {
            $("#datatable_pr tbody").on("click", "#approve_pr", function(e) {
                e.preventDefault();

                var current_row = $(this).parents("tr");
                if (current_row.hasClass("child")) {
                    current_row = current_row.prev();
                }
                var data = table.row(current_row).data();

                Swal.fire({
                    title: "Setujui Daftar Permintaan Pembelian?",
                    // text: "Apakah Kamu Yakin?",
                    icon: "warning",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Setuju!',
                    denyButtonText: 'Tolak!',
                }).then((result) => {
                    (async () => {
                        if (result.isConfirmed) {
                            Update_Approve(data["pr_code"], "Y", null, "Y")
                        } else if (result.isDenied) {
                            (async () => {
                                Swal.fire('Changes are not saved', '', 'info')
                                const {
                                    value: reason
                                } = await Swal.fire({
                                    title: 'Alasan Penolakan!',
                                    input: 'textarea',
                                    inputPlaceholder: 'Masukkan Alasan Penolakan...',
                                    showCancelButton: true,
                                    inputValidator: (value) => {
                                        if (!value) {
                                            return 'You need to write something!'
                                        }
                                    }
                                })

                                if (reason) {
                                    Update_Approve(data["pr_code"], "N", reason, "N")
                                }
                            })()
                        }
                    })()
                });
            });
        }

    })

    function Update_Approve(pr_code, pr_approve, pr_approve_desc, pr_create_po) {
        $.ajax({
            type: "POST",
            url: "<?= base_url("pr/approve_pr") ?>",
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
            },
            data: {
                pr_code: pr_code,
                pr_approve: pr_approve,
                pr_approve_desc: pr_approve_desc,
                pr_create_po: pr_create_po,
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

                        $("#datatable_pr").DataTable().ajax.reload();
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