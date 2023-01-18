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
                    Tambah Penjualan
                    <div class="page-title-subheading">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur modi maiores error cum incidunt dolores itaque! Ex, ipsum officiis ratione nulla quam aut magnam fugiat deserunt, praesentium laboriosam quis perferendis!
                    </div>
                </div>
            </div>
            <!-- ADDITIONAL BUTTON -->
        </div>
    </div>
    <form class="form_sq_action" id="form_sq_action">
        <div class="row">

            <div class="col-xl-3">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Penjualan</h5>
                        <form class="">
                            <div class="position-relative form-group">
                                <label for="sq_desc">Deskripsi SQ</label>
                                <textarea id="sq_desc" name="sq_desc" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="position-relative form-group">
                                <label for="sq_cash_status">Cash Status</label>
                                <!-- <input id="sq_cash_status" name="sq_cash_status" type="number" class="form-control" min="0" value="0" required="" readonly> -->
                                <div>
                                    <div class="custom-radio custom-control">
                                        <input type="radio" id="sq_cash_status1" name="sq_cash_status" value="Y" checked=true>
                                        <!-- <input type="radio" id="sq_cash_status" checked=true name="sq_cash_status"> -->
                                        <label for="sq_cash_status1">Cash</label>

                                    </div>
                                    <div class="custom-radio custom-control">
                                        <input type="radio" id="sq_cash_status2" name="sq_cash_status" value="N">
                                        <!-- <input type="radio" id="sq_cash_status" name="sq_cash_status"> -->
                                        <label for="sq_cash_status2">Non Cash</label>
                                    </div>
                                </div>
                            </div>
                            <div class="position-relative form-group">
                                <label for="sq_total">Total SQ (*)</label>
                                <input id="sq_total" name="sq_total" type="number" class="form-control" min="0" value="0" required="" readonly>
                            </div>
                            <div class="position-relative form-group">
                                <small class="form-text text-muted">
                                    Catatan : <br>(*) Form Wajib Diisi!
                                </small>
                            </div>
                            <button type="submit" class="mt-1 btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Penjualan</h5>
                        <table id="datatable_sq" class="table table-hover table-striped nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Kode Item</th>
                                    <th>Nama Item</th>
                                    <th>Deskripsi</th>
                                    <th>Harga Satuan</th>
                                    <th>Kuantitas</th>
                                    <th>Satuan Item</th>
                                    <th>Total</th>
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

<div id="modal_sq" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
        $("#menu-sq").addClass("mm-active");
        $("#menu-sq-ul").addClass("mm-show");
        $("#menu-sqadd-ul-li").addClass("mm-active");
    })
</script>

<script>
    $(document).on('change', '#sqd_change', function(e) {
        e.preventDefault();

        var sqd_price = $(this).parent().parent().find('.sqd_price').val();
        var sqd_qty = $(this).parent().parent().find('.sqd_qty').val();
        var sqd_total = (sqd_price * sqd_qty);

        $(this).parent().parent().find('#sqd_total').val(sqd_total);
        $(this).parent().parent().find('#sqd_total').html(sqd_total);

        var sq_total = 0;
        var sqd_total = document.getElementsByClassName("sqd_total");
        var values = [];
        for (var i = 0; i < sqd_total.length; ++i) {
            values.push(parseFloat(sqd_total[i].value));
        }

        sq_total = values.reduce(function(previousValue, currentValue, index, array) {
            return previousValue + currentValue;
        });

        $('#sq_total').val(sq_total);

        return false;
    })
</script>

<script>
    var formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "IDR",
    });

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
                        'item_type': ['JL', 'BJ']
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
                    title: "Grup Item",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.item_group ? data.itemg_name : "-");
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
                    title: "Harga Item",
                    sClass: "center-datatable",
                    render: function(data, row, type, meta) {
                        return (data.item_price ? formatter.format(data.item_price) : "-");
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
                url: "<?= base_url("item/add_item") ?>",
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

                            $('#datatable_sq').DataTable().row.add([
                                '<input hidden type="text" id="sqd_item" name="sqd_item[]" value="' + data.data.item_code + '">' + data.data.item_code,
                                data.data.item_name,
                                '<input type="text" id="sqd_desc" name="sqd_desc[]"/>',
                                // '<input type="number" id="sqd_change" class="sqd_price" name="sqd_price[]" min="0" value="0" required/>',
                                '<input hidden type="number" id="sqd_price" class="sqd_price" name="sqd_price[]" value="' + data.data.item_price + '" readonly required>' + data.data.item_price,
                                '<input type="number" id="sqd_change" class="sqd_qty" name="sqd_qty[]" min="1" value="1" required/>',
                                data.data.item_measure,
                                '<input type="number" id="sqd_total" name="sqd_total[]" class="sqd_total" min="0" value="' + data.data.item_price + '" readonly required/>',
                            ]).draw();

                            $(this).parent().parent().find('#sqd_total').val(sqd_total);
                            $(this).parent().parent().find('#sqd_total').html(sqd_total);

                            var sq_total = 0;
                            var sqd_total = document.getElementsByClassName("sqd_total");
                            var values = [];
                            for (var i = 0; i < sqd_total.length; ++i) {
                                values.push(parseFloat(sqd_total[i].value));
                            }

                            sq_total = values.reduce(function(previousValue, currentValue, index, array) {
                                return previousValue + currentValue;
                            });

                            $('#sq_total').val(sq_total);

                            // $('#datatable_sq').append(data.detail);
                            // $("#datatable_sq").DataTable().ajax.reload();
                            $('#datatable_sq').DataTable()
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
        var table = $("#datatable_sq").DataTable({
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
            // responsive: true,
            columnDefs: [],
            scrollX: true,
            // scrollY: 400,
            // scrollCollapse: true,
            // scroller: true,
            dom: "Blfrtip",
            buttons: [{
                text: 'Add Item',
                action: function(e, dt, node, config) {
                    $("#modal_sq").modal("show");
                }
            }],
        });
    })
</script>

<script>
    $("#form_sq_action").submit(function(e) {
        e.preventDefault();

        var url = "<?= base_url("sq/insert_sq") ?>";

        var formData = new FormData(this);

        count_data = formData.getAll('sqd_item[]').length;

        if (count_data > 0) {
            var status = true;

            for (let i = 0; i < count_data; i++) {
                if (formData.getAll('sqd_price[]')[i] == 0) {
                    status = false;
                }
            }

            if (status) {
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

                                $("#sq_desc").val("");
                                $("#sq_total").val(0);
                                $("#datatable_sq").DataTable().clear().draw();
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
                        text: "Harga Satuan Tidak Boleh 0!",
                        showConfirmButton: false,
                        timer: 2000
                    })
                })()
            }
        } else {
            (async () => {
                await Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Detail Penjualan Tidak Boleh Kosong!",
                    showConfirmButton: false,
                    timer: 2000
                })
            })()
        }

        return false;
    });
</script>

<?= $this->endSection() ?>