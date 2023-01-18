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
                    Histori Stok
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
            <table id="datatable_stock" class="table table-hover table-striped nowrap" style="width: 100%;">
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>



<?= $this->endSection() ?>


<?= $this->section("javascript") ?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#menu-stock").addClass("mm-active");
    })
</script>

<script>
    $(function() {
        var url = "<?= base_url("stock/get_stock") ?>";

        var messageTop = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perferendis deserunt laboriosam molestias vitae, ipsa nostrum, delectus obcaecati numquam ipsum ea, dolor rerum eos expedita placeat natus aperiam nam amet vero.";
        var fileName = "Stock History Data"
        $("#datatable_stock").attr("data-export-title", fileName);

        var buttonCommon = {
            init: function(dt, node, config) {
                var table = dt.table().context[0].nTable;
                if (table) config.title = $(table).data('export-title')
            },
            title: 'default title'
        };

        var table = $("#datatable_stock").DataTable({
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
                            return "Stock History [" + Object.values(data)[0] + "]";
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
                        return (data.stock_item ? data.stock_item : "-");
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
                        return (data.stock_qty ? `${data.stock_qty} ${data.item_measure}` : "-");
                    }
                },
                {
                    mData: null,
                    title: "Tipe Stok",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.stock_type ? data.stock_type : "-");
                    }
                },
                {
                    mData: null,
                    title: "Add By",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.stock_add_by ? data.stock_add_by : "-");
                    }
                },
                {
                    mData: null,
                    title: "Add Date",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.stock_add_date ? data.stock_add_date : "-");
                    }
                },
            ],
        });
    })
</script>

<?= $this->endSection() ?>