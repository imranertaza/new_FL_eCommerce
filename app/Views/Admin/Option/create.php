<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Option Add</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active">Option Add</li>
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
                        <h3 class="card-title">Option Add</h3>
                    </div>
                    <div class="col-md-4"> </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url('option_create_action')?>" method="post" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Option name" required>
                            </div>

                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" class="form-control" required>
                                    <option value="">Please select</option>
                                    <option value="select">Select</option>
<!--                                    <option value="checkbox">Checkbox</option>-->
                                    <option value="radio">Radio</option>
                                </select>
                            </div>

                            <button class="btn btn-primary" >Add</button>
                            <a href="<?php echo base_url('option')?>" class="btn btn-danger" >Back</a>
                        </div>
                        <div class="col-md-6" style="padding-top: 16px;">
                            <div id="new_chq">
                                <div class="form-group mt-3" id="new_1"><input type="text" class="form-control" placeholder="value" name="value[]" style="width: 70%;float: left;" required> <a href="javascript:void(0)" onclick="remove_option_new(this)" class="btn btn-sm btn-danger" style="margin-left: 5px;padding: 7px;">X</a></div>
                            </div>
                            <input type="hidden" value="1" id="total_chq">


                            <div class="col-md-12 mt-3">
                                <a href="javascript:void(0)" onclick="add_option_new();" class="btn btn-sm btn-primary">Add Value</a>
                            </div>
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
</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
<script>
    //option
    function add_option_new() {
        <?php $dat = getListInOption('', 'attribute_group_id', 'name', 'cc_product_attribute_group'); ?>
        var data = '<?php print $dat; ?>';

        var new_chq_no = parseInt($('#total_chq').val()) + 1;
        var new_input = "<div class='form-group mt-3' id='new_" + new_chq_no +
            "' ><input type='text' class='form-control'  placeholder='value' name='value[]' style='width: 70%;float: left;'> <a href='javascript:void(0)' onclick='remove_option_new(this)' class='btn btn-sm btn-danger' style='margin-left: 5px;padding: 7px;'>X</a></div>";

        $('#new_chq').append(new_input);
        $('#total_chq').val(new_chq_no);
    }

    function remove_option_new(data, id) {
        $(data).parent().remove();
    }
</script>
<?= $this->endSection() ?>