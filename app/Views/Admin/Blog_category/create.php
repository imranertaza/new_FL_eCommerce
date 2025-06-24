<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Blog Category create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active"> Blog Category create</li>
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
                        <h3 class="card-title"> Blog Category create</h3>
                    </div>
                    <div class="col-md-4">
                        <!--                        <a href="--><?php //echo base_url('Admin/Brand')
                                                                ?>
                        <!--" class="btn btn-primary btn-block ">Add</a>-->
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <?php if (session()->getFlashdata('message') !== null) : echo session()->getFlashdata('message');
                        endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url('blog_category_create_action') ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="category_name" class="form-control" placeholder="Category name"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Main Category</label>
                                <select name="parent_id" class="form-control text-capitalize select2bs4">
                                    <option value="">Please select</option>
                                    <?php foreach ($category as $cat) { ?>
                                    <option value="<?php echo $cat->cat_id ?>">
                                        <?php echo display_blog_category_with_parent($cat->cat_id);?>
                                    </option>
                                    <?php } ?>
                                </select>

                            </div>

                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control" placeholder="image">
                            </div>

                            <div class="form-group">
                                <label>Icon</label>
                                <?php $icons = get_all_data_array('cc_icons'); ?>
                                <div class="row">
                                    <?php $i = 1;
$j                                           = 1;

foreach ($icons as $valic) { ?>
                                    <div class="col-md-2  custom-control custom-radio">
                                        <input class="custom-control-input" type="radio"
                                            id="customRadio_<?php echo $i++ ?>" name="icon_id"
                                            value="<?php echo $valic->icon_id; ?>">
                                        <label for="customRadio_<?php echo $j++ ?>"
                                            class="custom-control-label"><?php echo $valic->code; ?></label>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>

                            <button class="btn btn-primary">Create</button>
                            <a href="<?php echo base_url('blog_category') ?>" class="btn btn-danger">Back</a>
                        </div>
                        <div class="col-md-6"></div>
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
