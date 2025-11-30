<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <?php $sectionName = get_data_by_id('section_number','cc_featured_section','featured_section_id',$sectionId) ?>
                        <h1><?= $sectionName;?> </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active"><?= $sectionName;?> </li>
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
                                <h3 class="card-title"><?= $sectionName;?> </h3>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="<?= base_url('featured_section')?>" class="btn btn-danger float-right btn-sm">Back</a>
                            </div>
                            <div class="col-md-12" style="margin-top: 10px">
                                <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php foreach ($schedule as $key => $result){
//
                            $products = get_array_data_by_id('cc_featured_product', 'featured_schedule_id', $result->featured_schedule_id);
//
                            $hasProduct = false;
                            $hasBrand = false;
                            $hasCategory = false;
                            foreach ($products as $p) {
                                if (!empty($p->product_id)) $hasProduct = true;
                                if (!empty($p->brand_id)) $hasBrand = true;
                                if (!empty($p->prod_cat_id)) $hasCategory = true;
                            }
                        ?>
                        <div class="col-md-12 mt-4 card">
                            <form action="<?= base_url('section_view_update_action')?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="row p-2">
                                <div class="col-md-12">
                                    <!-- Remove button -->
                                    <a href="<?= base_url('section_view_delete/'.$result->featured_schedule_id)?>" class="btn btn-danger float-right" onclick="return confirm('Are you sure you want to delete this section?');" >X</a>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Section Name <span class="requi">*</span></label>
                                        <input type="text" name="section_name" class="form-control" placeholder="Section name" value="<?= $result->section_name?>" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="radio" value="type_<?= $key.'_1'?>">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" onclick="typeEventTwo(this)"  name="type_<?= $key.'_1'?>" id="exampleRadios1_<?= $key.'_1'?>" value="option1"  <?= $hasProduct ? 'checked' : '' ?> >
                                            <label class="form-check-label" for="exampleRadios1_<?= $key.'_1'?>">Product</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" onclick="typeEventTwo(this)" name="type_<?= $key.'_1'?>" id="exampleRadios2_<?= $key.'_1'?>" value="option2" <?= $hasBrand ? 'checked' : '' ?> >
                                            <label class="form-check-label" for="exampleRadios2_<?= $key.'_1'?>">Brand</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" onclick="typeEventTwo(this)" name="type_<?= $key.'_1'?>" id="exampleRadios3_<?= $key.'_1'?>" value="option3" <?= $hasCategory ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="exampleRadios3_<?= $key.'_1'?>">Category</label>
                                        </div>
                                    </div>


                                    <div class="form-group " id="product_<?= $key.'_1'?>" <?= $hasProduct ? 'style="display:block;"' : 'style="display:none;"' ?> >
                                        <label>Product <span class="requi">*</span></label>
                                        <select class="select2_pro_new" name="product_id[]" multiple="multiple" style="width: 100%;">
                                            <?php foreach ($products as $product){ if (!empty($product->product_id)){ ?>
                                                <option value="<?= $product->product_id ?>" selected ><?= get_data_by_id('name','cc_products','product_id',$product->product_id)?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>

                                    <div class="form-group" id="brand_<?= $key.'_1'?>" <?= $hasBrand ? 'style="display:block;"' : 'style="display:none;"' ?> >
                                        <label>Brand <span class="requi">*</span></label>
                                        <select name="brand_id[]" class="select2Brand"  multiple="multiple" style="width: 100%;" >
                                            <option value="">Please select</option>
                                            <?php foreach (get_array_data_by_id('cc_brand', 'status', 'Active') as $brand){ ?>
                                                <option value="<?php echo $brand->brand_id;?>" <?php foreach ($products as $brands){ echo ($brands->brand_id == $brand->brand_id)?'selected ':''; } ?> ><?php echo $brand->name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group " id="category_<?= $key.'_1'?>" <?= $hasCategory ? 'style="display:block;"' : 'style="display:none;"' ?> >
                                        <label>Category <span class="requi">*</span></label>
                                        <select name="prod_cat_id[]" class="select2Category" multiple="multiple" style="width: 100%;">
                                            <option value="">Please select</option>
                                            <?php foreach (get_array_data_by_id('cc_product_category', 'status', '1') as $cat) { ?>
                                                <option value="<?php echo $cat->prod_cat_id; ?>" <?php foreach ($products as $val){ echo ($val->prod_cat_id == $cat->prod_cat_id)?'selected ':''; } ?>><?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group"><hr></div>

                                    <div class="form-group">
                                        <label>Start Date <span class="requi">*</span></label>
                                        <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d', strtotime($result->start_date)) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>End Date <span class="requi">*</span></label>
                                        <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime($result->end_date)) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="featured_section_id" value="<?= $result->featured_section_id?>">
                                        <input type="hidden" name="featured_schedule_id" value="<?= $result->featured_schedule_id?>">
                                        <button type="submit" class="btn btn-success w-100">Update</button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Url <span class="requi">*</span></label>
                                        <input type="text" name="url" class="form-control" placeholder="Url" value="<?= $result->url?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Alt Name <span class="requi">*</span></label>
                                        <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?= $result->alt_name?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="image" class="form-control" >
                                        <span>Recommended Size: 271 x 590</span>
                                    </div>
                                    <div class="form-group">
                                        <?= image_view('uploads/sections', '', $result->image, 'noimage.png', 'w-25');?>
                                    </div>


                                </div>
                            </div>
                            </form>
                        </div>
                        <?php } ?>

                        <form action="<?= base_url('section_view_action')?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div id="formRows">
                                <div class="col-md-12 mt-4 card formRow">
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            <!-- Remove button -->
                                            <button type="button" class="btn btn-danger removeRow float-right">X</button>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Section Name <span class="requi">*</span></label>
                                                <input type="text" name="section_name[]" class="form-control" placeholder="Section name" required>
                                            </div>

                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" onclick="typeEvent(this)"  name="type" id="exampleRadios1" value="option1" checked>
                                                    <label class="form-check-label" for="exampleRadios1">Product</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" onclick="typeEvent(this)" name="type" id="exampleRadios2" value="option2">
                                                    <label class="form-check-label" for="exampleRadios2">Brand</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" onclick="typeEvent(this)" name="type" id="exampleRadios3" value="option3">
                                                    <label class="form-check-label" for="exampleRadios3">Category</label>
                                                </div>
                                            </div>


                                            <div class="form-group " id="product">
                                                <label>Product <span class="requi">*</span></label>
                                                <select class="select2_pro_new" name="product_id[0][]" multiple="multiple" style="width: 100%;"></select>
                                            </div>

                                            <div class="form-group" id="brand" style="display:none;">
                                                <label>Brand <span class="requi">*</span></label>
                                                <select name="brand_id[0][]" class="select2Brand"  multiple="multiple" style="width: 100%;">
                                                    <?php foreach (get_array_data_by_id('cc_brand', 'status', 'Active') as $brand){ ?>
                                                        <option value="<?php echo $brand->brand_id;?>"><?php echo $brand->name;?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group " id="category" style="display:none;">
                                                <label>Category <span class="requi">*</span></label>
                                                <select name="prod_cat_id[0][]" class="select2Category" multiple="multiple"  style="width: 100%;">
                                                    <?php foreach (get_array_data_by_id('cc_product_category', 'status', '1') as $cat) { ?>
                                                        <option value="<?php echo $cat->prod_cat_id; ?>"><?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group"><hr></div>

                                            <div class="form-group">
                                                <label>Start Date <span class="requi">*</span></label>
                                                <input type="date" name="start_date[]" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>End Date <span class="requi">*</span></label>
                                                <input type="date" name="end_date[]" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Url <span class="requi">*</span></label>
                                                <input type="text" name="url[]" class="form-control" placeholder="Url" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Alt Name <span class="requi">*</span></label>
                                                <input type="text" name="alt_name[]" class="form-control" placeholder="Alt Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Image <span class="requi">*</span></label>
                                                <input type="file" name="image[]" class="form-control" required>
                                                <span>Recommended Size: 271 x 590</span>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 card">
                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <input type="hidden" name="featured_section_id" value="<?= $sectionId?>">
                                        <button type="submit" class="btn btn-dark w-100">Save</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-info w-100" id="addRow">Add New Row</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
    <script>

        // Function to initialize Select2 with AJAX
        function initSelect2(selector) {
            $(selector).select2({
                multiple: true,
                theme: 'bootstrap4',
                ajax: {
                    url: "<?php echo base_url('related_product') ?>",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.product_id,
                                    text: item.name
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: "Select product",
                allowClear: true
            });
        }

        function initSelect2Category() {
            $('.select2Category').select2({
                theme: 'bootstrap4',
                sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
                placeholder: "Select category",
                allowClear: true
            });
        }

        function initSelect2Brand() {
            $('.select2Brand').select2({
                theme: 'bootstrap4',
                sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
                placeholder: "Select brand",
                allowClear: true
            });
        }

        $(document).ready(function () {
            // Initialize Select2 for the first row
            initSelect2('.select2_pro_new');
            initSelect2Category();
            initSelect2Brand();


            let rowIndex = 0;
            // Add New Row
            $("#addRow").click(function () {
                rowIndex++;

                // Clone row WITHOUT select2 container markup
                let newRow = $(".formRow").first().clone(false, false);

                // Remove any leftover select2 container DOM
                newRow.find(".select2").remove();

                // Reset inputs
                newRow.find("input[type='text'], input[type='date'], input[type='file']").val("");
                newRow.find("select").val(null);

                // Make sure the cloned select is clean (just <select>)
                newRow.find(".select2_pro_new").removeAttr("data-select2-id tabindex aria-hidden").show();
                newRow.find(".select2_pro_new").attr("name", "product_id[" + rowIndex + "][]");



                newRow.find(".select2Category").removeAttr("data-select2-id tabindex aria-hidden").show();
                newRow.find(".select2Category").attr("name", "prod_cat_id[" + rowIndex + "][]");

                newRow.find(".select2Brand").removeAttr("data-select2-id tabindex aria-hidden").show();
                newRow.find(".select2Brand").attr("name", "brand_id[" + rowIndex + "][]");


                // Make radio buttons have unique name
                newRow.find("input[type='radio']").each(function () {
                    // Original ids
                    let oldId = $(this).attr("id");

                    // Generate new id
                    let newId = oldId + "_" + rowIndex;
                    $(this).attr("id", newId);

                    // Update label's 'for' attribute
                    $(this).siblings("label").attr("for", newId);

                    // Set unique name
                    $(this).attr("name", "type_" + rowIndex);

                    // Set Product as default
                    if ($(this).val() === "option1") {
                        $(this).prop("checked", true);
                    } else {
                        $(this).prop("checked", false);
                    }
                });

                // Make the div IDs unique
                newRow.find("#product").attr("id", "product_" + rowIndex).show();
                newRow.find("#brand").attr("id", "brand_" + rowIndex).hide();
                newRow.find("#category").attr("id", "category_" + rowIndex).hide();

                // Update typeEvent to use relative selectors
                newRow.find("input[type='radio']").attr("onclick", "typeEvent(this)");

                // Append clean row
                $("#formRows").append(newRow);

                // Re-initialize select2 on the new select
                initSelect2(newRow.find(".select2_pro_new"));
                initSelect2Category();
                initSelect2Brand();
            });

            // Remove Row
            $(document).on("click", ".removeRow", function () {
                if ($(".formRow").length > 1) {
                    $(this).closest(".formRow").remove();
                } else {
                    alert("At least one row is required.");
                }
            });
        });

        function typeEvent(el) {
            let value = $(el).val();
            let formRow = $(el).closest('.formRow');

            // Hide all sections in this row
            formRow.find('[id^=product],[id^=brand],[id^=category]').hide();

            // Show correct section
            if (value === 'option1') formRow.find('[id^=product]').show();
            else if (value === 'option2') formRow.find('[id^=brand]').show();
            else if (value === 'option3') formRow.find('[id^=category]').show();
        }

        function typeEventTwo(el) {
            // Get the selected value
            var value = el.value;

            // Find the main container (the card that this belongs to)
            var parentCard = el.closest('.card');
            if (!parentCard) return;

            // Hide all 3 sections first
            parentCard.querySelectorAll('[id^="product_"], [id^="brand_"], [id^="category_"]').forEach(function(div) {
                div.style.display = 'none';
            });

            // Show the correct section based on radio selection
            if (value === 'option1') {
                parentCard.querySelector('[id^="product_"]').style.display = 'block';
            } else if (value === 'option2') {
                parentCard.querySelector('[id^="brand_"]').style.display = 'block';
            } else if (value === 'option3') {
                parentCard.querySelector('[id^="category_"]').style.display = 'block';
            }
        }

    </script>
<?= $this->endSection() ?>