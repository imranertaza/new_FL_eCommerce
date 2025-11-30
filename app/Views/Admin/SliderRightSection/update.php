<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Right Banner Schedule Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active">Right Banner Schedule Update</li>
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
                            <h3 class="card-title">Right Banner Schedule Update</h3>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= base_url('slider_right_section')?>" class="btn btn-danger btn-sm float-right">Back</a>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('slider_right_section_update_action')?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div id="schedule-wrapper">
                            <div class="schedule-row row mb-3 border p-3 rounded">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Schedule Title <span class="requi">*</span></label>
                                        <input type="text" name="schedule_title" value="<?= $schedule->schedule_title;?>" placeholder="Schedule Title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6" >

                                </div>
                                <div class="col-md-12 p-3 row border">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title Top <span class="requi">*</span></label>
                                            <input type="text" name="title_top" class="form-control" value="<?= $schedule_image_top->title;?>" placeholder="Title" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Banner Top <span class="requi">*</span></label>
                                            <input type="file" name="banner_top" class="form-control" >
                                            <small>Recommended Size: 228 x 199</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Alt Name <span class="requi">*</span></label>
                                            <input type="text" name="alt_name_top" class="form-control" value="<?= $schedule_image_top->alt_name;?>" placeholder="Alt Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 formRow">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="typeEvent(this,'')" <?= !empty($schedule_image_top->url)?'checked':'';?>  name="type_top" id="exampleRadios1" value="url" >
                                                <label class="form-check-label" for="exampleRadios1">Url</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="typeEvent(this,'')" <?= !empty($schedule_image_top->prod_cat_id)?'checked':'';?> name="type_top" id="exampleRadios3" value="category">
                                                <label class="form-check-label" for="exampleRadios3">Category</label>
                                            </div>
                                        </div>
                                        <div class="form-group" id="url" style="<?= empty($schedule_image_top->url)?'display: none':'';?>">
                                            <label>Url <span class="requi">*</span></label>
                                            <input type="text" name="url_top" class="form-control" value="<?= $schedule_image_top->url;?>"  placeholder="Url" >
                                        </div>

                                        <div class="form-group " id="category" style="<?= empty($schedule_image_top->prod_cat_id)?'display: none':'';?>" >
                                            <label>Category <span class="requi">*</span></label>
                                            <select name="prod_cat_id_top" class="form-control" >
                                                <option value=""> Please Select</option>
                                                <?php foreach (get_array_data_by_id('cc_product_category', 'status', '1') as $cat) { ?>
                                                    <option value="<?php echo $cat->prod_cat_id; ?>" <?= ($schedule_image_top->prod_cat_id == $cat->prod_cat_id)?'selected':'';?> ><?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group" >
                                            <?= image_view('uploads/top_side_baner', '', $schedule_image_top->image, 'noimage.png', 'w-25');?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 p-3  mt-3 row border">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title Bottom <span class="requi">*</span></label>
                                            <input type="text" name="title_bottom" class="form-control" value="<?= $schedule_image_bottom->title;?>" placeholder="Title" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Banner Bottom <span class="requi">*</span></label>
                                            <input type="file" name="banner_bottom" class="form-control" >
                                            <small>Recommended Size: 228 x 199</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Alt Name <span class="requi">*</span></label>
                                            <input type="text" name="alt_name_bottom" class="form-control" value="<?= $schedule_image_bottom->alt_name;?>" placeholder="Alt Name" required>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="typeEvent(this,'2')"  name="type_bottom" id="exampleRadios4" value="url" <?= !empty($schedule_image_bottom->url)?'checked':'';?>>
                                                <label class="form-check-label" for="exampleRadios4">Url</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="typeEvent(this,'2')" name="type_bottom" id="exampleRadios5" value="category" <?= !empty($schedule_image_bottom->prod_cat_id)?'checked':'';?>>
                                                <label class="form-check-label" for="exampleRadios5">Category</label>
                                            </div>
                                        </div>
                                        <div class="form-group" id="url2" style="<?= empty($schedule_image_bottom->url)?'display: none':'';?>">
                                            <label>Url <span class="requi">*</span></label>
                                            <input type="text" name="url_bottom" class="form-control" placeholder="Url" value="<?= $schedule_image_bottom->url;?>" >
                                        </div>

                                        <div class="form-group " id="category2" style="<?= empty($schedule_image_bottom->prod_cat_id)?'display: none':'';?>" >
                                            <label>Category <span class="requi">*</span></label>
                                            <select name="prod_cat_id_bottom" class="form-control" >
                                                <option value=""> Please Select</option>
                                                <?php foreach (get_array_data_by_id('cc_product_category', 'status', '1') as $cat) { ?>
                                                    <option value="<?php echo $cat->prod_cat_id; ?>" <?= ($schedule_image_bottom->prod_cat_id == $cat->prod_cat_id)?'selected':'';?>><?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group" >
                                            <?= image_view('uploads/top_side_baner', '', $schedule_image_bottom->image, 'noimage.png', 'w-25');?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Date <span class="requi">*</span></label>
                                        <input type="date" name="start_date" value="<?= date('Y-m-d', strtotime($schedule->start_date)); ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>End Date <span class="requi">*</span></label>
                                    <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime($schedule->end_date)); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <input type="hidden" name="banner_side_schedule_id_top" value="<?= $schedule_image_top->banner_side_schedule_image_id; ?>">
                            <input type="hidden" name="banner_side_schedule_id_bottom" value="<?= $schedule_image_bottom->banner_side_schedule_image_id; ?>">
                            <input type="hidden" name="banner_side_schedule_id" value="<?= $schedule->banner_side_schedule_id; ?>">
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
    <script>
        function typeEvent(el,suk) {
            let value = $(el).val();

            // Hide all first
            $('#url'+suk).hide();
            $('#category'+suk).hide();

            // Show correct section
            if (value === 'url') {
                $('#url'+suk).show();
            } else if (value === 'category') {
                $('#category'+suk).show();
            }
        }
    </script>
<?= $this->endSection() ?>