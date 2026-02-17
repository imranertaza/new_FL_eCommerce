<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Multi option edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Multi option edit</li>
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
                        <h3 class="card-title">Multi option edit</h3><br>

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


                <form id="optionForm" action="<?php echo base_url('bulk_multi_option_action') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h4 class="modal-title">Options</h4>
                    </div>
                    <div class="modal-body" >
                        <?php foreach ($all_product as $val){ ?>
                            <input type="hidden" name="productId[]" value="<?php echo $val;?>" >
                        <?php } ?>
                        <div class="row">
                            <div class="col-5 col-sm-3 h-100">
                                <div class="nav flex-column nav-tabs h-100 text-right font-weight-bolder tab-link-ajax" id="vert-tabs-tab" role="tablist" aria-orientation="vertical"></div>

                                <div class=" flex-column search mt-2 h-100">
                                    <input type="text" class="form-control keyoption" name="keyoption" oninput="searchOptionUp(this.value)" >
                                    <span id="dataView"></span>
                                </div>

                            </div>

                            <div class="col-7 col-sm-9">
                                <div class="tab-content tab-content-ajax" id="vert-tabs-tabContent"></div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="submit" onclick="check_required_option()"  class="btn btn-primary">Save changes</button>
                        <a href="<?php echo base_url(isset($_COOKIE['bulk_url_path']) ? $_COOKIE['bulk_url_path'] : ''); ?>"  class="btn btn-danger">Back</a>
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
    function searchOptionUp(key) {
        let csrfName = $('meta[name="csrf-name"]').attr('content');
        let csrfHash = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('product_option_search') ?>",
            data: {
                [csrfName]: csrfHash,
                key: key
            },
            beforeSend: function() {
                $("#loading-image").show();
            },
            success: function(data) {
                $('#dataView').html(data);
            }

        });
    }

    function optionViewPro(option_id, name,nameTitle) {
        var n = "'" + name + "_op'";
        var rl = "'" + name + "_remove'";
        var nr = "'" + name + "'";
        var link = '<a class="nav-link active text-dark" id="' + name + '_remove"  data-toggle="pill" href="#' + name +
            '" role="tab" aria-controls="vert-tabs-home" aria-selected="true">' + nameTitle +
            '<button type="button" class="btn btn-sm" onclick="remove_option_new_ajax(' + rl + ',' + nr +
            ')"><i class="fa fa-trash text-danger"></i></button></a>';
        var con = '<div class="tab-pane text-left fade  show active" id="' + name +
            '" role="tabpanel" aria-labelledby="vert-tabs-home-tab"><div class="col-md-12 mt-2"> <h5>Click on add option</h5></div><hr><div id="' +
            name +
            '_op"></div><input type="hidden" value="1" id="total_chq"><div class="col-md-12 mt-2" ><a href="javascript:void(0)" style="float: right;    margin-right: 150px;" onclick="add_option_new_ajax(' +
            n + ',' + option_id + ');"class="btn btn-sm btn-primary">Add option</a></div></div>';

        $(".tab-link-ajax a").removeClass('active');
        $(".tab-content-ajax .tab-pane").removeClass('active');
        $('.keyoption').val('');
        $('#dataView').html('');
        $('.tab-link-ajax').append(link);
        $('.tab-content-ajax').append(con);

    }

    //option
    function add_option_new_ajax(id, option_id) {
        let csrfName = $('meta[name="csrf-name"]').attr('content');
        let csrfHash = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('product_option_value_search') ?>",
            data: {
                [csrfName]: csrfHash,
                option_id: option_id
            },
            success: function(val) {
                var data = val;

                var new_chq_no = parseInt($('#total_chq').val()) + 1;
                var new_input = "<div class='col-md-12 mt-3' id='new_" + new_chq_no +
                    "' ><input type='hidden' name='option[]' value='" + option_id +
                    "' ><select name='opValue[]' id='valId_" + new_chq_no +
                    "' style='padding: 3px;' required><option value=''>Please select</option>" + data +
                    "</select><select name='subtract[]' style='padding: 3px;'><option value='plus'>Plus</option><option value='minus'>Minus</option></select><input type='number' placeholder='Quantity' name='qty[]' required> <input type='number' placeholder='Price' name='price_op[]' required> <a href='javascript:void(0)' onclick='remove_option(this)' class='btn btn-sm btn-danger' style='margin-top: -5px;'>X</a></div>";

                $('#' + id).append(new_input);
                $('#total_chq').val(new_chq_no);
            }

        });



    }

    function remove_option_new_ajax(link, data) {
        $('#' + link).remove();
        $('#' + data).remove();
    }
    function remove_option(data) {
        $(data).parent().remove();
    }
</script>
<?= $this->endSection() ?>