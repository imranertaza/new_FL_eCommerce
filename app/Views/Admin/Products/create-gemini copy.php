<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product create (Gemini)</h1>
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

    <div class="col-md-12" style="margin-top: 10px">
        <?php if (session()->getFlashdata('message') !== NULL):
            echo session()->getFlashdata('message');
        endif; ?>
    </div>
    <!-- Main content -->
    <section class="content">
        <form action="<?= base_url('product_create_gemini_action') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Bulk AI Product Generator</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Select Multiple Product Images</label>
                        <input type="file" name="product_images[]" id="product_images" multiple class="form-control"
                            onchange="previewQueue(this)">
                    </div>
                    <button type="button" id="btnAnalyze" class="btn btn-success" onclick="analyzeAllImages()">Analyze
                        All Images</button>

                    <div id="imageQueue" class="row mt-3"></div>
                    <hr>
                    <form id="productForm" action="<?= base_url('product_create_batch_action') ?>" method="post">
                        <?= csrf_field() ?>
                        <div id="productFormsContainer"></div>
                        <button type="submit" class="btn btn-primary mt-3" id="saveBtn">Save All Products</button>
                    </form>
                </div>
            </div>
        </form>


        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Heading</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="usr">Value:</label>
                            <input type="text" class="form-control" name="value" id="value" required>
                            <div class="invalid-feedback">Value is required</div>
                            <input type="hidden" id="optionId">
                            <input type="hidden" id="printId">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="valueAdd()">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <div class="form-group category d-none">
        <label>Category <span class="requi">*</span></label>
        <select class="select2bs4" name="categorys[]" multiple="multiple" data-placeholder="Select a State"
            style="width: 100%;" required>
            <?php foreach ($prodCat as $cat) { ?>
                <option value="<?php echo $cat->prod_cat_id; ?>">
                    <?php echo display_category_with_parent($cat->prod_cat_id); ?></option>
            <?php } ?>

        </select>
    </div>
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
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                $('#dataView').html(data);
            }

        });
    }

    function optionViewPro(option_id, name, nameTitle) {
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
        let csrfName = $('meta[name="csrf-name"]').attr('content');
        let csrfHash = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('product_option_value_search') ?>",
            data: {
                [csrfName]: csrfHash,
                option_id: option_id
            },
            success: function (val) {
                var data = val;
                var new_chq_no = parseInt($('#total_chq').val()) + 1;
                var new_input = "<div class='col-md-12 mt-3' id='new_" + new_chq_no +
                    "' ><input type='hidden' name='option[]' value='" + option_id +
                    "' ><select name='opValue[]' id='valId_" + new_chq_no +
                    "' style='padding: 3px;' onchange='valueCreate(this," + option_id + "," + new_chq_no + ")' required><option value=''>Please select</option><option value='create'>Add Option</option>" + data +
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

    function valueCreate(el, id, printId) {
        if (el.value === 'create') {
            $('#myModal').modal('show');
            $('#printId').val(printId);
            $('#optionId').val(id);
            $('#value').val('');
        }
    }

    function valueAdd() {

        let value = $('#value').val().trim();
        let option_id = $('#optionId').val();
        let printId = $('#printId').val();

        // validation
        if (value === '') {
            $('#value').addClass('is-invalid');
            return;
        } else {
            $('#value').removeClass('is-invalid');
        }

        let csrfName = $('meta[name="csrf-name"]').attr('content');
        let csrfHash = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            method: "POST",
            url: "<?php echo base_url('option_add_action') ?>",
            dataType: "json", // ✅ IMPORTANT
            data: {
                [csrfName]: csrfHash,
                option_id: option_id,
                value: value
            },
            success: function (data) {

                // ✅ update CSRF token
                $('meta[name="csrf-token"]').attr('content', data.csrfHash);
                $('input[name="<?= csrf_token() ?>"]').val(data.csrfHash);


                // error handling
                if (data.status === 'error') {
                    alert(data.message);
                    return;
                }

                let selectId = '#valId_' + printId;

                // append new option
                $(selectId).append(
                    `<option value="${data.id}" selected>${data.value}</option>`
                );

                // select it
                $(selectId).val(data.id);

                // close modal + reset
                $('#myModal').modal('hide');
                $('#value').val('');
            }
        });
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function (e) {
                let preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function processImageAI(input) {
        // 1. Check if a file is selected
        if (!input.files || !input.files[0]) return;

        previewImage(input);
        let formData = new FormData();
        formData.append('image', input.files[0]);
        // Include CSRF token for security
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        // --- NEW: Extract categories from the dropdown ---
        let categoryOptions = [];
        $('.select2bs4 option').each(function () {
            let id = $(this).val();
            let name = $(this).text().trim();
            if (id) {
                categoryOptions.push("ID " + id + ": " + name);
            }
        });
        // Append the compiled list to the payload
        formData.append('available_categories', categoryOptions.join(', '));
        // -------------------------------------------------

        $("#pro_name").val("AI is analyzing the product...");
        $(".btn-primary").prop("disabled", true);

        $.ajax({
            url: "<?= base_url('product_ai_analyze') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (res) {

                if (res.status === 'success') {
                    $("#pro_name").val(res.data.name);
                    $("#description").val(res.data.description);
                    $("#price").val(res.data.price);
                    $("#weight").val(res.data.weight);
                    $("#model").val(res.data.model);
                    $("#tag").val(res.data.tags);
                    $("#meta_title").val(res.data.meta_title);
                    $("#meta_description").val(res.data.meta_description);
                    $("#meta_keyword").val(res.data.meta_keyword);

                    // Handle multiple categories
                    if (res.data.category_ids && Array.isArray(res.data.category_ids)) {
                        $('.select2bs4').val(res.data.category_ids).trigger('change');
                    }
                } else {
                    alert("AI Analysis failed: " + res.message);
                    $("#pro_name").val("");
                }
            },
            error: function () {
                alert("An error occurred while communicating with the AI.");
                $("#pro_name").val("");
            },
            complete: function () {
                // Re-enable the save button
                $(".btn-primary").prop("disabled", false);
            }
        });
    }

    function previewQueue(input) {
        let container = $('#imageQueue').empty();
        Array.from(input.files).forEach(file => {
            let reader = new FileReader();
            reader.onload = (e) => {
                container.append(`<div class="col-md-2"><img src="${e.target.result}" class="img-thumbnail mb-2"></div>`);
            };
            reader.readAsDataURL(file);
        });
    }
    $('#saveBtn').hide();

    function analyzeAllImages() {
        let input = document.getElementById('product_images');
        if (!input.files || input.files.length === 0) return;

        let formData = new FormData();
        let metadata = [];

        for (let i = 0; i < input.files.length; i++) {
            let file = input.files[i];
            let uniqueId = 'img_' + Date.now() + '_' + i;
            formData.append('images[]', file);
            metadata.push({
                unique_id: uniqueId,
                original_index: i,
                file_name: file.name,
                image_type: file.type
            });
        }

        formData.append('metadata', JSON.stringify(metadata));
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        // === FIXED: Store as objects instead of strings ===
        let categoryOptions = [];
        $('.select2bs4 option').each(function () {
            let id = $(this).val();
            let name = $(this).text().trim();
            if (id) {
                categoryOptions.push({
                    id: id,
                    name: name
                });
            }
        });

        formData.append('available_categories', JSON.stringify(categoryOptions)); // Send as JSON

        $('#productFormsContainer').html(
            '<div class="alert alert-info">AI is analyzing images... please wait.</div>'
        );

        $.ajax({
            url: "<?= base_url('product_ai_analyze_batch') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    // ✅ update CSRF token
                    $('meta[name="csrf-token"]').attr('content', res.csrfHash);
                    $('input[name="<?= csrf_token() ?>"]').val(res.csrfHash);
                    let productsWithPreview = res.products.map((p, i) => ({
                        ...p,
                        unique_id: metadata[i].unique_id,     // Attach identifier
                        file_name: metadata[i].file_name,
                        image: URL.createObjectURL(input.files[i])
                    }));
                    renderBatchForms(productsWithPreview, categoryOptions);
                } else {
                    alert(res.message || 'Something went wrong');
                }
            },
            error: function () {
                alert('Request failed. Please try again.');
            }
        });
    }

    function previewBatchImage(input, index) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $(`.img-preview-${index}`).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function renderBatchForms(products, categoryOptions) {
        let container = $('#productFormsContainer').empty();

        products.forEach((p, i) => {
            let categoryHtml = categoryOptions.map(cat => {
                let catId = cat.id.toString();
                let isSelected = p.category_ids && (p.category_ids.includes(parseInt(catId)) || p.category_ids.includes(catId)) ? 'selected' : '';
                return `<option value="${cat.id}" ${isSelected}>${cat.name}</option>`;
            }).join('');

            container.append(`
            <div class="card card-primary card-outline shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Product #${i + 1}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column: Image -->
                        <div class="col-md-3">
                            <div class="form-group text-center">
                                <label>Product Image</label>
                                <div class="mb-2 p-2 border rounded bg-light">
                                    <img src="${p?.image || ''}" class="img-fluid img-preview-${i}" style="max-height:150px; ${p?.image ? '' : 'display:none;'}">
                                    <span class="text-muted small ${p?.image ? 'd-none' : ''}" id="no-img-${i}">No image</span>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary btn-block" onclick="$(this).next().click()">Choose Image</button>
                                <input type="file" name="batch[${i}][image]" class="d-none" onchange="previewBatchImage(this, ${i})">
                            </div>
                        </div>

                        <!-- Middle Column: Basic Details -->
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="batch[${i}][name]" class="form-control" value="${(p.name || '').replace(/"/g, '&quot;')}">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="batch[${i}][description]" class="form-control" rows="5">${(p.description || '')}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Categories</label>
                                <select class="form-control select2bs4" name="batch[${i}][category_ids][]" multiple="multiple" style="width: 100%;">
                                    ${categoryHtml}
                                </select>
                            </div>
                        </div>

                        <!-- Right Column: Numbers & SEO -->
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-4"><div class="form-group"><label>Qty</label><input type="number" name="batch[${i}][quantity]" class="form-control" value="${p.quantity || 18}"></div></div>
                                <div class="col-4"><div class="form-group"><label>Price</label><input type="number" name="batch[${i}][price]" min="0.01" step="0.01" class="form-control" value="${p.price || ''}"></div></div>
                                <div class="col-4"><div class="form-group"><label>Weight</label><input type="text" name="batch[${i}][weight]" class="form-control" value="${p.weight || ''}"></div></div>
                            </div>
                            
                            <div class="form-group">
                                <label>Tags</label>
                                <input type="text" name="batch[${i}][tags]" class="form-control" value="${(p.tags || '')}" placeholder="comma separated...">
                            </div>

                            <hr>
                            <h6 class="text-muted"><i class="fas fa-search mr-1"></i> SEO Settings</h6>
                            <div class="form-group">
                                <input type="text" name="batch[${i}][meta_title]" class="form-control form-control-sm mb-2" placeholder="Meta Title" value="${p.meta_title || ''}">
                                <input type="text" name="batch[${i}][meta_keyword]" class="form-control form-control-sm mb-2" placeholder="Meta Keywords" value="${p.meta_keyword || ''}">
                                <textarea name="batch[${i}][meta_description]" class="form-control form-control-sm" placeholder="Meta Description" rows="2">${p.meta_description || ''}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $('#saveBtn').show();
    }
</script>
<?= $this->endSection() ?>