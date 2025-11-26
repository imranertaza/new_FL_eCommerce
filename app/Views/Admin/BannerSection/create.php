<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Banner Schedule Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active">Banner Schedule Create</li>
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
                            <h3 class="card-title">Banner Schedule Create</h3>
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
                    <form action="<?= base_url('banner_section_create_action')?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="col-md-12 row mb-3 border p-3 rounded">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Schedule Title <span class="requi">*</span></label>
                                    <input type="text" name="schedule_title" placeholder="Schedule Title" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6" >
                            </div>
                        </div>

                        <div class="col-md-12 row mb-3 border p-3 rounded">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Banner Top <span class="requi">*</span></label>
                                    <input type="file" name="banner_top" class="form-control" required>
                                    <small>Recommended Size: 1116 x 211</small>
                                </div>

                                <div class="form-group">
                                    <label>Alt Name <span class="requi">*</span></label>
                                    <input type="text" name="alt_name_top" class="form-control" placeholder="Alt Name" required>
                                    <small>&nbsp;</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onclick="typeEvent(this,'1')"  name="type_top" id="exampleRadios4top" value="url" checked>
                                        <label class="form-check-label" for="exampleRadios4top">Url</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onclick="typeEvent(this,'1')" name="type_top" id="exampleRadios5top" value="category">
                                        <label class="form-check-label" for="exampleRadios5top">Category</label>
                                    </div>
                                </div>
                                <div class="form-group" id="url1">
                                    <label>Url <span class="requi">*</span></label>
                                    <input type="text" name="url_top" class="form-control" placeholder="Url" >
                                </div>

                                <div class="form-group " id="category1" style="display: none;" >
                                    <label>Category <span class="requi">*</span></label>
                                    <select name="prod_cat_id_top" class="form-control" >
                                        <option value=""> Please Select</option>
                                        <?php foreach (get_array_data_by_id('cc_product_category', 'status', '1') as $cat) { ?>
                                            <option value="<?php echo $cat->prod_cat_id; ?>"><?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row mb-3 border p-3 rounded">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Banner Featured Category <span class="requi">*</span></label>
                                    <input type="file" name="banner_category" class="form-control" required>
                                    <small>Recommended Size: 1116 x 211</small>
                                </div>
                                <div class="form-group">
                                    <label>Alt Name <span class="requi">*</span></label>
                                    <input type="text" name="alt_name_category" class="form-control" placeholder="Alt Name" required>
                                    <small>&nbsp;</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onclick="typeEvent(this,'2')"  name="type_category" id="exampleRadios4category" value="url" checked>
                                        <label class="form-check-label" for="exampleRadios4category">Url</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onclick="typeEvent(this,'2')" name="type_category" id="exampleRadios5category" value="category">
                                        <label class="form-check-label" for="exampleRadios5category">Category</label>
                                    </div>
                                </div>
                                <div class="form-group" id="url2">
                                    <label>Url <span class="requi">*</span></label>
                                    <input type="text" name="url_category" class="form-control" placeholder="Url" >
                                </div>

                                <div class="form-group " id="category2" style="display: none;" >
                                    <label>Category <span class="requi">*</span></label>
                                    <select name="prod_cat_id_category" class="form-control" >
                                        <option value=""> Please Select</option>
                                        <?php foreach (get_array_data_by_id('cc_product_category', 'status', '1') as $cat) { ?>
                                            <option value="<?php echo $cat->prod_cat_id; ?>"><?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row mb-3 border p-3 rounded">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Banner Bottom <span class="requi">*</span></label>
                                    <input type="file" name="banner_bottom" class="form-control" required>
                                    <small>Recommended Size: 1116 x 422</small>
                                </div>
                                <div class="form-group">
                                    <label>Alt Name <span class="requi">*</span></label>
                                    <input type="text" name="alt_name_bottom" class="form-control" placeholder="Alt Name" required>
                                    <small>&nbsp;</small>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onclick="typeEvent(this,'3')"  name="type_bottom" id="exampleRadios4bottom" value="url" checked>
                                        <label class="form-check-label" for="exampleRadios4bottom">Url</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onclick="typeEvent(this,'3')" name="type_bottom" id="exampleRadios5bottom" value="category">
                                        <label class="form-check-label" for="exampleRadios5bottom">Category</label>
                                    </div>
                                </div>
                                <div class="form-group" id="url3">
                                    <label>Url <span class="requi">*</span></label>
                                    <input type="text" name="url_bottom" class="form-control" placeholder="Url" >
                                </div>

                                <div class="form-group " id="category3" style="display: none;" >
                                    <label>Category <span class="requi">*</span></label>
                                    <select name="prod_cat_id_bottom" class="form-control" >
                                        <option value=""> Please Select</option>
                                        <?php foreach (get_array_data_by_id('cc_product_category', 'status', '1') as $cat) { ?>
                                            <option value="<?php echo $cat->prod_cat_id; ?>"><?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row mb-3 border p-3 rounded">
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

                        <div class="col-md-12 row mt-3">
                            <button class="btn btn-success w-100">Create</button>
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