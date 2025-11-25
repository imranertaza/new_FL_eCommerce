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

                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('slider_section_create_action')?>" method="post" enctype="multipart/form-data" >
                        <div id="schedule-wrapper">
                            <div class="schedule-row row mb-3 border p-3 rounded">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Schedule Title <span class="requi">*</span></label>
                                        <input type="text" name="schedule_title[]" placeholder="Schedule Title" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6" >
                                    <button type="button" class="btn btn-danger remove-row float-end " style="float: right;">x</button>
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
                                        <input type="date" name="start_date[]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>End Date <span class="requi">*</span></label>
                                    <input type="date" name="end_date[]" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button class="btn btn-success w-100">Update</button>
                        </div>
                    </form>
                    <div class="col-md-12 mt-3 text-center">
                        <button type="button" class="btn btn-default" id="add-row"> Add Schedule <br>
                            <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38" fill="none">
                                <path d="M18.9993 6.33341C25.9834 6.33341 31.666 12.016 31.666 19.0001C31.666 25.9842 25.9834 31.6667 18.9993 31.6667C12.0153 31.6667 6.33268 25.9842 6.33268 19.0001C6.33268 12.016 12.0153 6.33341 18.9993 6.33341ZM18.9993 3.16675C10.2546 3.16675 3.16602 10.2553 3.16602 19.0001C3.16602 27.7448 10.2546 34.8334 18.9993 34.8334C27.7441 34.8334 34.8327 27.7448 34.8327 19.0001C34.8327 10.2553 27.7441 3.16675 18.9993 3.16675ZM26.916 17.4167H20.5827V11.0834H17.416V17.4167H11.0827V20.5834H17.416V26.9167H20.5827V20.5834H26.916V17.4167Z" fill="black"/>
                            </svg>
                        </button>
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
        $(document).ready(function(){
            // Add new schedule row
            $('#add-row').click(function(){
                let newRow = $('.schedule-row:first').clone();
                newRow.find('input').val(''); // clear input values
                $('#schedule-wrapper').append(newRow);
            });

            // Remove schedule row
            $(document).on('click', '.remove-row', function(){
                if ($('.schedule-row').length > 1) {
                    $(this).closest('.schedule-row').remove();
                } else {
                    alert('You must keep at least one schedule.');
                }
            });
        });
    </script>
<?= $this->endSection() ?>