<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Slider Schedule Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active">Slider Schedule Create</li>
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
                            <h3 class="card-title">Slider Schedule Create</h3>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= base_url('slider_section')?>" class="btn btn-danger btn-sm float-right" > Back</a>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('slider_section_create_action')?>" method="post" enctype="multipart/form-data" >
                        <?= csrf_field() ?>
                        <div id="schedule-wrapper">
                            <div class="schedule-row row mb-3 border p-3 rounded">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Schedule Title <span class="requi">*</span></label>
                                        <input type="text" name="schedule_title" placeholder="Schedule Title" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6" >

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Slider 1 Image <span class="requi">*</span></label>
                                        <input type="file" name="slider_image[]" class="form-control" required>
                                        <small>Recommended Size: <?= $theme_libraries->slider_width; ?> x <?= $theme_libraries->slider_height; ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label>Slider 2 Image <span class="requi">*</span></label>
                                        <input type="file" name="slider_image[]" class="form-control" required>
                                        <small>Recommended Size: <?= $theme_libraries->slider_width; ?> x <?= $theme_libraries->slider_height; ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label>Slider 3 Image <span class="requi">*</span></label>
                                        <input type="file" name="slider_image[]" class="form-control" required>
                                        <small>Recommended Size: <?= $theme_libraries->slider_width; ?> x <?= $theme_libraries->slider_height; ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label>Slider 4 Image <span class="requi">*</span></label>
                                        <input type="file" name="slider_image[]" class="form-control" required>
                                        <small>Recommended Size: <?= $theme_libraries->slider_width; ?> x <?= $theme_libraries->slider_height; ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label>Slider 5 Image <span class="requi">*</span></label>
                                        <input type="file" name="slider_image[]" class="form-control" required>
                                        <small>Recommended Size: <?= $theme_libraries->slider_width; ?> x <?= $theme_libraries->slider_height; ?></small>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Alt Name <span class="requi">*</span></label>
                                        <input type="text" name="alt_name[]" class="form-control" placeholder="Alt Name" required>
                                        <small>&nbsp;</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Alt Name <span class="requi">*</span></label>
                                        <input type="text" name="alt_name[]" class="form-control" placeholder="Alt Name" required>
                                        <small>&nbsp;</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Alt Name <span class="requi">*</span></label>
                                        <input type="text" name="alt_name[]" class="form-control" placeholder="Alt Name" required>
                                        <small>&nbsp;</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Alt Name <span class="requi">*</span></label>
                                        <input type="text" name="alt_name[]" class="form-control" placeholder="Alt Name" required>
                                        <small>&nbsp;</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Alt Name <span class="requi">*</span></label>
                                        <input type="text" name="alt_name[]" class="form-control" placeholder="Alt Name" required>
                                        <small>&nbsp;</small>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Date <span class="requi">*</span></label>
                                        <input type="date" name="start_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>End Date <span class="requi">*</span></label>
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button class="btn btn-success w-100">Insert</button>
                        </div>
                    </form>
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