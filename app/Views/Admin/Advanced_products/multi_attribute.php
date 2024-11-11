<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Multi attribute edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Multi attribute edit</li>
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
                        <h3 class="card-title">Multi attribute edit</h3><br>

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


                <form id="optionForm" action="<?php echo base_url('bulk_multi_attribute_action') ?>" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Attribute</h4>
                    </div>
                    <div class="modal-body" >
                        <?php foreach ($all_product as $val){ ?>
                            <input type="hidden" name="productId[]" value="<?php echo $val;?>" >
                        <?php } ?>

                        <div class="row">

                            <div id="new_att"></div>
                            <input type="hidden" value="1" id="total_att">

                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6 mt-2">
                                <a href="javascript:void(0)" onclick="add_attribute();"
                                   class="btn btn-sm btn-primary">Add attribute</a>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" onclick="check_required_attribute()" class="btn btn-primary">Save changes</button>
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
    //attribute
    function add_attribute() {
        <?php $dat = getListInOption('', 'attribute_group_id', 'name', 'cc_product_attribute_group'); ?>
        var data = '<?php print $dat; ?>';

        var new_chq_no = parseInt($('#total_att').val()) + 1;
        var new_input = "<div class='col-md-12 mt-3' id='new_" + new_chq_no +
            "' ><select name='attribute_group_id[]'  style='padding: 3px; text-transform: capitalize;' required><option value=''>Please select</option>" +
            data +
            "</select> <input type='text' placeholder='Name' name='name[]' required> <input type='text' placeholder='Details' name='details[]'> <a href='javascript:void(0)' onclick='remove_attribute(this)' class='btn btn-sm btn-danger' style='margin-top: -5px;'>X</a></div>";

        $('#new_att').append(new_input);
        $('#total_att').val(new_chq_no);
    }

    function remove_attribute(data) {
        $(data).parent().remove();
    }
</script>
<?= $this->endSection() ?>