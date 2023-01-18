<!doctype html>
<html lang="en">

<head>
    <title>DASHBOARD - <?= $setting_mstr[0]['stg_value'] ?></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="LOGIN - <?= $setting_mstr[0]['stg_value'] ?>" />
    <meta name="description" content="LOGIN - <?= $setting_mstr[0]['stg_value'] ?>">
    <meta name="author" content="<?= $setting_mstr[0]['stg_value'] ?>">
    <meta name="msapplication-tap-highlight" content="no">

    <link href="<?= base_url('_img/' . $setting_mstr[3]['stg_value']) ?>" rel="icon">
    <link href="<?= base_url('_img/' . $setting_mstr[3]['stg_value']) ?>" rel="apple-touch-icon">

    <!-- SWEETALERT2 -->
    <link href="<?= base_url('sweetalert/sweetalert2.css') ?>" rel="stylesheet">

    <!-- TEMP_ADMIN -->
    <link rel="stylesheet" href="<?= base_url('temp_admin/main.d810cf0ae7f39f28f336.css') ?>">

    <!-- DATATABLE -->
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedcolumns/4.1.0/css/fixedColumns.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/colreorder/1.5.6/css/colReorder.dataTables.min.css" rel="stylesheet">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css" rel="stylesheet"> -->
    <!-- <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bulma.min.css" rel="stylesheet"> -->
    <!-- <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bulma.min.css" rel="stylesheet"> -->
    <link href="https://cdn.datatables.net/autofill/2.4.0/css/autoFill.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/keytable/2.7.0/css/keyTable.dataTables.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.datatables.net/keytable/2.7.0/css/keyTable.bulma.min.css" rel="stylesheet"> -->
    <link href="https://cdn.datatables.net/searchbuilder/1.3.4/css/searchBuilder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/scroller/2.0.7/css/scroller.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/searchpanes/2.0.2/css/searchPanes.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css" rel="stylesheet">
    <link href="" rel="stylesheet">
    <link href="" rel="stylesheet">
    <link href="" rel="stylesheet">
    <link href="" rel="stylesheet">

    <!-- CROPPER -->
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />

    <!-- STYLE -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        <!-- HEADER -->
        <?= $this->include('admin/layout/header') ?>

        <div class="app-main">
            <!-- SIDEBAR -->
            <?= $this->include('admin/layout/sidebar') ?>

            <!-- CONTENT -->
            <div class="app-main__outer" style="width: 100vw;">
                <?= $this->renderSection('content') ?>

                <?= $this->include('admin/layout/footer') ?>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <?= $this->renderSection('modal') ?>

    <div class="app-drawer-overlay d-none animated fadeIn"></div>

    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- BOOTSTRAP 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- SWEETALERT2 -->
    <script src="<?= base_url('sweetalert/sweetalert2.js') ?>" type="text/javascript"></script>

    <!-- DATATABLE -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.6/js/dataTables.colReorder.min.js" type="text/javascript"></script>
    <!-- <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bulma.min.js" type="text/javascript"></script> -->
    <!-- <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bulma.min.js" type="text/javascript"></script> -->
    <script src="https://cdn.datatables.net/autofill/2.4.0/js/dataTables.autoFill.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/keytable/2.7.0/js/dataTables.keyTable.min.js" type="text/javascript"></script>
    <!-- <script src="https://cdn.datatables.net/keytable/2.7.0/js/dataTables.keyTable.min.js" type="text/javascript"></script> -->
    <script src="https://cdn.datatables.net/searchbuilder/1.3.4/js/dataTables.searchBuilder.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/scroller/2.0.7/js/dataTables.scroller.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.0.2/js/dataTables.searchPanes.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js" type="text/javascript"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js" type="text/javascript"></script> -->
    <script src="<?= base_url('js/pdfmake.min.js') ?>" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js" type="text/javascript"></script>
    <script src="" type="text/javascript"></script>
    <script src="" type="text/javascript"></script>

    <!-- CROPPER -->
    <script src="https://unpkg.com/cropperjs"></script>

    <!-- TEMP ADMIN -->
    <script src="<?= base_url('temp_admin/assets/scripts/main.d810cf0ae7f39f28f336.js') ?>"></script>

    <!-- =========================================================================== -->
    <!-- =========================================================================== -->

    <?= $this->renderSection('javascript') ?>

    <!-- =========================================================================== -->
    <!-- =========================================================================== -->

</body>

</html>