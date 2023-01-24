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
                    Pengembalian
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
            <table id="datatable_return" class="table table-hover table-striped nowrap" style="width: 100%;">
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>

<div id="modal_return" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <table id="datatable_return_detail" class="table table-hover table-striped nowrap" style="width: 100%;">
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("javascript") ?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#menu-return").addClass("mm-active");
        $("#menu-return-ul").addClass("mm-show");
        $("#menu-return-ul-li").addClass("mm-active");
    })
</script>

<script>
    var formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "IDR",
    });

    $(function() {
        var url = "<?= base_url("return/get_return") ?>";

        var messageTop = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis deserunt laboriosam molestias vitae, ipsa nostrum, delectus obcaecati numquam ipsum ea, dolor rerum eos expedita placeat natus aperiam nam amet vero.";
        var fileName = "Data Pengembalian"
        $("#datatable_return").attr("data-export-title", fileName);

        var buttonCommon = {
            init: function(dt, node, config) {
                var table = dt.table().context[0].nTable;
                if (table) config.title = $(table).data('export-title')
            },
            title: 'default title'
        };

        var table = $("#datatable_return").DataTable({
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
            //                 return "Purchase Order [" + Object.values(data)[0] + "]";
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
                    title: "Kode Pengembalian",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.return_code ? data.return_code : "-");
                    }
                },
                {
                    mData: null,
                    title: "Kode Pesanan Pembelian",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.return_po ? data.return_po : "-");
                    }
                },
                {
                    mData: null,
                    title: "Nama Pengembalian",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.return_name ? data.return_name : "-");
                    }
                },
                {
                    mData: null,
                    title: "Deskripsi",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.return_desc ? data.return_desc : "-");
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
                    title: "Add By",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.return_add_by ? data.return_add_by : "-");
                    }
                },
                {
                    mData: null,
                    title: "Add Date",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.return_add_date ? data.return_add_date : "-");
                    }
                },
                {
                    mData: null,
                    title: "Update By",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.return_upd_by ? data.return_upd_by : "-");
                    }
                },
                {
                    mData: null,
                    title: "Update Date",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.return_upd_date ? data.return_upd_date : "-");
                    }
                },
                {
                    mData: null,
                    title: "Status",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        if (data.return_status == "P") {
                            html += "<i class='fa fa-spinner' style='color:#1cc88a' data-bs-toggle='tooltip' data-bs-html='true' title='Sedang Dalam Proses'></i>";
                        } else if (data.return_status == "F") {
                            html += "<i class='fa fa-check' style='color:#1cc88a'></i>";
                        } else {
                            html += "-";
                        }

                        return html;
                    },
                },
                {
                    mData: null,
                    title: "Bukti Penerimaan",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        if (data.return_status == "F") {
                            html += "<button style='font-size: 10px;' class='btn btn-primary mr-2' id='popup_image' title='Popup Image' img='" + data.return_bukti_penerimaan + "'><i class='fa fa-image'></i></button>";
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

                        if (("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") && (data.return_status == "P")) {
                            html += "<a id='confirm_return' href=''><i class='fa fa-cog' style='color:#1cc88a'></i></a>";
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

                        html += "<button style='font-size: 10px;' class='btn btn-primary' id='detail_return' title='Detail Pengembalian'><i class='fa fa-eye'></i></button>";

                        return html;
                    }
                },
            ],
        });

        $("#datatable_return tbody").on("click", "#popup_image", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            Swal.fire({
                title: data["return_name"],
                imageUrl: "<?= base_url("_img/return") ?>" + "/" + $(this).attr("img"),
                imageHeight: "90%",
                imageAlt: data["return_name"],
                showConfirmButton: false,
            })
        });

        $("#datatable_return tbody").on("click", "#detail_return", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table.row(current_row).data();

            (async () => {
                await $("#modal_return").modal("show");

                // $("#datatable_return_detail").DataTable().destroy();
                // $("#datatable_return_detail").html("");

                await $("#datatable_return_detail").DataTable({
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
                        url: "<?= base_url("return/get_return_detail") ?>" + "/" + data["return_code"],
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
                                return (data.returnd_item ? data.returnd_item : "-");
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
                            title: "Alasan Pengembalian",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.returnd_reason ? data.returnd_reason : "-");
                            }
                        },
                        {
                            mData: null,
                            title: "Kuantitas",
                            sClass: "center-datatable",
                            render: function(data, row, type, meta) {
                                return (data.returnd_qty ? `${Number(data.returnd_qty).toFixed(0)} ${data.item_measure}` : "-");
                            }
                        },
                    ],
                });
            })()
        });

        if ("<?= $_SESSION['session_admin']['user_role'] ?>" == "warehouse") {
            $("#datatable_return tbody").on("click", "#confirm_return", function(e) {
                e.preventDefault();

                var current_row = $(this).parents("tr");
                if (current_row.hasClass("child")) {
                    current_row = current_row.prev();
                }
                var data = table.row(current_row).data();

                Swal.fire({
                    title: "Konfirmasi Pengembalian Diterima?",
                    // text: "Apakah Kamu Yakin?",
                    icon: "warning",
                    // showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Setujui!',
                    // denyButtonText: 'Deny!',
                }).then((result) => {
                    (async () => {
                        if (result.isConfirmed) {
                            (async () => {
                                const {
                                    value: file
                                } = await Swal.fire({
                                    title: "Bukti Penerimaan",
                                    input: "file",
                                    inputAttributes: {
                                        "accept": "image/*",
                                        "aria-label": "Unggah gambar item..."
                                    }
                                });

                                if (file) {
                                    var formData = new FormData();
                                    var return_bukti_penerimaan = $(".swal2-file")[0].files[0];
                                    formData.append("return_code", data["return_code"]);
                                    formData.append("return_status", "F");
                                    formData.append("return_bukti_penerimaan", return_bukti_penerimaan);

                                    $.ajax({
                                        type: "POST",
                                        url: "<?= base_url("return/confirm_return") ?>",
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

                                                    $("#datatable_return").DataTable().ajax.reload();
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
                            })()
                        }
                    })()
                });
            });
        }
    })
</script>

<?= $this->endSection() ?>