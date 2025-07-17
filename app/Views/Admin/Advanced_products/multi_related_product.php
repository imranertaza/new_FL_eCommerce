<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Multi Related Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Multi Related Product List</li>
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
                            <h3 class="card-title">Multi Related Product</h3><br>

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
                    <form action="<?php echo base_url('multi_related_product_action')?>" method="post">
                        <div class="row">
                            <div class="col-md-6" style="border: 1px solid #dfdfdf;padding: 10px;">
                                <div class="form-group text-center" style="background-color: #bfbfbf;">
                                    <label>Product With</label>
                                </div>
                                <table id="example1" class="table">
                                    <thead>
                                        <tr>
                                            <th width="20">Box
<!--                                                <input type="checkbox" onclick="allchecked(this)" >-->
                                            </th>
                                            <th width="60">Image</th>
                                            <th>Name</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($products as $product){ ?>
                                        <tr>
                                            <td><input type="checkbox" name="productIdRelated[]" value="<?php echo $product->product_id;?>" ></td>
                                            <td><?php echo product_image_view('uploads/products', $product->product_id, $product->image, 'noimage.png', 'img-fluid', '', '', '50', '50') ?></td>
                                            <td><?php echo $product->name;?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
<!--                            <div class="col-md-2" ></div>-->
                            <div class="col-md-6" style="border: 1px solid #dfdfdf;padding: 10px;">
                                <div class="form-group text-center" style="background-color: #dfdfdf;">
                                    <label>Products To</label>
                                </div>
                                <table id="dataTable1" class="table">
                                    <thead>
                                    <tr>
                                        <th width="20">Box</th>
                                        <th width="60">Image</th>
                                        <th>Name</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($products as $product){ ?>
                                        <tr>
                                            <td><input type="checkbox" name="productId[]" value="<?php echo $product->product_id;?>" ></td>
                                            <td><?php echo product_image_view('uploads/products', $product->product_id, $product->image, 'noimage.png', 'img-fluid', '', '', '50', '50') ?></td>
                                            <td><?php echo $product->name;?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                            <div class="col-md-12 mt-5 text-center">
                                <button class="btn btn-success" style="width: 300px;">Add</button>
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