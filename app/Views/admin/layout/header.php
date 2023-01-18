<div class="app-header header-shadow">
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
    <div class="app-header__content">
        <div class="app-header-left">

            <ul class="header-megamenu nav">
                <!-- MEGA MENU -->

                <!-- SETTINGS MENU -->

                <!-- PROJECTS MENU -->
            </ul>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <img width="42" class="rounded-circle" src="<?= base_url("_img/profile/" . $user_mstr['user_image']) ?>" alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-info">
                                            <div class="menu-header-image opacity-2" style="background-image: url('<?= base_url("temp_admin/assets/images/dropdown-header/city3.jpg") ?>');">
                                            </div>
                                            <div class="menu-header-content text-left">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <img width="42" class="rounded-circle" src="<?= base_url("_img/profile/" . $user_mstr['user_image']) ?>" alt="">
                                                        </div>
                                                        <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                                <?php echo $user_mstr['user_full_name']; ?>
                                                            </div>
                                                            <div class="widget-subheading opacity-8">
                                                                <?php echo $user_mstr['role_name']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-right mr-2">
                                                            <a href="<?= base_url("/admin/logout") ?>" class="btn-pill btn-shadow btn-shine btn btn-focus">
                                                                Logout
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scroll-area-xs" style="height: auto;">
                                        <div class="scrollbar-container ps">
                                            <ul class="nav flex-column">
                                                <li class="nav-item-header nav-item">
                                                    Akun Saya
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?= base_url("/" . $locale . "/admin/profile") ?>" class="nav-link">
                                                        Pengaturan
                                                        <!-- <div class="ml-auto badge badge-success">New</div> -->
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading"> <?php echo $user_mstr['user_full_name']; ?> </div>
                            <div class="widget-subheading"> <?php echo $user_mstr['role_name']; ?> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>