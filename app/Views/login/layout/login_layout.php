<!doctype html>
<html lang="en">

<head>
    <title>LOGIN - <?= $setting_mstr[0]['stg_value'] ?></title>

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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- TEMP_ADMIN -->
    <link rel="stylesheet" href="<?= base_url('temp_admin/main.d810cf0ae7f39f28f336.css') ?>">

    <!-- STYLE -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>
    <?= $this->renderSection('content') ?>

    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- SWEETALERT2 -->
    <script src="<?= base_url('sweetalert/sweetalert2.js') ?>" type="text/javascript"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <!-- TEMP_LOGIN -->
    <script src="<?= base_url('temp_admin/assets/scripts/main.d810cf0ae7f39f28f336.js') ?>"></script>

    <!-- =========================================================================== -->
    <!-- =========================================================================== -->

    <?= $this->renderSection('javascript') ?>

    <!-- =========================================================================== -->
    <!-- =========================================================================== -->

</body>

</html>