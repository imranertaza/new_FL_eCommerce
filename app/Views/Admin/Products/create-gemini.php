<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <section class="content-header">

        <div class="container-fluid">
            <div class="row ">

                <div class="col-sm-6">
                    <h1>Product Create (Gemini AI)</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Product Create</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="">
            <a href="<?= base_url('products') ?>" class="btn btn-dark btn-sm mt-3">← Back</a>
        </div>
    </section>

    <div class="col-md-12" style="margin-top: 10px">
        <div id="ajax-alert-container"></div>
        <?php if (session()->getFlashdata('message') !== NULL):
            echo session()->getFlashdata('message');
        endif; ?>
    </div>

    <section class="content">
        <div class="card card-primary card-outline shadow-sm" style="border-top: 3px solid #007bff;">
            <div class="card-header bg-white">
                <h3 class="card-title text-primary font-weight-bold">
                    <i class="fas fa-magic mr-2"></i> Bulk AI Product Generator
                </h3>
            </div>
            <div class="card-body">

                <input type="hidden" id="global-csrf" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                <div class="gemini-upload-zone mb-4" onclick="document.getElementById('product_images').click()">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <h5>Select multiple images here</h5>
                    <p class="text-muted">Gemini AI will automatically extract product details from your remaining images.</p>
                    <input type="file" id="product_images" multiple class="d-none" onchange="handleFileSelection(this)">
                </div>

                <div id="imageQueue" class="row mb-4"></div>

                <div class="form-group">
                    <label for="analyzePrompt" class="font-weight-bold small text-uppercase">AI Prompt</label>
                    <textarea id="analyzePrompt" name="analyzePrompt" class="form-control" rows="4" placeholder="Enter your analyze prompt here..."><?= get_product_image_analyze_prompt(); ?></textarea>
                </div>
                <div class="text-center">
                    <button type="button" id="btnAnalyze" class="btn btn-primary btn-lg px-5 shadow-sm" onclick="analyzeAllImages()">
                        <i class="fas fa-robot mr-2"></i> Start AI Analysis
                    </button>
                </div>

                <hr class="my-5">

                <div id="productFormsContainer"></div>
            </div>
            <div class="col-sm-12 mb-3">
                <a href="<?= base_url('products') ?>" class="btn btn-dark btn-sm mt-3">← Back</a>
            </div>
        </div>
    </section>

    <script id="brands-data" type="application/json">
        <?= json_encode($brands ?? []); ?>
    </script>

    <div class="form-group category d-none">
        <label>Category <span class="requi">*</span></label>
        <select class="select2bs4" name="categorys[]" multiple="multiple" style="width: 100%;">
            <?php foreach ($prodCat as $cat) { ?>
                <option value="<?php echo $cat->prod_cat_id; ?>">
                    <?php echo display_category_with_parent($cat->prod_cat_id); ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group mb-2 brand d-none">
        <label>Brand</label>
        <select name="brand_id" class="form-control select2bs4">
            <option value="">Please select</option>
            <?php foreach ($brands as $brand) { ?>
                <option value="<?php echo $brand->brand_id; ?>"><?php echo $brand->name; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
<script>
    // In-memory array holding your selected files so we can add/remove items freely
    let selectedFilesQueue = [];

    function handleFileSelection(input) {
        if (!input.files) return;

        // Convert FileList to Array and merge it into our tracking queue
        Array.from(input.files).forEach(file => {
            // Assign a temporary unique timestamp reference to target it for removal later
            file.queueId = 'q_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            selectedFilesQueue.push(file);
        });

        // Re-render the visual list layout
        renderQueuePreviews();

        // Reset the raw input element so selecting the exact same file layout updates cleanly
        input.value = '';
    }

    function renderQueuePreviews() {
        let container = $('#imageQueue').empty();

        selectedFilesQueue.forEach((file, index) => {
            let reader = new FileReader();
            reader.onload = (e) => {
                let col = $(`
                    <div class="col-md-2 col-sm-4 queue-item" id="${file.queueId}">
                        <button type="button" class="remove-queue-btn" title="Remove image">&times;</button>
                        <img src="${e.target.result}" class="img-thumbnail">
                        <div class="small text-muted text-truncate mt-1">${file.name}</div>
                    </div>
                `);

                // Event listener to wipe item out of queue dynamically
                col.find('.remove-queue-btn').on('click', function() {
                    removeFileFromQueue(file.queueId);
                });

                container.append(col);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeFileFromQueue(queueId) {
        // Filter array memory record down to unselected assets
        selectedFilesQueue = selectedFilesQueue.filter(file => file.queueId !== queueId);
        // Fade out element smoothly, then wipe structural node from DOM layout
        $('#' + queueId).fadeOut(200, function() {
            $(this).remove();
        });
    }

    function analyzeAllImages() {
        if (selectedFilesQueue.length === 0) {
            alert('Please select at least one image to process.');
            return;
        }

        let analyzePrompt = $('#analyzePrompt').val();
        let formData = new FormData();
        formData.append('analyzePrompt', analyzePrompt);
        let metadata = [];

        // Build FormData payload strictly using our managed tracking queue array
        selectedFilesQueue.forEach((file, i) => {
            let uniqueId = 'img_' + Date.now() + '_' + i;
            formData.append('images[]', file); // Maps directly to CodeIgniter 4 Multiple File Upload array structure
            metadata.push({
                unique_id: uniqueId,
                original_index: i,
                file_name: file.name,
                image_type: file.type
            });
        });

        formData.append('metadata', JSON.stringify(metadata));
        formData.append($('#global-csrf').attr('name'), $('#global-csrf').val());

        let categoryOptions = [];
        $('.category .select2bs4 option').each(function() {
            let id = $(this).val();
            let name = $(this).text().trim();
            if (id) {
                categoryOptions.push({
                    id: id,
                    name: name
                });
            }
        });
        let brandOptions = [];
        $('.brand .select2bs4 option').each(function() {
            let id = $(this).val();
            let name = $(this).text().trim();
            if (id) {
                brandOptions.push({
                    id: id,
                    name: name
                });
            }
        });

        formData.append('available_brands', JSON.stringify(brandOptions));
        formData.append('available_categories', JSON.stringify(categoryOptions));

        $('#productFormsContainer').html(`
            <div class="text-center py-5 ai-analyzing">
                <i class="fas fa-robot fa-4x text-primary mb-3"></i>
                <h4 class="text-primary">Gemini is analyzing your images...</h4>
                <p class="text-muted">This may take a few moments depending on the number of images.</p>
                <div class="progress progress-sm mt-3 mx-auto" style="max-width: 400px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        `);
        btnAnalyze = $('#btnAnalyze');
        btnAnalyze.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Analyzing...');
        $.ajax({
            url: "<?= base_url('product-ai-analyze-batch') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#global-csrf').val(res.csrfHash);
                    btnAnalyze.prop('disabled', false).html(' Analyzed successfully');
                    let productsWithPreview = res.products.map((p, i) => ({
                        ...p,
                        unique_id: metadata[i].unique_id,
                        file_name: metadata[i].file_name,
                        image: URL.createObjectURL(selectedFilesQueue[i])
                    }));
                    renderBatchForms(productsWithPreview, categoryOptions, selectedFilesQueue);
                } else {
                    alert(res.message || 'Something went wrong');
                    $('#productFormsContainer').empty();
                }
            },
            error: function(res) {
                let message = 'Request failed. Please try again.';
                if (res?.responseJSON?.message) message = res.responseJSON.message;
                alert(message);
                $('#productFormsContainer').empty();
            }
        });
    }

    function previewBatchImage(input, index) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('.img-preview-' + index).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function renderBatchForms(products, categoryOptions, originalFiles) {
        let container = $('#productFormsContainer').empty();

        products.forEach((p, i) => {
            let categoryHtml = categoryOptions.map(cat => {
                let catId = cat.id.toString();
                let isSelected = p.category_ids && (p.category_ids.includes(parseInt(catId)) || p.category_ids.includes(catId)) ? 'selected' : '';
                return '<option value="' + cat.id + '" ' + isSelected + '>' + cat.name + '</option>';
            }).join('');

            let productName = p.name ? p.name.replace(/"/g, '&quot;') : 'New Product';
            let productAlt = p.alt_name ? p.alt_name : '';
            let productModel = p.model ? p.model : '';
            let productDesc = p.description ? p.description : '';
            let productBrand = p.brand_id ? p.brand_id : '';
            let productPrice = p.price ? p.price : '';
            let productWeight = p.weight ? p.weight : '';
            let productTags = p.tags ? p.tags : '';
            let metaTitle = p.meta_title ? p.meta_title : '';
            let metaKeyword = p.meta_keyword ? p.meta_keyword : '';
            let metaDesc = p.meta_description ? p.meta_description : '';
            let pImage = p.image ? p.image : '';

            // Standard clean concatenation strings used to fully avoid script rendering engine drops
            let htmlCard = '<form class="product-individual-save-form">' +
                '<div class="card product-card card-outline card-info shadow-sm mb-5 batch-card">' +
                '<div class="card-header border-0 bg-light">' +
                '<h3 class="card-title font-weight-bold text-info">' +
                '<span class="badge badge-info mr-2">Product #' + (i + 1) + '</span>' +
                productName +
                '</h3>' +
                '<div class="card-tools">' +
                '<span class="status-msg mr-2 font-weight-bold" style="display:none;"></span>' +
                '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
                '<button type="button" class="btn btn-tool text-danger remove-card"><i class="fas fa-times"></i></button>' +
                '</div>' +
                '</div>' +
                '<div class="card-body pt-3">' +
                '<div class="row">' +
                '<div class="col-md-3 border-right">' +
                '<div class="form-group mb-2">' +
                '<label class="small text-muted text-uppercase font-weight-bold mb-1">Product Image</label>' +
                '<div class="p-2 border rounded bg-white text-center" style="height: 250px; display: flex; align-items: center; justify-content: center;">' +
                (pImage ? '<img src="' + pImage + '" class="img-fluid img-preview-' + i + '" style="max-height:250px;">' : '<div class="text-muted small"><i class="fas fa-image fa-3x mb-2 d-block"></i> No image</div>') +
                '</div>' +
                '</div>' +

                '<input type="file" name="image" class="d-none" onchange="previewBatchImage(this, ' + i + ')">' +
                '<div class="p-2 bg-light rounded border">' +
                '<div class="form-group">' +
                '<label class="small font-weight-bold">Model</label>' +
                '<input type="text" name="model" class="form-control" value="' + productModel + '" placeholder="Model...">' +
                '</div>' +
                '<div class="form-group mb-2">' +
                '<label>Brand</label>' +
                '<select name="brand_id" class="form-control select2bs4">' +
                '<option value="">Please select</option>' +
                '<?php foreach ($brands as $brand) { ?>' +
                '<option value="<?php echo $brand->brand_id; ?>" ' + (productBrand == "<?php echo $brand->brand_id; ?>" ? "selected" : "") + '><?php echo $brand->name; ?></option>' + '<?php } ?>' +
                '</select>' +
                '</div>' +

                '<div class="form-group mb-2">' +
                '<label class="small font-weight-bold mb-1">Price <span class="text-danger">*</span></label>' +
                '<input type="number" name="price" min="0" step="0.01" class="form-control form-control-sm" value="" required>' +
                '<small>Recommended Price $' + productPrice + '</small>' +
                '</div>' +
                '<div class="form-group mb-2">' +
                '<label class="small font-weight-bold mb-1">Weight (kg)</label>' +
                '<input type="text" name="weight" class="form-control form-control-sm" value="' + productWeight + '">' +
                '</div>' +
                '<div class="form-group mb-2">' +
                '<label class="small font-weight-bold mb-1">Qty <span class="text-danger">*</span></label>' +
                '<input type="number" name="quantity" class="form-control form-control-sm" value="18" min="0" required>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-9">' +
                '<div class="row">' +
                '<div class="col-md-12">' +
                '<div class="form-group">' +
                '<label class="small font-weight-bold">Product Name <span class="text-danger">*</span></label>' +
                '<input type="text" name="name" class="form-control" value="' + productName + '" placeholder="Enter product name..." required>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-12">' +
                '<div class="form-group">' +
                '<label class="small font-weight-bold">Image Alt Name <span class="text-danger">*</span></label>' +
                '<input type="text" name="alt_name" class="form-control" value="' + productAlt + '" placeholder="Image Alt Name..." required>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-12">' +
                '<div class="form-group mb-2">' +
                '<label class="small font-weight-bold">Description <span class="text-danger">*</span></label>' +
                '<textarea name="description" class="form-control editor" rows="4" placeholder="AI generated description..." required>' + productDesc + '</textarea>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-12">' +
                '<div class="form-group mb-2">' +
                '<label class="small font-weight-bold">Categories <span class="text-danger">*</span></label>' +
                '<select class="form-control select2bs4" name="categorys[]" multiple="multiple" data-placeholder="Select Categories" style="width: 100%;" required>' +
                categoryHtml +
                '</select>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="form-group mb-2">' +
                '<label class="small font-weight-bold">Tags <small>(comma separated)</small></label>' +
                '<input type="text" name="tags" class="form-control" value="' + productTags + '" placeholder="tags...">' +
                '</div>' +
                '<div class="seo-settings border-top mt-2 pt-2">' +
                '<h6 class="small font-weight-bold text-muted mb-2"><i class="fas fa-search mr-1 text-info"></i> SEO Settings</h6>' +
                '<div class="row">' +
                '<div class="col-md-12">' +
                '<div class="form-group mb-2">' +
                '<label class="small font-weight-bold">Meta Title</label>' +
                '<input type="text" name="meta_title" class="form-control form-control-sm" placeholder="Meta Title" value="' + metaTitle + '">' +
                '</div>' +
                '<div class="form-group mb-2">' +
                '<label class="small font-weight-bold">Meta Keywords</label>' +
                '<input type="text" name="meta_keyword" class="form-control form-control-sm" placeholder="Meta Keywords" value="' + metaKeyword + '">' +
                '</div>' +
                '</div>' +
                '<div class="col-md-12">' +
                '<div class="form-group mb-0">' +
                '<label class="small font-weight-bold">Meta Description</label>' +
                '<textarea name="meta_description" class="form-control form-control-sm" placeholder="Meta Description" rows="2">' + metaDesc + '</textarea>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="text-right border-top mt-3 pt-2">' +
                '<button type="submit" class="btn btn-info btn-sm update-single-btn px-4">' +
                '<i class="fas fa-save mr-1"></i> Save This Product' +
                '</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</form>';

            container.append(htmlCard);

            if (originalFiles && originalFiles[i]) {
                const fileInput = document.querySelectorAll('input[name="image"]')[i];
                if (fileInput) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(originalFiles[i]);
                    fileInput.files = dataTransfer.files;
                }
            }
        });
        container.append('<div class="text-center mt-4"><button type="button" id="btnSaveAll" class="btn btn-success btn-lg px-5 shadow-sm" onclick="saveAllProducts()"><i class="fas fa-save mr-2"></i> Save All Products</button></div>');

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        $('.editor').summernote({
            height: 180
        });
    }
    $(document).on('submit', '.product-individual-save-form', function(e) {
        e.preventDefault();

        const $form = $(this);
        const $btn = $form.find('.update-single-btn');
        const $statusMsg = $form.find('.status-msg');

        let formData = new FormData(this);
        formData.append($('#global-csrf').attr('name'), $('#global-csrf').val());

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        $statusMsg.removeClass('text-success text-danger').css('display', 'inline-block').html('<span class="text-muted">Saving...</span>');

        $.ajax({
            url: "<?= base_url('product-create-gemini') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.csrf_hash) {
                    $('#global-csrf').val(response.csrf_hash);
                }

                if (response.status === 'success' || response.success === true) {
                    $statusMsg.html('<span class="text-success"><i class="fas fa-check-circle"></i> Saved!</span>');
                    showAlert('success', response.message || 'Product created successfully!');

                    $form.delay(600).fadeOut(500, function() {
                        $(this).remove();
                        if ($('.product-individual-save-form').length === 0) {
                            location.href = '<?= base_url('products') ?>';
                        }
                    });
                } else {
                    $statusMsg.html('<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Failed</span>');
                    showAlert('danger', response.message || 'An error occurred during verification.');
                    $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save This Product');
                }
            },
            error: function(xhr) {
                $statusMsg.html('<span class="text-danger"><i class="fas fa-times"></i> Error</span>');
                showAlert('danger', 'Server communication failure.');
                $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save This Product');
            }
        });
    });

    $(document).on('click', '.remove-card', function() {
        $(this).closest('.product-individual-save-form').remove();
        if ($('.product-individual-save-form').length === 0) {
            location.reload();
        }
    });

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        $('#ajax-alert-container').html(alertHtml);
        setTimeout(() => {
            $(".alert").alert('close');
        }, 5000);
    }

    // save all products
    function saveAllProducts() {
        const forms = $('.product-individual-save-form');
        if (forms.length === 0) {
            alert('There are no product forms available to save.');
            return;
        }

        // Basic HTML5 validation check across all fields
        let isValid = true;
        forms.each(function() {
            if (!this.checkValidity()) {
                this.reportValidity();
                isValid = false;
                return false; // break loop
            }
        });
        if (!isValid) return;

        const $btn = $('#btnSaveAll');
        const globalCsrfName = $('#global-csrf').attr('name');
        const globalCsrfHash = $('#global-csrf').val();

        // 1. Create a transient master form element invisible to the user
        const masterForm = document.createElement('form');
        masterForm.method = 'POST';
        masterForm.action = "<?= base_url('product-create-gemini-all') ?>";
        masterForm.enctype = 'multipart/form-data';
        masterForm.style.display = 'none';

        // 2. Inject your global security CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = globalCsrfName;
        csrfInput.value = globalCsrfHash;
        masterForm.appendChild(csrfInput);

        // 3. Process each individual product form card
        forms.each(function(index, formEl) {
            // Collect all standard input elements except files
            $(formEl).find('input, select, textarea').each(function() {
                const input = this;

                if (input.type === 'file') {
                    // Skip files here; handled separately via deep clone next
                    return;
                }

                if ((input.type === 'checkbox' || input.type === 'radio') && !input.checked) {
                    return;
                }

                // Correct mapping naming structures for batch processing matching your controller
                let inputName = input.name;
                if (inputName.endsWith('[]')) {
                    inputName = `batch[${index}][category_ids][]`;
                } else {
                    inputName = `batch[${index}][${inputName}]`;
                }

                // Handle multi-select inputs cleanly
                if (input.tagName === 'SELECT' && input.multiple) {
                    $(input).val().forEach(function(val) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = inputName;
                        hiddenInput.value = val;
                        masterForm.appendChild(hiddenInput);
                    });
                } else {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = inputName;
                    hiddenInput.value = input.value;
                    masterForm.appendChild(hiddenInput);
                }
            });

            // 4. Safely migrate file data by cloning the file nodes
            $(formEl).find('input[type="file"]').each(function() {
                if (this.files && this.files.length > 0) {
                    const clonedFileInput = this.cloneNode();
                    clonedFileInput.name = `batch[${index}][image]`;
                    // Data Transfer link ensures file streams match properly
                    clonedFileInput.files = this.files;
                    masterForm.appendChild(clonedFileInput);
                }
            });
        });

        // 5. Freeze UI interactions to show loading state before redirection happens
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Saving All Products...');
        $('.update-single-btn').prop('disabled', true);

        // 6. Bind form to document framework and execute submission pipeline
        document.body.appendChild(masterForm);
        masterForm.submit();
    }
</script>
<?= $this->endSection() ?>