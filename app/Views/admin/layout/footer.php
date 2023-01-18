<div class="app-wrapper-footer">
    <div class="app-footer">
        <div class="app-footer__inner">
            <div class="app-footer-left">

            </div>
            <div class="app-footer-right">
                <ul class="header-megamenu nav">
                    <li class="nav-item" style="align-self: center;">
                        <a href="<?= base_url("/" . $locale . "/admin") ?>" class="nav-link">
                            <div class="logo-footer" style="background: url('<?= base_url('temp_admin/assets/images/logo-inverse.png') ?>');"></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<?= $this->section('javascript') ?>

<?= $this->endSection() ?>