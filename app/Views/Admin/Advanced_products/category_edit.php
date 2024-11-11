<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Multi category edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Multi category edit</li>
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
                        <h3 class="card-title">Multi category edit</h3><br>

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


                <form id="optionForm" action="<?php echo base_url('bulk_multi_category_action') ?>" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Category</h4>
                    </div>
                    <div class="modal-body" >
                        <?php foreach ($all_product as $val){ ?>
                            <input type="hidden" name="productId[]" value="<?php echo $val;?>" >
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6 category">
                                <label>Category <span class="requi">*</span></label>
                                <select class="select2bs4" name="categorys[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" required>
                                    <?php foreach ($prodCat as $cat) { ?>
                                        <option value="<?php echo $cat->prod_cat_id; ?>"><?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit"   class="btn btn-primary">Save changes</button>
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