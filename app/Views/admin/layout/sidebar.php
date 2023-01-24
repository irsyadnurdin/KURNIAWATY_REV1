<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">
                    Menu
                </li>
                <li>
                    <a href="<?= base_url("/" . $locale . "/admin") ?>" id="menu-dashboard">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Beranda
                    </a>
                </li>
                <li id="menu-item">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-box2"></i>
                        Produk
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul id="menu-item-ul">
                        <li>
                            <a href="<?= base_url("/" . $locale . "/admin/item") ?>" id="menu-item-ul-li">
                                <i class="metismenu-icon"></i>
                                Produk
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url("/" . $locale . "/admin/item_group") ?>" id="menu-itemgroup-ul-li">
                                <i class="metismenu-icon"></i>
                                Grup Produk
                            </a>
                        </li>
                        <?php if ($_SESSION['session_admin']['user_role'] != "cashier") : ?>
                            <li>
                                <a href="<?= base_url("/" . $locale . "/admin/measure") ?>" id="menu-measure-ul-li">
                                    <i class="metismenu-icon"></i>
                                    Satuan Produk
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>

                <?php if ($_SESSION['session_admin']['user_role'] != "cashier") : ?>
                    <li>
                        <a href="<?= base_url("/" . $locale . "/admin/bahan_baku") ?>" id="menu-bahanbaku">
                            <i class="metismenu-icon pe-7s-box2"></i>
                            Bahan Baku
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['session_admin']['user_role'] != "warehouse") : ?>
                    <li>
                        <a href="<?= base_url("/" . $locale . "/admin/pricelist") ?>" id="menu-pricelist">
                            <i class="metismenu-icon pe-7s-cash"></i>
                            Daftar Harga
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['session_admin']['user_role'] != "cashier") : ?>
                    <li id="menu-ps">
                        <a href="#">
                            <i class="metismenu-icon pe-7s-network"></i>
                            Struktur Produk
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul id="menu-ps-ul">
                            <li>
                                <a href="<?= base_url("/" . $locale . "/admin/ps") ?>" id="menu-ps-ul-li">
                                    <i class="metismenu-icon"></i>
                                    Struktur Produk
                                </a>
                            </li>
                            <?php if ($_SESSION['session_admin']['user_role'] == "warehouse") : ?>
                                <li>
                                    <a href="<?= base_url("/" . $locale . "/admin/ps_add") ?>" id="menu-psadd-ul-li">
                                        <i class="metismenu-icon"></i>
                                        Tambah Data
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['session_admin']['user_role'] != "cashier") : ?>
                    <li>
                        <a href="<?= base_url("/" . $locale . "/admin/stock") ?>" id="menu-stock">
                            <i class="metismenu-icon pe-7s-diskette"></i>
                            Histori Stok
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['session_admin']['user_role'] != "warehouse") : ?>
                    <li id="menu-sq">
                        <a href="#">
                            <i class="metismenu-icon pe-7s-shopbag"></i>
                            Penjualan
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul id="menu-sq-ul">
                            <li>
                                <a href="<?= base_url("/" . $locale . "/admin/sq") ?>" id="menu-sq-ul-li">
                                    <i class="metismenu-icon"></i>
                                    Penjualan
                                </a>
                            </li>
                            <?php if ($_SESSION['session_admin']['user_role'] == "cashier") : ?>
                                <li>
                                    <a href="<?= base_url("/" . $locale . "/admin/sq_add") ?>" id="menu-sqadd-ul-li">
                                        <i class="metismenu-icon"></i>
                                        Tambah Data
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['session_admin']['user_role'] != "cashier") : ?>
                    <li id="menu-pr">
                        <a href="#">
                            <i class="metismenu-icon pe-7s-note2"></i>
                            Permintaan Pembelian
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul id="menu-pr-ul">
                            <li>
                                <a href="<?= base_url("/" . $locale . "/admin/pr") ?>" id="menu-pr-ul-li">
                                    <i class="metismenu-icon"></i>
                                    Permintaan Pembelian
                                </a>
                            </li>
                            <?php if ($_SESSION['session_admin']['user_role'] == "warehouse") : ?>
                                <li>
                                    <a href="<?= base_url("/" . $locale . "/admin/pr_add") ?>" id="menu-pradd-ul-li">
                                        <i class="metismenu-icon"></i>
                                        Tambah Data
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['session_admin']['user_role'] != "cashier") : ?>
                    <li id="menu-po">
                        <a href="#">
                            <i class="metismenu-icon pe-7s-cart"></i>
                            Pesanan Pembelian
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul id="menu-po-ul">
                            <li>
                                <a href="<?= base_url("/" . $locale . "/admin/po") ?>" id="menu-po-ul-li">
                                    <i class="metismenu-icon"></i>
                                    Pesanan Pembelian
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['session_admin']['user_role'] != "cashier") : ?>
                    <li id="menu-return">
                        <a href="#">
                            <i class="metismenu-icon pe-7s-repeat"></i>
                            Pengembalian
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul id="menu-return-ul">
                            <li>
                                <a href="<?= base_url("/" . $locale . "/admin/return") ?>" id="menu-return-ul-li">
                                    <i class="metismenu-icon"></i>
                                    Pengembalian
                                </a>
                            </li>
                            <?php if ($_SESSION['session_admin']['user_role'] == "warehouse") : ?>
                                <li>
                                    <a href="<?= base_url("/" . $locale . "/admin/return_add") ?>" id="menu-returnadd-ul-li">
                                        <i class="metismenu-icon"></i>
                                        Tambah Data
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['session_admin']['user_role'] == "owner") : ?>
                    <li id="menu-user">
                        <a href="#">
                            <i class="metismenu-icon pe-7s-id"></i>
                            User
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul id="menu-user-ul">
                            <li>
                                <a href="<?= base_url("/" . $locale . "/admin/warehouse") ?>" id="menu-warehouse-ul-li">
                                    <i class="metismenu-icon"></i>
                                    Bagian Gudang
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url("/" . $locale . "/admin/cashier") ?>" id="menu-cashier-ul-li">
                                    <i class="metismenu-icon"></i>
                                    Kasir
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['session_admin']['user_role'] != "cashier") : ?>
                    <li>
                        <a href="<?= base_url("/" . $locale . "/admin/suplier") ?>" id="menu-suplier">
                            <i class="metismenu-icon pe-7s-download"></i>
                            Pemasok
                        </a>
                    </li>
                <?php endif; ?>

                <li class="app-sidebar__heading">Pengaturan</li>
                <li>
                    <a href="<?= base_url("/" . $locale . "/admin/profile") ?>" id="menu-profile">
                        <i class="metismenu-icon pe-7s-user"></i>
                        Akun Saya
                    </a>
                </li>
                <li>
                    <a href="<?= base_url("/admin/logout") ?>">
                        <i class="metismenu-icon pe-7s-power"></i>
                        keluar
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>