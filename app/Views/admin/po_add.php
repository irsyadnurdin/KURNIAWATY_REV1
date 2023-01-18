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
                    Tambahkan Pesanan Pembelian
                    <div class="page-title-subheading">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur modi maiores error cum incidunt dolores itaque! Ex, ipsum officiis ratione nulla quam aut magnam fugiat deserunt, praesentium laboriosam quis perferendis!
                    </div>
                </div>
            </div>
            <!-- ADDITIONAL BUTTON -->
        </div>
    </div>
    <form class="form_po_action" id="form_po_action">
        <div class="row">

            <div class="col-xl-3">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Pesanan Pembelian</h5>
                        <form class="">
                            <div class="position-relative form-group">
                                <label>Kode PR</label>
                                <input type="text" value="<?= $pr['pr_code'] ?>" class="form-control" disabled>
                            </div>
                            <!-- <div class="position-relative form-group">
                                <label>Nama PR</label>
                                <input type="text" value="<?= $pr['pr_name'] ?>" class="form-control" disabled>
                            </div> -->
                            <div class="position-relative form-group">
                                <label for="po_name">Nama PO</label>
                                <input id="po_name" name="po_name" type="text" class="form-control" required="">
                            </div>
                            <div class="position-relative form-group">
                                <label for="po_desc">Deskripsi PO</label>
                                <textarea id="po_desc" name="po_desc" class="form-control"></textarea>
                            </div>
                            <div class="position-relative form-group">
                                <label>Pemasok</label>
                                <input type="text" value="<?= $pr['sup_name'] ?>" class="form-control" disabled>
                            </div>
                            <div class="position-relative form-group">
                                <label>Total</label>
                                <input type="text" value="<?= $pr['pr_total'] ?>" class="form-control" disabled>
                            </div>
                            <div class="position-relative form-group">
                                <small class="form-text text-muted">
                                    Silahkan Cek Kembali Daftar Pembelian Sebelum Melanjutkan Proses!
                                </small>
                            </div>
                            <button type="submit" class="mt-1 btn btn-primary">Buat Pesanan Pembelian</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Pesanan Pembelian</h5>
                        <table id="datatable_po" class="table table-hover table-striped nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Kode Item</th>
                                    <th>Nama Item</th>
                                    <th>Deskripsi</th>
                                    <th>Harga Satuan</th>
                                    <th>Kuantitas</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($prd_es as $prd) : ?>
                                    <tr>
                                        <td class="text-center"><?= $prd['prd_item'] ?></td>
                                        <td class="text-center"><?= $prd['item_name'] ?></td>
                                        <td class="text-center"><?= ($prd['prd_desc'] != null ? $prd['prd_desc'] : "-") ?></td>
                                        <td class="text-center"><?= "IDR " . number_format($prd['prd_price'], 2, ',', '.') ?></td>
                                        <td class="text-center"><?= $prd['prd_qty'] ?></td>
                                        <td class="text-center"><?= "IDR " . number_format($prd['prd_total'], 2, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
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
        $("#menu-po").addClass("mm-active");
    })
</script>

<script>
    $(function() {
        var table = $("#datatable_po").DataTable({
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
            dom: "lfrtip",
            buttons: [{
                text: 'Tambah Item',
                action: function(e, dt, node, config) {
                    $("#modal_po").modal("show");
                }
            }],
        });
    })
</script>

<script>
    $("#form_po_action").submit(function(e) {
        e.preventDefault();

        var url = "<?= base_url("po/insert_po") ?>";

        var formData = new FormData(this);
        formData.append('pr_code', '<?= $pr_code ?>');

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

                        window.location.assign("<?= base_url("/" . $locale . "/admin/po") ?>");
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
</script>

<?= $this->endSection() ?>