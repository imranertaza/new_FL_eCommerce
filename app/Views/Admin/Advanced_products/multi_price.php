<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Multi price edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Multi price edit</li>
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
                        <h3 class="card-title">Multi price edit</h3><br>

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


                <form id="optionForm" action="<?php echo base_url('bulk_product_multi_price_action') ?>" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Price</h4>
                    </div>
                    <div class="modal-body" >
                        <?php foreach ($all_product as $val){ ?>
                            <input type="hidden" name="productId[]" value="<?php echo $val;?>" >
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="price" required >
                            </div>


                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit"  class="btn btn-primary">Save changes</button>
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