<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url('admin_dashboard') ?>" class="brand-link">
        <img src="<?php echo base_url() ?>/admin_assets/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo get_lebel_by_value_in_settings('store_name'); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php
                $pic = get_data_by_id('pic', 'cc_users', 'user_id', newSession()->adUserId);
                echo image_view('uploads/user', '', $pic, 'noimage.png', 'img-circle elevation-2 size-50x50');
                ?>
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo admin_user_name(); ?></a>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <?php
                $modules = modules_access();
                $adRoleId = newSession()->adRoleId;
                $modArrayPur = ['Dashboard'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) {
                ?>
                    <?php echo add_main_based_menu_with_permission('Dashboard', base_url('admin_dashboard'), $adRoleId, 'fa-tachometer-alt', 'Dashboard'); ?>

                <?php } ?>

                <li class="nav-header">Products</li>

                <?php
                $modArrayPur = ['Order'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) {
                ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('order_list'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Order
                            </p>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $modArrayPur = ['Products'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) {
                ?>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p> Catalog <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php echo add_main_based_menu_with_permission('Product List', base_url('products'), $adRoleId, 'fa-circle', 'Products'); ?>

                            <?php echo add_main_based_menu_with_permission('Product Category', base_url('product_category'), $adRoleId, 'fa-circle', 'Product_category'); ?>

                            <?php echo add_main_based_menu_with_permission('Brand', base_url('brand'), $adRoleId, 'fa-circle', 'Brand'); ?>

                            <?php //echo add_main_based_menu_with_permission('Color Family', base_url('color_family'), $adRoleId, 'fa-circle', 'Color_family');
                            ?>

                            <?php echo add_main_based_menu_with_permission('Attribute Group', base_url('attribute_group'), $adRoleId, 'fa-circle', 'Attribute_group'); ?>

                            <?php echo add_main_based_menu_with_permission('Option', base_url('option'), $adRoleId, 'fa-circle', 'Option'); ?>

                            <?php //echo add_main_based_menu_with_permission('Advanced Products', base_url('advanced_products'), $adRoleId, 'fa-circle', 'Advanced_products'); 
                            ?>


                        </ul>
                    </li>
                <?php } ?>

                <?php
                $modArrayPur = ['Album'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) {
                    if ($modules['album'] == 1) {
                    ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('album'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Album
                            </p>
                        </a>
                    </li>
                <?php } }?>

                <?php
                $modArrayPur = ['Coupon'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) {
                ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('coupon'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Coupon
                            </p>
                        </a>
                    </li>
                <?php } ?>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p> Offer <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php echo add_main_based_menu_with_permission('General Offer', base_url('general_offer'), $adRoleId, 'fa-circle', 'General_offer'); ?>
                        <?php echo add_main_based_menu_with_permission('Zone Based Offer', base_url('zone_based_offer'), $adRoleId, 'fa-circle', 'General_offer'); ?>
                    </ul>
                </li>


                <?php
                $modArrayPur = ['Reviews'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) {
                    if ($modules['review'] == 1) {
                ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('reviews'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Reviews
                            </p>
                        </a>
                    </li>
                <?php } } ?>

                <li class="nav-header">Modules</li>
                <?php
                $modArrayPur = ['Shipping'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) { ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('shipping'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Shipping method
                            </p>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $modArrayPur = ['Payment'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) { ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('payment'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Payment method
                            </p>
                        </a>
                    </li>
                <?php } ?>


                <?php
                $modArrayPur = ['Module'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) {
                    ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('module'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Module
                            </p>
                        </a>
                    </li>
                <?php } ?>

                <li class="nav-header">Users</li>

                <?php
                $modArrayPur = ['User'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) {
                ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('user'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $modArrayPur = ['Role'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) {
                ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('role'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p> User Role </p>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $modArrayPur = ['Customers'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) {
                ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('customers'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>Customers </p>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $modArrayPur = ['Fund_request'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if (($menuAccessPur == true)|| ($modules['fund_request'] == 1)) {
                ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('fund_request'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>Fund Request </p>
                        </a>
                    </li>
                <?php }  ?>

                <li class="nav-header">System</li>
                <?php
                $modArrayPur = ['Settings'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) { ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('settings'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Settings
                            </p>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $modArrayPur = ['Theme_settings'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) { ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('theme_settings'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Theme Settings
                            </p>
                        </a>
                    </li>
                <?php } ?>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p> Localization <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <?php echo add_main_based_menu_with_permission('Geo Zone', base_url('geo_zone'), $adRoleId, 'fa-circle', 'Geo_zone'); ?>

                    </ul>
                </li>





                <?php
                $modArrayPur = ['Page_settings'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) { ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('page_list'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Page
                            </p>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $modArrayPur = ['Newsletter'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) {
                ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('newsletter'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Subscriber
                            </p>
                        </a>
                    </li>
                <?php } ?>

                <?php
                $modArrayPur = ['Email_send'];
                $menuAccessPur = all_menu_permission_check($modArrayPur, $adRoleId);
                if ($menuAccessPur == true) { ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('email_send'); ?>" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Email Send
                            </p>
                        </a>
                    </li>
                <?php } ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>