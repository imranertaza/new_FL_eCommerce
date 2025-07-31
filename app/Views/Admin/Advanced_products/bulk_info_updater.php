<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bulk Info Updater</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Bulk Info Updater List</li>
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
                        <div class="col-md-2">
                            <h3 class="card-title">Bulk Info Updater</h3><br>

                        </div>
                        <div class="col-md-10">
                            <?php $redirect_url = isset($_COOKIE['bulk_url_path']) ? $_COOKIE['bulk_url_path'] : '';?>
                            <a href="<?php echo base_url($redirect_url); ?>" class="btn btn-danger float-right mr-2 btn-xs" >Back</a>
                        </div>
                        <div class="col-md-12" id="message" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('bulk_info_updater_action')?>" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-responsive table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Weight</th>
                                        <th>Description</th>
                                        <th>Meta Title</th>
                                        <th>Meta Description</th>
                                        <th>Meta Keyword</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;

                                    foreach ($products as $val) { ?>
                                        <tr>
                                            <td width="40"><?php echo $i++;?></td>
                                            <td><?php echo product_image_view('uploads/products', $val->product_id, $val->image, 'noimage.png', 'img-fluid', '', '', '50', '50') ?></td>
                                            <td width="150">
                                                <?php echo $val->name; ?>
                                                <input type="hidden" name="product_id[]" value="<?php echo $val->product_id; ?>">
                                            </td>
                                            <td><textarea  name="weight[]"  cols="5" rows="1"><?php echo $val->weight; ?></textarea></td>
                                            <td><textarea  name="description[]"  rows="6" > <?php echo $val->description; ?></textarea></td>
                                            <td><textarea  name="meta_title[]" rows="6" ><?php echo $val->meta_title; ?></textarea></td>
                                            <td><textarea  name="meta_description[]" rows="6" ><?php echo $val->meta_description; ?></textarea></td>
                                            <td><textarea  name="meta_keyword[]" rows="6" ><?php echo $val->meta_keyword; ?></textarea></td>
                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Weight</th>
                                        <th>Description</th>
                                        <th>Meta Title</th>
                                        <th>Meta Description</th>
                                        <th>Meta Keyword</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="col-md-12 mt-5 text-center">
                                <button class="btn btn-success" style="width: 300px;">Update</button>
                            </div>
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
    <!-- /.category modal -->



</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
<script>
    function allchecked(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }
</script>
<?= $this->endSection() ?>