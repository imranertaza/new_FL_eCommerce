<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Theme Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Theme Settings</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title">Theme Settings</h3>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>

            <div class="card-body" >
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php echo ((isset($_GET['sel']) && $_GET['sel']=='slider') || !isset($_GET['sel']))?'active':''; ?>" id="custom-tabs-four-home-tab" data-toggle="pill"
                                   href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                   aria-selected="true">Slider</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php echo (isset($_GET['sel']) && $_GET['sel']=='logo')?'active':''; ?>" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                   href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                                   aria-selected="false">Logo</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php echo (isset($_GET['sel']) && $_GET['sel']=='home_settings')?'active':''; ?>" id="custom-tabs-four-messages-tab" data-toggle="pill"
                                   href="#custom-tabs-four-messages" role="tab"
                                   aria-controls="custom-tabs-four-messages" aria-selected="false">Home Page Settings</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?php echo (isset($_GET['sel']) && $_GET['sel']=='others_settings')?'active':''; ?>" id="custom-tabs-five-others-tab" data-toggle="pill"
                                   href="#custom-tabs-others-tab" role="tab"
                                   aria-controls="custom-tabs-others-tab" aria-selected="false">Others Page Settings</a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade <?php echo ((isset($_GET['sel']) && $_GET['sel']=='slider') || !isset($_GET['sel']))?'active show':''; ?>" id="custom-tabs-four-home" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="<?php echo base_url('slider_update') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="form-group mt-5">
                                                <?php
                                                $sli_1 = get_lebel_by_value_in_theme_settings('slider_1');
                                                echo image_view('uploads/slider', '', $sli_1->value, 'noimage.png', 'width-full-100');
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Slider 1</label>
                                                <input type="file" name="slider" class="form-control" >
                                                <input type="hidden" name="nameslider" class="form-control"
                                                       value="slider_1" >
                                                       <small>Recommended Size: <?php echo $theme_libraries->slider_width; ?> x <?php echo $theme_libraries->slider_height; ?></small>
                                            </div>

                                            <div class="form-group">
                                                <label>ALT Name</label>
                                                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $sli_1->alt_name; ?>" >
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>



                                        <form action="<?php echo base_url('slider_update') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="form-group mt-5">
                                                <?php
                                                $sli_3 = get_lebel_by_value_in_theme_settings('slider_3');
                                                echo image_view('uploads/slider', '', $sli_3->value, 'noimage.png', 'width-full-100');
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Slider 3</label>
                                                <input type="file" name="slider" class="form-control" >
                                                <input type="hidden" name="nameslider" class="form-control"
                                                       value="slider_3" >
                                                <small>Recommended Size: <?php echo $theme_libraries->slider_width; ?> x <?php echo $theme_libraries->slider_height; ?></small>

                                            </div>
                                            <div class="form-group">
                                                <label>ALT Name</label>
                                                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $sli_3->alt_name; ?>" >
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="<?php echo base_url('slider_update') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="form-group mt-5">
                                                <?php
                                                $sli_2 = get_lebel_by_value_in_theme_settings('slider_2');
                                                echo image_view('uploads/slider', '', $sli_2->value, 'noimage.png', 'width-full-100');
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Slider 2</label>
                                                <input type="file" name="slider" class="form-control" >
                                                <input type="hidden" name="nameslider" class="form-control"
                                                       value="slider_2" >
                                                <small>Recommended Size: <?php echo $theme_libraries->slider_width; ?> x <?php echo $theme_libraries->slider_height; ?></small>

                                            </div>
                                            <div class="form-group">
                                                <label>ALT Name</label>
                                                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $sli_2->alt_name; ?>" >
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>

                                        <form action="<?php echo base_url('slider_update') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="form-group mt-5">
                                                <?php
                                                $sli_4 = get_lebel_by_value_in_theme_settings('slider_4');
                                                echo image_view('uploads/slider', '', $sli_4->value, 'noimage.png', 'width-full-100');
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Slider 4</label>
                                                <input type="file" name="slider" class="form-control" >
                                                <input type="hidden" name="nameslider" class="form-control"
                                                       value="slider_4" >
                                                <small>Recommended Size: <?php echo $theme_libraries->slider_width; ?> x <?php echo $theme_libraries->slider_height; ?></small>

                                            </div>

                                            <div class="form-group">
                                                <label>ALT Name</label>
                                                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $sli_4->alt_name; ?>" >
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>

                                    <div class="col-md-6">
                                        <form action="<?php echo base_url('slider_update') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="form-group mt-5">
                                                <?php
                                                $sli_5 = get_lebel_by_value_in_theme_settings('slider_5');
                                                echo image_view('uploads/slider', '', $sli_5->value, 'noimage.png', 'width-full-100');
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Slider 5</label>
                                                <input type="file" name="slider" class="form-control" >
                                                <input type="hidden" name="nameslider" class="form-control"
                                                       value="slider_5" >
                                                <small>Recommended Size: <?php echo $theme_libraries->slider_width; ?> x <?php echo $theme_libraries->slider_height; ?></small>

                                            </div>
                                            <div class="form-group">
                                                <label>ALT Name</label>
                                                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $sli_5->alt_name; ?>" >
                                            </div>

                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>

                                </div>

                            </div>
                            <div class="tab-pane fade <?php echo (isset($_GET['sel']) && $_GET['sel']=='logo')?'active show':''; ?>" id="custom-tabs-four-profile" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-profile-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="<?php echo base_url('logo_update') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="form-group mt-5">
                                                <?php
                                                $side_logo = get_lebel_by_value_in_theme_settings('side_logo');
                                                echo image_view('uploads/logo', '', $side_logo->value, 'noimage.png', '');
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Logo</label>
                                                <input type="file" name="side_logo" class="form-control" >
                                                <small>Recommended Size: <?php echo $theme_libraries->logo_width; ?> x <?php echo $theme_libraries->logo_height; ?></small>

                                            </div>
                                            <div class="form-group">
                                                <label>ALT Name</label>
                                                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $side_logo->alt_name; ?>" >
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>

                                    <div class="col-md-6">
                                        <form action="<?php echo base_url('favicon_update') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="form-group mt-5">
                                                <?php
                                                $favicon = get_lebel_by_value_in_theme_settings('favicon');
                                                echo image_view('uploads/logo', '', $favicon->value, 'noimage.png', '');
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Favicon</label>
                                                <input type="file" name="favicon" class="form-control" required>
                                                <small>Recommended Size: 80 x 80</small>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>                           

                            <div class="tab-pane fade <?php echo (isset($_GET['sel']) && $_GET['sel']=='home_settings')?'active show':''; ?>" id="custom-tabs-four-messages" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-messages-tab">
                                <?php echo $theme_view;?>
                            </div>
                            <div class="tab-pane fade <?php echo (isset($_GET['sel']) && $_GET['sel']=='others_settings')?'active show':''; ?>" id="custom-tabs-others-tab" role="tabpanel"
                                 aria-labelledby="custom-tabs-others-tab">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h2>Contact Us Page </h2>
                                    </div>
                                    <?php
                                    $themeSetting = get_theme_settings();
                                    $themeSettingTitle = get_theme_title_settings();
                                    ?>
                                    <div class="col-md-6 mt-4">
                                        <form action="<?php echo base_url('banner-top-contact') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="form-group">
                                                <?php
                                                $head_side_baner_1 = $themeSetting['banner_top_contact']['value'];
                                                echo image_view('uploads/banner_contact', '', $head_side_baner_1, 'noimage.png', 'w-100');
                                                ?><br>
                                                <label><?php echo $themeSettingTitle['banner_top_contact'];?></label>
                                                <input type="file" class="form-control" name="banner_top_contact">
                                                <span>Recommended Size: 1351 x 255</span>
                                            </div>

                                            <div class="form-group">
                                                <label>ALT Name</label>
                                                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['banner_top_contact']['alt_name']; ?>" >
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <form action="<?php echo base_url('banner-right-contact') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="form-group">
                                                <?php
                                                $head_side_baner_1 = $themeSetting['banner_right_contact']['value'];
                                                echo image_view('uploads/banner_contact', '', $head_side_baner_1, 'noimage.png', 'w-100');
                                                ?><br>
                                                <label><?php echo $themeSettingTitle['banner_right_contact'];?></label>
                                                <input type="file" class="form-control" name="banner_right_contact">
                                                <span>Recommended Size: 1351 x 255</span>
                                            </div>

                                            <div class="form-group">
                                                <label>ALT Name</label>
                                                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['banner_right_contact']['alt_name']; ?>" >
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <form action="<?php echo base_url('banner-bottom-contact') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <?= csrf_field() ?>
                                            <div class="form-group">
                                                <?php
                                                $head_side_baner_1 = $themeSetting['banner_bottom_contact']['value'];
                                                echo image_view('uploads/banner_contact', '', $head_side_baner_1, 'noimage.png', 'w-100');
                                                ?><br>
                                                <label><?php echo $themeSettingTitle['banner_bottom_contact'];?></label>
                                                <input type="file" class="form-control" name="banner_bottom_contact">
                                                <span>Recommended Size: 1116x311</span>
                                            </div>

                                            <div class="form-group">
                                                <label>ALT Name</label>
                                                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['banner_bottom_contact']['alt_name']; ?>" >
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            

                            
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
    <script>

    </script>
<?= $this->endSection() ?>