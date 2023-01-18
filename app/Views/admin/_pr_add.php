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
                    Add Permintaan Pembelian
                    <div class="page-title-subheading">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur modi maiores error cum incidunt dolores itaque! Ex, ipsum officiis ratione nulla quam aut magnam fugiat deserunt, praesentium laboriosam quis perferendis!
                    </div>
                </div>
            </div>
            <!-- ADDITIONAL BUTTON -->
        </div>
    </div>
    <form class="form_pr_action" id="form_pr_action">
        <div class="row">

            <div class="col-xl-3">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Permintaan Pembelian</h5>
                        <form class="">
                            <div class="position-relative form-group">
                                <label for="pr_name">Nama PR</label>
                                <input id="pr_name" name="pr_name" type="text" class="form-control" required="">
                            </div>
                            <div class="position-relative form-group">
                                <label for="pr_cost_center">Cost Center</label>
                                <input id="pr_cost_center" name="pr_cost_center" type="text" class="form-control" required="">
                            </div>
                            <div class="position-relative form-group">
                                <label for="pr_part_name">Nama Bagian</label>
                                <input id="pr_part_name" name="pr_part_name" type="text" class="form-control" required="">
                            </div>
                            <div class="position-relative form-group">
                                <label for="pr_applicant_name">Nama Pemohon</label>
                                <input id="pr_applicant_name" name="pr_applicant_name" type="text" class="form-control" value="<?= $_SESSION['session_admin']['user_full_name'] ?>" required="">
                            </div>
                            <div class="position-relative form-group">
                                <small class="form-text text-muted">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae magnam velit reiciendis provident, nesciunt dignissimos?
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
                        <h5 class="card-title">Purchase Requisition Detail</h5>
                        <table id="datatable_pr" class="table table-hover table-striped nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>QR/NQR</th>
                                    <th>Kode Item</th>
                                    <th>Nama Item</th>
                                    <th>Satuan</th>
                                    <th>Kuantitas</th>
                                    <th>Harga Unit</th>
                                    <th>Dokumentasi Spesifikasi</th>
                                    <th>Suhu Penyimpanan</th>
                                    <th>Nomor Katalog</th>
                                    <th>Bantuk Item</th>
                                    <th>Pembuatan</th>
                                    <th>Pengemasan</th>
                                    <th>Ukuran</th>
                                    <th>Deskripsi</th>
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



<?= $this->endSection() ?>


<?= $this->section("javascript") ?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#menu-pr").addClass("mm-active");
        $("#menu-pr-ul").addClass("mm-show");
        $("#menu-prd-ul-li").addClass("mm-active");
    })
</script>

<script>
    $(function() {
        var table = $("#datatable_pr").DataTable({
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
                    // $("#modal_po").modal("show");

                    $('#datatable_pr').DataTable().row.add([
                        '<input type="text" id="prd_qr" name="prd_qr[]" required/>',
                        '<input type="text" id="prd_item_code" name="prd_item_code[]" required/>',
                        '<input type="text" id="prd_item_name" name="prd_item_name[]" required/>',
                        '<input type="text" id="prd_measure" name="prd_measure[]" value="lembar" required/>',
                        '<input type="number" id="prd_qty" name="prd_qty[]" value="1" min="1" required/>',
                        '<input type="number" id="prd_price" name="prd_price[]" value="1" min="1" required/>',
                        '<input type="text" id="prd_documentation_spesification" name="prd_documentation_spesification[]"/>',
                        '<input type="text" id="prd_storage_temperature" name="prd_storage_temperature[]"/>',
                        '<input type="text" id="prd_no_catalog" name="prd_no_catalog[]" value="0"/>',
                        '<input type="text" id="prd_item_shape" name="prd_item_shape[]" required/>',
                        '<input type="text" id="prd_manufacture" name="prd_manufacture[]" required/>',
                        '<input type="text" id="prd_packaging" name="prd_packaging[]" required/>',
                        '<input type="text" id="prd_size" name="prd_size[]"/>',
                        '<input type="text" id="prd_desc" name="prd_desc[]"/>',
                    ]).draw();

                    $('#datatable_pr').DataTable()
                        .columns.adjust()
                        .responsive.recalc();
                }
            }],
        });
    })
</script>

<script>
    $("#form_pr_action").submit(function(e) {
        e.preventDefault();

        var url = "<?= base_url("pr/insert_pr") ?>";

        var formData = new FormData(this);

        count_data = formData.getAll('prd_item_code[]').length;

        if (count_data > 0) {
            var status = true;

            for (let i = 0; i < count_data; i++) {
                if (formData.getAll('prd_price[]')[i] == 0) {
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

                                $("#pr_name").val("");
                                $("#pr_cost_center").val("");
                                $("#pr_part_name").val("");
                                $("#pr_applicant_name").val("");
                                $("#datatable_pr").DataTable().clear().draw();
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
            } else {
                (async () => {
                    await Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Testing!",
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
                    text: "Detaik Permintaan Pembelian Tidak Boleh Kosong!",
                    showConfirmButton: false,
                    timer: 2000
                })
            })()
        }

        return false;
    });
</script>

<?= $this->endSection() ?>