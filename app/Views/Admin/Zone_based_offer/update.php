<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Zone Based Offer update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard')?>">Home</a></li>
                            <li class="breadcrumb-item active">Zone Based Offer update</li>
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
                            <h3 class="card-title">Zone Based Offer update</h3>
                        </div>
                        <div class="col-md-4"> </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('zone_based_offer_update_action')?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Offer Name</label>
                                    <input type="text" name="offer" oninput="slug_create(this.value)" class="form-control" placeholder="Offer Name" value="<?php echo $offer->name; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="slug" value="<?php echo $offer->slug; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="<?= date('Y-m-d', strtotime($offer->start_date)); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Expire Date</label>
                                    <input type="date" name="expire_date" class="form-control" placeholder="Expire Date" value="<?= date('Y-m-d', strtotime($offer->expire_date)); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Offer Type</label>
                                    <select class="form-control" name="offer_type">
                                        <option value="distinct" <?= ($offer->offer_type === 'distinct' )?'selected':''; ?> >Distinct</option>
                                        <option value="indistinct" <?= ($offer->offer_type === 'indistinct' )?'selected':''; ?>>Indistinct</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label>Description</label>
                                    <textarea name="description" rows="8" class="form-control" placeholder="Description" required><?= $offer->description; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Banner</label>
                                    <input type="file" name="banner" class="form-control" placeholder="banner" >
                                    Recommended Size (1116x481)
                                </div>
                                <div class="form-group">
                                    <label>ALT Name</label>
                                    <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $offer->alt_name; ?>" >
                                </div>
                            </div>


                            <div class="col-md-6">
                                <h2>Buy</h2>
                                <div class="form-group 	">
                                    <label>Offer On</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onchange="offerOn('product')" <?= ($offer->offer_on == 'product')?'checked':'';?> name="offer_on" id="offer1" checked value="product">
                                        <label class="form-check-label" for="offer1">Product</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onchange="offerOn('amount')" name="offer_on" id="offer2" <?= ($offer->offer_on == 'amount')?'checked':'';?> value="amount">
                                        <label class="form-check-label" for="offer2">Amount</label>
                                    </div>
                                </div>

                                <div class="form-group category" id="offer_product_all" <?= ($offer->offer_on == 'product')?'style="display:block"':'style="display:none"';?>>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input allPro" onclick="selectAllProduct()" type="checkbox" <?php foreach ($offer_product as $val){ echo (($val->brand_id == null) && ($val->prod_cat_id == null) && ($val->product_id == null) )?'checked':''; } ?>  name="allProduct" id="all2" value="1">
                                        <label class="form-check-label" for="all2">All Products</label>
                                    </div>
                                </div>

                                <div class="form-group category" id="offer_product_brand" <?= ($offer->offer_on == 'product')?'style="display:block"':'style="display:none"';?>>
                                    <label>Brand </label>
                                    <select class="select2bs4" name="brand[]" id="brand" multiple="multiple" data-placeholder="Select a Brand" style="width: 100%;"  >
                                        <?php foreach ($brand as $br) { ?>
                                            <option value="<?php echo $br->brand_id; ?>" <?php foreach ($offer_product as $val){ echo ($val->brand_id == $br->brand_id)?'selected':''; } ?>><?php echo $br->name; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>

                                <div class="form-group category" id="offer_product_category" <?= ($offer->offer_on == 'product')?'style="display:block"':'style="display:none"';?>>
                                    <label>Category </label>
                                    <select class="select2bs4" name="categorys[]" id="category" multiple="multiple" data-placeholder="Select a Category" style="width: 100%;" >
                                        <?php foreach ($prodCat as $cat) {  ?>
                                            <option value="<?php echo $cat->prod_cat_id; ?>" <?php foreach ($offer_product as $val){ echo ($val->prod_cat_id == $cat->prod_cat_id)?'selected':''; } ?> ><?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                                <div class="form-group" id="offer_product" <?= ($offer->offer_on == 'product')?'style="display:block"':'style="display:none"';?>>
                                    <label>Products</label>
                                    <select class="select2_pro" id="keyword" name="products[]" multiple="multiple" style="width: 100%;" >
                                        <?php foreach ($offer_product as $val){ if (!empty($val->product_id)){ ?>
                                            <option value="<?php echo $val->product_id;?>" selected ><?php echo get_data_by_id('name','cc_products','product_id',$val->product_id);?> </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="form-group" id="offer_qty">
                                    <label>Quantity</label>
                                    <input type="number" name="qty" class="form-control" placeholder="Qty" min="1" value="<?= $offer->qty?>">
                                </div>


                                <div class="form-group" id="offer_amount"  <?= ($offer->offer_on == 'amount')?'style="display:block"':'style="display:none"';?> >
                                    <label>On Amount</label>
                                    <input type="number" name="on_amount" class="form-control" value="<?= $offer->on_amount?>" placeholder="Amount" >

                                </div>
                                <input type="hidden" name="shipping_method_id"  value="<?php echo  $shipping_method->shipping_method_id;?>" >
                                <input type="hidden" name="offer_id"  value="<?php echo $offer->offer_id;?>" >
                                <button type="submit" class="btn btn-primary" >Update</button>
                                <a href="<?php echo base_url('zone_based_offer')?>" class="btn btn-danger" >Back</a>
                            </div>
                            <div class="col-md-6">
                                <h2>Get</h2>
                                <div class="form-group 	">
                                    <label>Discount On</label><br>
                                    <div class="form-check form-check-inline" >
                                        <input class="form-check-input" type="radio" checked name="discount_on" id="discount3" value="shipping_amount">
                                        <label class="form-check-label" for="discount3">Shipping Amount</label>
                                    </div>
                                </div>
                                <?php $allZone = get_all_data_array('cc_geo_zone');?>
                                <?php foreach ($allZone as $zone){ ?>
                                <div class="form-group 	">
                                    <label><?php echo $zone->geo_zone_name;?></label><br>
                                    <div class="form-group " >
                                        <label>Discount Type</label><br>
                                        <div class="form-check form-check-inline" >
                                            <input class="form-check-input" type="radio"  <?php foreach ($offer_discount as $dis){if ($zone->geo_zone_id == $dis->geo_zone_id){ echo ($dis->discount_calculate_on == 'percentage')?'checked':'';  }} ?>  name="dis_<?php echo $zone->geo_zone_id;?>" id="discountType1_<?php echo $zone->geo_zone_id;?>"  value="discount_percent">
                                            <label class="form-check-label" for="discountType1_<?php echo $zone->geo_zone_id;?>">Percent</label>
                                        </div>
                                        <div class="form-check form-check-inline" >
                                            <input class="form-check-input" type="radio" <?php foreach ($offer_discount as $dis){if ($zone->geo_zone_id == $dis->geo_zone_id){ echo ($dis->discount_calculate_on == 'fixed')?'checked':'';  }} ?> name="dis_<?php echo $zone->geo_zone_id;?>" id="discountType2_<?php echo $zone->geo_zone_id;?>" value="discount_amount">
                                            <label class="form-check-label" for="discountType2_<?php echo $zone->geo_zone_id;?>">Flat rate</label>
                                        </div>
                                    </div>
                                    <div class="form-group"  >
                                        <label>Amount</label>
                                        <input type="number" name="amount_<?php echo $zone->geo_zone_id;?>" value="<?php foreach ($offer_discount as $dis){if ($zone->geo_zone_id == $dis->geo_zone_id){ echo $dis->discount_amount;}} ?>" class="form-control" placeholder="Amount" >
                                    </div>
                                </div>
                                <?php } ?>



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
        function slug_create(data){
            var title = data;
            var slug = title.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
            document.getElementsByName('slug')[0].value = slug;
        }
        function offerOn(offer){
            if (offer == 'product'){
                $('#discount1').prop('checked', true);
                $('#discount2').prop('checked', false);

                $('#offer_product').show();
                $('#offer_product_category').show();
                $('#offer_product_brand').show();
                $('#offer_product_all').show();
                $('#offer_qty').show();
                $('#dis_product').show();
                $('#offer_amount').hide();
                $('#discType').hide();
                $('#amount').hide();

            }else{
                $('#discount1').prop('checked', false);
                $('#discount2').prop('checked', true);

                $('#offer_product').hide();
                $('#offer_product_category').hide();
                $('#offer_product_brand').hide();
                $('#offer_product_all').hide();
                $('#offer_qty').hide();
                $('#dis_product').hide();
                $('#offer_amount').show();
                $('#discType').show();
                $('#amount').show();
            }

        }
        function discType(type){
            if (type == 'product'){
                $('#discType').hide();
                $('#amount').hide();
                $('#discountType1').prop('checked', false);
            }else{
                $('#discType').show();
                $('#amount').show();
                $('#discountType1').prop('checked', true);
            }
        }
        function selectAllProduct(){
            if($('.allPro').prop('checked')) {
                $('#keyword').prop('disabled', true);
                $('#brand').prop('disabled', true);
                $('#category').prop('disabled', true);
            } else {
                $('#keyword').prop('disabled', false);
                $('#brand').prop('disabled', false);
                $('#category').prop('disabled', false);
            }
        }
        $(document).ready(function() {
            if($('.allPro').prop('checked')) {
                $('#keyword').prop('disabled', true);
                $('#brand').prop('disabled', true);
                $('#category').prop('disabled', true);
            }
        });
    </script>
<?= $this->endSection() ?>