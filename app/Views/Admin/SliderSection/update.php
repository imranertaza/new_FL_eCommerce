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
                    <form action="<?= base_url('slider_section_update_action')?>" method="post" enctype="multipart/form-data" >
                        <?= csrf_field() ?>
                        <div id="schedule-wrapper">
                            <div class="schedule-row row mb-3 border p-3 rounded">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Schedule Title <span class="requi">*</span></label>
                                        <input type="text" name="schedule_title" placeholder="Schedule Title" class="form-control" value="<?= $schedule->schedule_title;?>">
                                    </div>
                                </div>
                                <div class="col-md-6" >

                                </div>
                                <?php $i=1; foreach ($scheduleImage as $key => $ima){ ?>
                                    <div class="col-md-12 row border">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Slider <?= $i++ ?> Image <span class="requi">*</span></label>
                                                <input type="file" name="slider_image[]" class="form-control" >
                                                <small>Recommended Size: <?= $theme_libraries->slider_width; ?> x <?= $theme_libraries->slider_height; ?></small>
                                            </div>
                                            <div class="form-group">
                                            <label>Alt Name <span class="requi">*</span></label>
                                            <input type="text" name="alt_name[]" class="form-control" value="<?= $ima->alt_name;?>" placeholder="Alt Name" >
                                            <input type="hidden" name="slider_schedule_image_id[]" value="<?= $ima->slider_schedule_image_id;?>">
                                            <small>&nbsp;</small>
                                        </div>
                                        </div>
                                        <div class="col-md-6 p-3">
                                            <div class="form-group">
                                                <?= image_view('uploads/slider', '', $ima->image, 'noimage.png', 'w-50');?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Date <span class="requi">*</span></label>
                                        <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d', strtotime($schedule->start_date)); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>End Date <span class="requi">*</span></label>
                                    <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime($schedule->end_date)); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <input type="hidden" name="slider_schedule_id" value="<?= $schedule->slider_schedule_id;?>">
                            <button class="btn btn-success w-100">Update</button>
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

<?= $this->endSection() ?>