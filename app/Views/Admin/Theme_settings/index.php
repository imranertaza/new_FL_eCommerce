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
                                            <div class="form-group mt-5">
                                                <?php
                                                $sli_1 = get_lebel_by_value_in_theme_settings('slider_1');
                                                echo image_view('uploads/slider', '', $sli_1, 'noimage.png', 'width-full-100');
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Slider 1</label>
                                                <input type="file" name="slider" class="form-control" required>
                                                <input type="hidden" name="nameslider" class="form-control"
                                                       value="slider_1" required>
                                                       <small>Size: <?php echo $theme_libraries->slider_width; ?> x <?php echo $theme_libraries->slider_height; ?></small>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>



                                        <form action="<?php echo base_url('slider_update') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <div class="form-group mt-5">
                                                <?php
                                                $sli_3 = get_lebel_by_value_in_theme_settings('slider_3');
                                                echo image_view('uploads/slider', '', $sli_3, 'noimage.png', 'width-full-100');
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Slider 3</label>
                                                <input type="file" name="slider" class="form-control" required>
                                                <input type="hidden" name="nameslider" class="form-control"
                                                       value="slider_3" required>
                                                <small>Size: <?php echo $theme_libraries->slider_width; ?> x <?php echo $theme_libraries->slider_height; ?></small>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="<?php echo base_url('slider_update') ?>" method="post"
                                              enctype="multipart/form-data">
                                            <div class="form-group mt-5">
                                                <?php
                                                $sli_2 = get_lebel_by_value_in_theme_settings('slider_2');
                                                echo image_view('uploads/slider', '', $sli_2, 'noimage.png', 'width-full-100');
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Slider 2</label>
                                                <input type="file" name="slider" class="form-control" required>
                                                <input type="hidden" name="nameslider" class="form-control"
                                                       value="slider_2" required>
                                                <small>Size: <?php echo $theme_libraries->slider_width; ?> x <?php echo $theme_libraries->slider_height; ?></small>
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
                                            <div class="form-group mt-5">
                                                <?php
                                                $side_logo = get_lebel_by_value_in_theme_settings('side_logo');
                                                echo image_view('uploads/logo', '', $side_logo, 'noimage.png', '');
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Logo</label>
                                                <input type="file" name="side_logo" class="form-control" required>
                                                <small>Size: <?php echo $theme_libraries->logo_width; ?> x <?php echo $theme_libraries->logo_height; ?></small>
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