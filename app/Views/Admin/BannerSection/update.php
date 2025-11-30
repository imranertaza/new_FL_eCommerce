<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Banner Schedule Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active">Banner Schedule Update</li>
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
                            <h3 class="card-title">Banner Schedule Update</h3>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= base_url('banner_section')?>" class="btn btn-danger btn-sm float-right"> Back</a>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('banner_section_update_action')?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="col-md-12 row mb-3 border p-3 rounded">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Schedule Title <span class="requi">*</span></label>
                                    <input type="text" name="schedule_title" placeholder="Schedule Title" value="<?= $schedule->schedule_title;?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6" >
                            </div>
                        </div>
                        <?php
                            $map = [ 0 => 'top', 1 => 'category', 2 => 'bottom' ];
                            foreach ($scheduleImage as $key => $item){
                                $suk = $map[$key] ?? '';
                        ?>
                        <div class="col-md-12 row mb-3 border p-3 rounded">
                            <div class="col-md-12">
                                <?= image_view('uploads/banner_bottom', '', $item->image, 'noimage.png', 'w-25');?>
                                <input type="hidden" name="banner_schedule_image_id_<?= $suk;?>" value="<?= $item->banner_schedule_image_id;?>" class="form-control" >
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Banner <?= $suk;?> <span class="requi">*</span></label>
                                    <input type="file" name="banner_<?= $suk;?>" class="form-control" >
                                    <small>Recommended Size: 1116 x 211</small>
                                </div>

                                <div class="form-group">
                                    <label>Alt Name <span class="requi">*</span></label>
                                    <input type="text" name="alt_name_<?= $suk;?>" class="form-control" value="<?= $item->alt_name;?>" placeholder="Alt Name" required>
                                    <small>&nbsp;</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onclick="typeEvent(this,'<?=$key?>')"  name="type_<?= $suk;?>" id="exampleRadios4-<?=$key?>" value="url" <?= !empty($item->url)?'checked':'';?>>
                                        <label class="form-check-label" for="exampleRadios4-<?=$key?>">Url</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onclick="typeEvent(this,'<?=$key?>')" name="type_<?= $suk;?>" id="exampleRadios5-<?=$key?>" value="category" <?= !empty($item->prod_cat_id)?'checked':'';?>>
                                        <label class="form-check-label" for="exampleRadios5-<?=$key?>">Category</label>
                                    </div>
                                </div>
                                <div class="form-group" id="url<?=$key?>" style="<?= empty($item->url)?'display: none':'';?>">
                                    <label>Url <span class="requi">*</span></label>
                                    <input type="text" name="url_<?= $suk;?>" class="form-control" placeholder="Url" value="<?= $item->url;?>">
                                </div>

                                <div class="form-group " id="category<?=$key?>" style="<?= empty($item->prod_cat_id)?'display: none':'';?>" >
                                    <label>Category <span class="requi">*</span></label>
                                    <select name="prod_cat_id_<?= $suk;?>" class="form-control" >
                                        <option value=""> Please Select</option>
                                        <?php foreach (get_array_data_by_id('cc_product_category', 'status', '1') as $cat) { ?>
                                            <option value="<?= $cat->prod_cat_id; ?>" <?= ($item->prod_cat_id == $cat->prod_cat_id)?'selected':'';?> ><?= display_category_with_parent($cat->prod_cat_id); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="col-md-12 row mb-3 border p-3 rounded">
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

                        <div class="col-md-12 row mt-3">
                            <input type="hidden" name="banner_schedule_id" value="<?= $schedule->banner_schedule_id;?>" class="form-control" >
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