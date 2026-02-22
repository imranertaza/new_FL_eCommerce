<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Zone Rate Shipping Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active">Zone Rate Shipping Settings</li>
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
                        <h3 class="card-title">Zone Rate Shipping Settings</h3>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-12" style="margin-top: 10px" id="mess">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url('zone_rate_update_action')?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" <?php echo ($shipping_status == '1')?'selected':'';?> >Active</option>
                                    <option value="0" <?php echo ($shipping_status == '0')?'selected':'';?> >Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5>Calculation Method</h5>
                            <?php
                                $sel = get_data_by_id('value','cc_shipping_settings','shipping_method_id',$shipping_method_id);

                                foreach (zone_rate_type() as $key => $val){
                            ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="zone_rate_method" id="method_<?php echo $key;?>" value="<?php echo $key;?>" <?php echo ($sel==$key)?'checked':''; ?>  >
                                    <label class="form-check-label" for="method_<?php echo $key;?>"><?php echo $val;?></label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-12 mt-3 mb-3">
                            <hr>
                            <h5>Zone rate set</h5>
                            <?php $allZone = get_all_data_array('cc_geo_zone');?>
                            <div class="row" id="tab_zone">
                                <div class="col-3 mt-1">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" >
                                        <?php foreach ($allZone as $key => $tab){ ?>
                                        <a class="nav-link <?php echo ($key == '0')?'active':'';?>" id="v-pills-home-tab" data-toggle="pill" href="#tabZone_<?php echo $tab->geo_zone_id;?>" role="tab" aria-controls="v-pills-home" aria-selected="true"><?php echo $tab->geo_zone_name;?></a>
                                        <?php } ?>
                                        <a class="nav-link " id="v-pills-home-tab" data-toggle="pill" href="#Others" role="tab" aria-controls="v-pills-home" aria-selected="true">Others zones</a>
                                    </div>
                                </div>
                                <div class="col-9 ">
                                    <div class="tab-content ml-4" id="v-pills-tabContent" >
                                        <?php foreach ($allZone as $key => $tabCon){ $allRate = get_array_data_by_id('cc_geo_zone_shipping_rate', 'geo_zone_id', $tabCon->geo_zone_id); ?>
                                        <div class="tab-pane fade  <?php echo ($key == '0')?'show active':'';?> row" id="tabZone_<?php echo $tabCon->geo_zone_id;?>" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                            <div class="col-md-12 text-center " >
                                                <hr>
                                                <a href="javascript:void(0)" style="float: right;" onclick="add_zone_rate('<?php echo $tabCon->geo_zone_id;?>');" class="btn btn-sm btn-primary ">+ Add Rate</a>
                                                <h5 class="mt-2"><?php echo $tabCon->geo_zone_name;?> Rate Add </h5>
                                                <hr>
                                            </div>

                                            <div class="col-md-12">
                                                <div id="new_rate_<?php echo $tabCon->geo_zone_id;?>" class="row">
                                                    <?php foreach ($allRate as $rate){ if ($rate->up_to_value != null){ ?>
                                                    <div class='col-md-12 mt-2' ><input type='text' class='form-input' placeholder='Weight'  name='up_to_value[]' value="<?php echo $rate->up_to_value;?>" style='width: 40%; margin-right: 2px'><input type='text' class='form-input' value="<?php echo $rate->cost;?>"  name='cost[]' placeholder='Rate' style='width: 45%; margin-left: 3px;'><input type='hidden' value='<?php echo $tabCon->geo_zone_id;?>' name='geo_zone_id[]'><input type='hidden' value='<?php echo $rate->cc_geo_zone_shipping_rate_id;?>' name='cc_geo_zone_shipping_rate_id[]'> <a href='javascript:void(0)' onclick='remove_option(this),removeRate(<?php echo $rate->cc_geo_zone_shipping_rate_id;?>)' class='btn btn-danger' style='margin-top: -5px;width: 5%;'>X</a></div>
                                                    <?php } } ?>

                                                </div>
                                                <div class="row">
                                                    <?php foreach ($allRate as $rate){ if ($rate->up_to_value == null){ ?>
                                                    <div class="col-md-12 mt-2" >
                                                        <input type="text" class="form-input" name="above[]" placeholder="Above to"  style='width: 40%; margin-right: 2px' value="<?php echo $rate->above;?>">
                                                        <input type="text" class="form-input" name="costAbove[]" style='width: 45%; margin-right: 3px' value="<?php echo $rate->cost;?>">
                                                        <input type="hidden" value="<?php echo $rate->cc_geo_zone_shipping_rate_id;?>" name="above_rate_id[]">
                                                    </div>
                                                    <?php }} if (empty($allRate)) {?>
                                                        <div class="col-md-12 mt-2" >
                                                            <input type="text" class="form-input" name="above[]" placeholder="Above to"  style='width: 40%; margin-right: 2px' value="">
                                                            <input type="text" class="form-input" name="costAbove[]" style='width: 45%; margin-right: 3px' value="">
                                                        </div>
                                                    <?php }  ?>
                                                    <input type='hidden' value='<?php echo $tabCon->geo_zone_id;?>' name='zone_id[]'>
                                                </div>
                                                <input type="hidden" value="1" id="total_item_<?php echo $tabCon->geo_zone_id;?>">
                                            </div>

                                        </div>
                                        <?php } ?>

                                        <div class="tab-pane fade   row" id="Others" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                            <div class="col-md-12 text-center " >
                                                <hr>
                                                <a href="javascript:void(0)" style="float: right;" onclick="add_zone_rate('0');" class="btn btn-sm btn-primary ">+ Add Rate</a>
                                                <h5 class="mt-2">Others Rate Add </h5>
                                                <hr>
                                            </div>

                                            <div class="col-md-12">
                                                <div id="new_rate_0" class="row">
                                                    <?php $allRateOt = get_array_data_by_id('cc_geo_zone_shipping_rate', 'geo_zone_id', '0'); foreach ($allRateOt as $rateOt){ ?>
                                                        <div class='col-md-12 mt-2' ><input type='text' class='form-input' placeholder='Weight'  name='up_to_value[]' value="<?php echo $rateOt->up_to_value;?>" style='width: 40%;margin-right: 2px;'><input type='text' class='form-input' value="<?php echo $rateOt->cost;?>"  name='cost[]' placeholder='Rate' style='width: 45%; margin-left: 3px;'><input type='hidden' value='0' name='geo_zone_id[]'><input type='hidden' value='<?php echo $rateOt->cc_geo_zone_shipping_rate_id;?>' name='cc_geo_zone_shipping_rate_id[]'> <a href='javascript:void(0)' onclick='remove_option(this),removeRate(<?php echo $rateOt->cc_geo_zone_shipping_rate_id;?>),updateAbove(this);' class='btn btn-danger' style='margin-top: -5px;width: 5%;'>X</a></div>
                                                    <?php } ?>
                                                </div>
                                                <input type="hidden" value="1" id="total_item_0">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" >Update</button>
                            <input type="hidden" name="shipping_method_id" value="<?php echo $shipping_method_id;?>" required>
                            <a href="<?php echo base_url('shipping')?>" class="btn btn-danger" >Back</a>
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
    function add_zone_rate(id) {
        var new_chq_no = parseInt($('#total_item_'+id).val()) + 1;
        var new_input = "<div class='col-md-12 mt-2'><input type='text' class='form-input' placeholder='Up To Value'  name='up_to_value[]' style='width: 40%;margin-right: 2px;'><input type='text' class='form-input'  name='cost[]' placeholder='Cost' style='width: 45%;margin-left: 3px;'><input type='hidden' value='"+id+"' name='geo_zone_id[]'><input type='hidden' value='' name='cc_geo_zone_shipping_rate_id[]'> <a href='javascript:void(0)' onclick='remove_option(this)' class='btn btn-danger' style='margin-top: -5px;width: 5%;'>X</a></div>";

        $('#new_rate_'+id).append(new_input);
        $('#total_item_'+id).val(new_chq_no);
    }

    function removeRate(id){
        let csrfName = $('meta[name="csrf-name"]').attr('content');
        let csrfHash = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('zone_rate_delete') ?>",
            data: {
                [csrfName]: csrfHash,
                cc_geo_zone_shipping_rate_id: id
            },
            beforeSend: function() {
                $("#loading-image").show();
            },
            success: function(data) {
                $("#mess").html(data);
            }

        });
    }

    function remove_option(data) {
        $(data).parent().remove();
    }

    document.addEventListener('input', function(e) {

        if (e.target.name === 'up_to_value[]') {

            // Find correct tab container automatically
            let container = e.target.closest('[id^="new_rate_"]');
            if (!container) return;

            // Get all values inside this tab only
            let inputs = container.querySelectorAll('input[name="up_to_value[]"]');
            let values = [];

            inputs.forEach(input => {
                let val = parseFloat(input.value);
                if (!isNaN(val)) values.push(val);
            });

            let maxVal = values.length ? Math.max(...values) : 0;

            // Find "Above To" field inside same tab
            let tabPane = container.closest('.tab-pane');
            if (!tabPane) return;

            let aboveInput = tabPane.querySelector('input[name="above[]"]');
            if (aboveInput) {
                aboveInput.value = maxVal;
            }
        }

    });


</script>
<?= $this->endSection() ?>