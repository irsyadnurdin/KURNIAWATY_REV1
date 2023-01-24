<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurt Beans Coffee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="card">
            <div class="card-header">
                Purchase Requisition (Permintaan Pembelian)
                <strong>[<?= $pr['_pr_add_date'] ?>]</strong>
                <span class="float-right"> <strong>Status:</strong> Approve</span>

            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="mb-3">Pemasok :</h6>
                        <div>
                            <strong><?= $pr['sup_name'] ?></strong>
                        </div>
                        <div><?= $pr['sup_address'] ?></div>
                        <?= $pr['sup_email'] != null ? "<div>Email: " . $pr['sup_email'] . "</div>" : "" ?>
                        <div>Phone: <?= $pr['sup_phone'] ?></div>
                    </div>

                    <div class="col-sm-6">
                    </div>
                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Harga Satuan</th>
                                <th>Kuantitas</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($prd_es as $prd) : ?>
                                <tr>
                                    <td class="center"><?= $i++ ?></td>
                                    <td class="left strong">
                                        <?= $prd['prd_item'] ?>
                                    </td>
                                    <td class="left">
                                        <?= $prd['item_name'] ?>
                                    </td>
                                    <td class="right">
                                        Rp <?= number_format($prd['prd_price'], 2, ',', '.') ?>
                                    </td>
                                    <td class="center">
                                        <?= $prd['prd_qty'] ?>
                                    </td>
                                    <td class="right">
                                        Rp <?= number_format($prd['prd_total'], 2, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5 col-6">
                    </div>

                    <div class="col-lg-4 col-sm-5 col-6 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <!-- <tr>
                                    <td class="left">
                                        <strong>Subtotal</strong>
                                    </td>
                                    <td class="right">
                                        Rp <?= number_format($pr['pr_total'], 2, ',', '.') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Discount (20%)</strong>
                                    </td>
                                    <td class="right">$1,699,40</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>VAT (10%)</strong>
                                    </td>
                                    <td class="right">$679,76</td>
                                </tr> -->
                                <tr>
                                    <td class="left">
                                        <strong>Total</strong>
                                    </td>
                                    <td class="right">
                                        <strong>
                                            Rp <?= number_format($pr['pr_total'], 2, ',', '.') ?>
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-6 text-center" style="align-self: center;">
                        <img src="<?= $qr_code ?>" width="100">
                    </div>

                    <!-- <div class="col-6 text-center">
                        <p>Mengetahui,</p>
                        <br><br><br>
                        <strong>(..............................)</strong>
                        <p>Pemilik Toko</p>
                    </div> -->
                </div>


            </div>
        </div>
    </div>
</body>

</html>