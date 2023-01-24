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
                    Tambah Struktur Produk
                    <div class="page-title-subheading">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur modi maiores error cum incidunt dolores itaque! Ex, ipsum officiis ratione nulla quam aut magnam fugiat deserunt, praesentium laboriosam quis perferendis!
                    </div>
                </div>
            </div>
            <!-- ADDITIONAL BUTTON -->
        </div>
    </div>
    <form class="form_ps_action" id="form_ps_action">
        <div class="row">

            <div class="col-xl-3">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Struktur Produk</h5>
                        <form class="">
                            <div class="position-relative form-group">
                                <label for="ps_item">Item (*)</label>
                                <select id="ps_item" name="ps_item" class="form-control" required="">
                                    <option value="">Pilih Item...</option>
                                    <?php foreach ($item_es as $item) : ?>
                                        <option value=<?= $item['item_code'] ?>> <?= $item['item_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="position-relative form-group">
                                <small class="form-text text-muted">
                                    Catatan : <br>(*) Form Wajib Diisi!
                                </small>
                            </div>
                            <button type="submit" class="mt-1 btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Stuktur Produk</h5>
                        <table id="datatable_ps" class="table table-hover table-striped nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Kode Item</th>
                                    <th>Nama Item</th>
                                    <th>Kuantitas</th>
                                    <th>Satuan Item</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </form>


</div>

<?= $this->endSection() ?>


<?= $this->section("modal") ?>

<div id="modal_ps" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <table id="datatable_item" class="table table-hover table-striped nowrap" style="width: 100%;">
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
        $("#menu-psadd-ul-li").addClass("mm-active");
    })
</script>

<script>
    let ps_item = null

    $(document).on('change', '#ps_item', function(e) {
        e.preventDefault();

        ps_item = $("#ps_item").val()
        $("#datatable_item").DataTable().ajax.reload();
        $("#datatable_ps").DataTable().button(0).enable((ps_item != null) && (ps_item != "") ? true : false);
        $("#datatable_ps").DataTable().clear().draw();

        return false;
    })

    $(function() {
        var table_item = $("#datatable_item").DataTable({
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
            pageLength: 15,
            colReorder: true,
            // fixedColumns: {
            //     left: 2
            // },
            order: [
                [0, "asc"]
            ],
            responsive: true,
            columnDefs: [],
            // scrollX: true,
            // scrollY: 400,
            // scrollCollapse: true,
            // scroller      : true, 
            dom: "Blfrtip",
            buttons: [],
            // processing: true,
            // serverSide: true,
            // serverMethod: "POST",
            ajax: {
                url: "<?= base_url("item/get_item") ?>",
                type: 'POST',
                data: function(dd) {
                    return JSON.stringify({
                        'ps_item': ps_item,
                        'item_type': ['BB']
                    });
                },
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
                    title: "Satuan Item",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.item_measure ? `${data.item_measure}  (${data.measure_name})` : "-");
                    },
                },
                {
                    mData: null,
                    title: "Action",
                    sortable: false,
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        let html = "";

                        html += "<button style='font-size: 10px;' class='btn btn-primary mr-2' id='add_item' title='Add Item'><i class='fa fa-plus'></i></button>";

                        return html;
                    },
                },
            ],
        });

        $("#datatable_item tbody").on("click", "#add_item", function() {
            var current_row = $(this).parents("tr");
            if (current_row.hasClass("child")) {
                current_row = current_row.prev();
            }
            var data = table_item.row(current_row).data();

            // $("#cus_code").val(data["cus_code"]);
            // $("#cus_name").val(data["cus_name"]);
            // $("#cus_phone").val(data["cus_phone"]);
            // $("#cus_address").val(data["cus_address"]);
            // $("#form_customer_action").attr("act", "edit");
            // $("#modal-title").html("Edit Customer Data");
            // $("#cus_code").prop("readonly", true);

            // $("#modal_customer").modal("show");

            $.ajax({
                type: "POST",
                url: "<?= base_url("ps/add_item") ?>",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', "Bearer " + "<?= $_SESSION['session_admin']['access_token'] ?>");
                },
                data: {
                    item_code: data["item_code"],
                },
                success: function(data) {
                    if (data.success) {
                        (async () => {
                            // await Swal.fire({
                            //     icon: "success",
                            //     title: data.t_message,
                            //     text: data.message,
                            //     showConfirmButton: false,
                            //     timer: 2000
                            // })

                            table_item.row(current_row).remove().draw();

                            $('#datatable_ps').DataTable().row.add([
                                '<input hidden type="text" id="ps_child_item" name="ps_child_item[]" value="' + data.data.item_code + '">' + data.data.item_code,
                                data.data.item_name,
                                '<input type="number" id="ps_qty" name="ps_qty[]" min="1" value="1" required/>',
                                `${data.data.item_measure} (${data.data.measure_name})`,
                            ]).draw();

                            // $('#datatable_ps').append(data.detail);
                            // $("#datatable_ps").DataTable().ajax.reload();
                            $('#datatable_ps').DataTable()
                                .columns.adjust()
                                .responsive.recalc();
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
        });
    })
</script>

<script>
    $(function() {
        var table = $("#datatable_ps").DataTable({
            // keys: true,
            // autoFill: true,
            // select: {
            //     style: "single",
            // },
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
            columnDefs: [],
            // scrollX: true,
            // scrollY: 400,
            // scrollCollapse: true,
            // scroller: true,
            dom: "Blfrtip",
            buttons: [{
                text: 'Add Item',
                action: function(e, dt, node, config) {
                    $("#modal_ps").modal("show");
                },
                enabled: false
            }],
        });
    })
</script>

<script>
    $("#form_ps_action").submit(function(e) {
        e.preventDefault();

        var url = "<?= base_url("ps/insert_ps") ?>";

        var formData = new FormData(this);

        count_data = formData.getAll('ps_child_item[]').length;

        if (count_data > 0) {
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

                            // $("#ps_item").val("");
                            // $("#datatable_ps").DataTable().clear().draw();
                            // $("#datatable_item").DataTable().ajax.reload();

                            window.location.assign("<?= current_url() ?>");
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
            })
        } else {
            (async () => {
                await Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Struktur Produk Tidak Boleh Kosong!",
                    showConfirmButton: false,
                    timer: 2000
                })
            })()
        }

        return false;
    });
</script>

<?= $this->endSection() ?>