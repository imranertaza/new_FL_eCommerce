<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Offer create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard')?>">Home</a></li>
                            <li class="breadcrumb-item active">Offer create</li>
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
                            <h3 class="card-title">Offer create</h3>
                        </div>
                        <div class="col-md-4"> </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('general_offer_create_action')?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Offer Name</label>
                                    <input type="text" name="offer" oninput="slug_create(this.value)" class="form-control" placeholder="Offer Name" required>
                                </div>
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="slug" required>
                                </div>

                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" name="start_date" class="form-control" placeholder="Start Date" required>
                                </div>

                                <div class="form-group">
                                    <label>Expire Date</label>
                                    <input type="date" name="expire_date" class="form-control" placeholder="Expire Date" required>
                                </div>
                                <div class="form-group">
                                    <label>Offer Type</label>
                                    <select class="form-control" name="offer_type">
                                        <option value="distinct">Distinct</option>
                                        <option value="indistinct">Indistinct</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label>Description</label>
                                    <textarea name="description" rows="8" class="form-control" placeholder="Description" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Banner</label>
                                    <input type="file" name="banner" class="form-control" placeholder="banner" >
                                    Recommended Size (1116x481)
                                </div>
                            </div>


                            <div class="col-md-6">
                                <h2>Buy</h2>
                                <div class="form-group 	">
                                    <label>Offer On</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onchange="offerOn('product')" name="offer_on" id="offer1" checked value="product">
                                        <label class="form-check-label" for="offer1">Product</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onchange="offerOn('amount')" name="offer_on" id="offer2" value="amount">
                                        <label class="form-check-label" for="offer2">Amount</label>
                                    </div>
                                </div>

                                <div class="form-group category" id="offer_product_all">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input allPro" onclick="selectAllProduct()" type="checkbox" name="allProduct" id="all2" value="1">
                                        <label class="form-check-label" for="all2">All Products</label>
                                    </div>
                                </div>

                                <div class="form-group category" id="offer_product_brand">
                                    <label>Brand </label>
                                    <select class="select2bs4" name="brand[]" id="brand" multiple="multiple" data-placeholder="Select a Brand" style="width: 100%;" >
                                        <?php foreach ($brand as $br) { ?>
                                            <option value="<?php echo $br->brand_id; ?>"><?php echo $br->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group category" id="offer_product_category">
                                    <label>Category </label>
                                    <select class="select2bs4" name="categorys[]" id="category" multiple="multiple" data-placeholder="Select a Category" style="width: 100%;" >
                                        <?php foreach ($prodCat as $cat) { ?>
                                            <option value="<?php echo $cat->prod_cat_id; ?>"><?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group" id="offer_product">
                                    <label>Products</label>
                                    <select class="select2_pro" id="keyword" name="products[]" multiple="multiple" style="width: 100%;" ></select>
                                </div>
                                <div class="form-group" id="offer_qty">
                                    <label>Quantity</label>
                                    <input type="number" name="qty" class="form-control" placeholder="Qty" min="1" value="1">
                                </div>


                                <div class="form-group" id="offer_amount" style="display:none" >
                                    <label>On Amount</label>
                                    <input type="number" name="on_amount" class="form-control" placeholder="Amount" >
                                </div>

                                <button type="submit" class="btn btn-primary" >Create</button>
                                <a href="<?php echo base_url('general_offer')?>" class="btn btn-danger" >Back</a>
                            </div>
                            <div class="col-md-6">
                                <h2>Get</h2>
                                <div class="form-group 	">
                                    <label>Discount On</label><br>
                                    <div class="form-check form-check-inline" id="dis_product">
                                        <input class="form-check-input" type="radio" onchange="discType('product')" name="discount_on" id="discount1" checked value="product">
                                        <label class="form-check-label" for="discount1">Product</label>
                                    </div>
                                    <div class="form-check form-check-inline" >
                                        <input class="form-check-input" type="radio" onchange="discType('product_amount')"  name="discount_on" id="discount2" value="product_amount">
                                        <label class="form-check-label" for="discount2">Product Amount</label>
                                    </div>
                                    <div class="form-check form-check-inline" >
                                        <input class="form-check-input" type="radio" onchange="discType('shipping_amount')" name="discount_on" id="discount3" value="shipping_amount">
                                        <label class="form-check-label" for="discount3">Shipping Amount</label>
                                    </div>
                                </div>

                                <div class="form-group " id="discType" style="display: none;">
                                    <label>Discount Type</label><br>
                                    <div class="form-check form-check-inline" >
                                        <input class="form-check-input" type="radio" name="discount_type" id="discountType1"  value="discount_percent">
                                        <label class="form-check-label" for="discountType1">Percent</label>
                                    </div>
                                    <div class="form-check form-check-inline" >
                                        <input class="form-check-input" type="radio" name="discount_type" id="discountType2" value="discount_amount">
                                        <label class="form-check-label" for="discountType2">Flat rate</label>
                                    </div>
                                </div>

                                <div class="form-group" id="amount" style="display:none" >
                                    <label>Amount</label>
                                    <input type="number" name="amount" class="form-control" placeholder="Amount" >
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

    </script>
<?= $this->endSection() ?>