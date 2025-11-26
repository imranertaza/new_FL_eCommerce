<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Status Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active">Status Update</li>
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
                        <div class="col-md-4">
                            <h3 class="card-title">Status Update</h3><br>

                        </div>
                        <div class="col-md-8"> </div>
                        <div class="col-md-12" id="message" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message');
                            endif; ?>
                            <span id="mess" style="display: none"><div class="alert alert-success alert-dismissible" role="alert">Update Successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">


                    <form  action="<?php echo base_url('product_status_update_action') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-header">
                            <h4 class="modal-title">Status Update</h4>
                        </div>
                        <div class="modal-body" >
                            <?php foreach ($all_product as $val){ ?>
                                <input type="hidden" name="productId[]" value="<?php echo $val;?>" >
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status <span class="requi">*</span></label>
                                        <select class="form-control" name="status" required>
                                            <option value="">Please select</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>


                            </div>

                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <a href="<?php echo base_url(isset($_COOKIE['product_url_path']) ? $_COOKIE['product_url_path'] : 'admin/products'); ?>"  class="btn btn-danger">Back</a>
                        </div>
                    </form>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                </div>
                <!-- /.card-footer-->
            </div>
        </section>
        <!-- /.content -->



    </div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
    <script>


    </script>
<?= $this->endSection() ?>