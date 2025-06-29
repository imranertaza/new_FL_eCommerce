<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Product create</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="<?php echo base_url('product_create_action') ?>" method="post"
              enctype="multipart/form-data">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title">Product create</h3>
                        </div>
                        <div class="col-md-4" style="text-align: right;">
                            <a href="<?php echo base_url('products');?>" class="btn btn-danger ">Back</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                       href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                       aria-selected="true">Genarel</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                       href="#custom-tabs-four-profile" role="tab"
                                       aria-controls="custom-tabs-four-profile" aria-selected="false">Data</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-link-tab" data-toggle="pill"
                                       href="#custom-tabs-four-link" role="tab"
                                       aria-controls="custom-tabs-four-profile" aria-selected="false">Link</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill"
                                       href="#custom-tabs-four-messages" role="tab"
                                       aria-controls="custom-tabs-four-messages" aria-selected="false">Option</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill"
                                       href="#custom-tabs-four-attribute" role="tab"
                                       aria-controls="custom-tabs-four-messages" aria-selected="false">Attribute</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill"
                                       href="#custom-tabs-four-special" role="tab"
                                       aria-controls="custom-tabs-four-messages" aria-selected="false">Special</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill"
                                       href="#custom-tabs-four-other" role="tab"
                                       aria-controls="custom-tabs-four-messages" aria-selected="false">Others</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill"
                                       href="#custom-tabs-four-image" role="tab"
                                       aria-controls="custom-tabs-four-messages" aria-selected="false">Image</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                     aria-labelledby="custom-tabs-four-home-tab">
                                    <div class="form-group">
                                        <label>Name <span class="requi">*</span></label>
                                        <input type="text" name="pro_name" class="form-control" placeholder="Name"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" rows="3" class="form-control" id="editor" placeholder="Description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tag</label>
                                        <input type="text" name="tag" class="form-control" placeholder="Tag">
                                    </div>

                                    <div class="form-group">
                                        <label>Meta Title</label>
                                        <input type="text" name="meta_title" class="form-control"
                                               placeholder="Meta Title">
                                    </div>

                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea name="meta_description" rows="3" class="form-control"
                                                  placeholder="Meta Description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Keyword</label>
                                        <input type="text" name="meta_keyword" class="form-control"
                                               placeholder="Meta Keyword">
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                     aria-labelledby="custom-tabs-four-profile-tab">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Model <span class="requi">*</span></label>
                                                <input type="text" name="model" class="form-control" placeholder="Model"
                                                       required>
                                            </div>

                                            <div class="form-group">
                                                <label>Price <span class="requi">*</span></label>
                                                <input type="number" name="price" class="form-control"
                                                       placeholder="Price"
                                                       required>
                                            </div>
                                            <div class="form-group">
                                                <label>Quantity <span class="requi">*</span></label>
                                                <input type="number" name="quantity" class="form-control"
                                                       placeholder="Quantity" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Wight</label>
                                                <input type="text" name="weight" class="form-control"
                                                       placeholder="Weight">
                                            </div>
                                            <div class="form-group">
                                                <label>Length</label>
                                                <input type="text" name="length" class="form-control"
                                                       placeholder="Length">
                                            </div>
                                            <div class="form-group">
                                                <label>Width</label>
                                                <input type="text" name="width" class="form-control"
                                                       placeholder="Width">
                                            </div>
                                            <div class="form-group">
                                                <label>Height</label>
                                                <input type="text" name="height" class="form-control"
                                                       placeholder="Height">
                                            </div>
                                            <div class="form-group">
                                                <label>Sort Order</label>
                                                <input type="text" name="sort_order" class="form-control"
                                                       placeholder="sort order">
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="custom-tabs-four-link" role="tabpanel"
                                     aria-labelledby="custom-tabs-four-profile-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Product Featured</label>
                                                <input type="checkbox" name="product_featured"  data-bootstrap-switch>
                                                <br><br>
                                                <label>Free Delivery</label>
                                                <input type="checkbox" name="product_free_delivery"  data-bootstrap-switch>
                                            </div>
                                            <div class="form-group">
                                                <label>Brand</label>
                                                <select name="brand_id" class="form-control">
                                                    <option value="">Please select</option>
                                                    <?php foreach ($brands as $brand){ ?>
                                                    <option value="<?php echo $brand->brand_id;?>"><?php echo $brand->name;?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group category">
                                                <label>Category <span class="requi">*</span></label>
                                                <select class="select2bs4" name="categorys[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" required>
                                                    <?php foreach ($prodCat as $cat) { ?>
                                                        <option value="<?php echo $cat->prod_cat_id; ?>"><?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="form-group category">
                                                <label>Related Product</label>
                                                <select class="select2_pro" id="keyword" name="product_related[]" multiple="multiple" style="width: 100%;" ></select>

                                            </div>

                                            <div class="form-group category">
                                                <label>Bought Together Products</label>
                                                <select class="bought_together_pro" id="keyword2" name="bought_together[]" multiple="multiple" style="width: 100%;" ></select>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel"
                                     aria-labelledby="custom-tabs-four-messages-tab">
                                    <div class="row">
                                        <div class="col-5 col-sm-3 h-100">
                                            <div class="nav flex-column nav-tabs h-100 text-right font-weight-bolder tab-link-ajax" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                            </div>

                                            <div class=" flex-column search mt-2 h-100">
                                                <input type="text" class="form-control keyoption" name="keyoption" oninput="searchOptionUp(this.value)" >
                                                <span id="dataView"></span>
                                            </div>

                                        </div>
                                        <div class="col-7 col-sm-9">
                                            <div class="tab-content tab-content-ajax" id="vert-tabs-tabContent">
                                            </div>
                                        </div>




                                    </div>


                                </div>

                                <div class="tab-pane fade" id="custom-tabs-four-attribute" role="tabpanel"
                                     aria-labelledby="custom-tabs-four-messages-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>Attribute</h3>
                                        </div>
                                        <div class="col-md-6">
                                        </div>

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

                                <div class="tab-pane fade" id="custom-tabs-four-special" role="tabpanel"
                                     aria-labelledby="custom-tabs-four-messages-tab">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Special Price </label>
                                                <input type="text" name="special_price" class="form-control"
                                                       placeholder="Special Price">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="date" name="start_date" class="form-control"
                                                       placeholder="Start Date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="date" name="end_date" class="form-control"
                                                       placeholder="End Date">
                                            </div>
                                        </div>


                                    </div>


                                </div>

                                <div class="tab-pane fade" id="custom-tabs-four-other" role="tabpanel"
                                     aria-labelledby="custom-tabs-four-messages-tab">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label>Video </label>
                                                <input type="text" name="video" class="form-control" placeholder="Video code"
                                                       >
                                            </div>

                                            <div class="form-group">
                                                <label>Documentation Pdf </label>
                                                <input type="file" name="documentation_pdf" class="form-control" placeholder="Documentation Pdf"
                                                       >
                                            </div>


                                            <div class="form-group">
                                                <label>Safety Pdf </label>
                                                <input type="file" name="safety_pdf" class="form-control" placeholder="Safety Pdf"
                                                       >
                                            </div>


                                            <div class="form-group">
                                                <label>Instructions Pdf </label>
                                                <input type="file" name="instructions_pdf" class="form-control" placeholder="Instructions Pdf"
                                                       >
                                            </div>

                                            <label>Description Image </label>

                                            <div id="framessingle"></div><br>
                                            <input type="file" id="singleimage" name="description_image" class="form-control" >

                                        </div>



                                    </div>


                                </div>

                                <div class="tab-pane fade" id="custom-tabs-four-image" role="tabpanel"
                                     aria-labelledby="custom-tabs-four-messages-tab">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h3>Default Image <span class="requi">*</span></h3>
                                        </div>
                                        <div class="col-md-8">
                                            <div id="framesdef"></div><br>
                                            <input type="file" id="defimage" name="image" class="form-control" required>

                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="col-md-4">
                                            <h3>Multiple Image</h3>
                                        </div>
                                        <div class="col-md-8 mt-3">
                                            <div id="frames"></div><br>
                                            <input type="file" class="form-control" id="image" name="multiImage[]" multiple />

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </form>
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
<script>
    function searchOptionUp(key) {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('product_option_search') ?>",
            data: {
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
        // var data = '';
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('product_option_value_search') ?>",
            data: {
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

    function remove_option(data) {
        $(data).parent().remove();
    }

    function remove_option_new_ajax(link, data) {
        $('#' + link).remove();
        $('#' + data).remove();
    }

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