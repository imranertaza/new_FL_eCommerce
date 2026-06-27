<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
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
    </section>

    <div class="col-md-12" style="margin-top: 10px">
        <div id="ajax-alert-container"></div>
        <?php if (session()->getFlashdata('message') !== NULL):
            echo session()->getFlashdata('message');
        endif; ?>
    </div>

    <section class="content">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-primary font-weight-bold">
                    <i class="fas fa-magic mr-2"></i> Bulk AI Product Generator
                </h3>
            </div>
            <div class="card-body">

                <input type="hidden" id="global-csrf" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                <div class="gemini-upload-zone mb-4" onclick="document.getElementById('product_images').click()">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <h5>Drop multiple images here or click to upload</h5>
                    <p class="text-muted">Gemini AI will automatically extract product details from your images.</p>
                    <input type="file" name="product_images[]" id="product_images" multiple class="d-none" onchange="previewQueue(this)">
                </div>

                <div id="imageQueue" class="row mb-4"></div>

                <div class="text-center">
                    <button type="button" id="btnAnalyze" class="btn btn-primary btn-lg px-5 shadow-sm" onclick="analyzeAllImages()">
                        <i class="fas fa-robot mr-2"></i> Start AI Analysis
                    </button>
                </div>

                <hr class="my-5">

                <div id="productFormsContainer"></div>
            </div>
        </div>
    </section>

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
</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
<script>
    function previewQueue(input) {
        let container = $('#imageQueue').empty();
        Array.from(input.files).forEach(file => {
            let reader = new FileReader();
            reader.onload = (e) => {
                container.append('<div class="col-md-2"><img src="' + e.target.result + '" class="img-thumbnail mb-2"></div>');
            };
            reader.readAsDataURL(file);
        });
    }

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

                    let productsWithPreview = res.products.map((p, i) => ({
                        ...p,
                        unique_id: metadata[i].unique_id,
                        file_name: metadata[i].file_name,
                        image: URL.createObjectURL(input.files[i])
                    }));
                    renderBatchForms(productsWithPreview, categoryOptions, input.files);
                } else {
                    alert(res.message || 'Something went wrong');
                }
            },
            error: function(res) {
                let message = 'Request failed. Please try again.';
                if (res?.responseJSON?.message) message = res.responseJSON.message;
                else if (res?.responseText) message = res.responseText;
                alert(message);
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
                '<div class="p-2 border rounded bg-white text-center" style="height: 180px; display: flex; align-items: center; justify-content: center;">' +
                (pImage ? '<img src="' + pImage + '" class="img-fluid img-preview-' + i + '" style="max-height:160px;">' : '<div class="text-muted small"><i class="fas fa-image fa-3x mb-2 d-block"></i> No image</div>') +
                '</div>' +
                '</div>'+
                '<input type="file" name="image" class="d-none" onchange="previewBatchImage(this, ' + i + ')">' +
                '<div class="p-2 bg-light rounded border">' +
                '<div class="form-group mb-2">' +
                '<label class="small font-weight-bold mb-1">Qty <span class="text-danger">*</span></label>' +
                '<input type="number" name="quantity" class="form-control form-control-sm" value="18" min="0" required>' +
                '</div>' +
                '<div class="form-group mb-2">' +
                '<label class="small font-weight-bold mb-1">Price <span class="text-danger">*</span></label>' +
                '<input type="number" name="price" min="0" step="0.01" class="form-control form-control-sm" value="' + productPrice + '" required>' +
                '</div>' +
                '<div class="form-group mb-0">' +
                '<label class="small font-weight-bold mb-1">Weight (kg)</label>' +
                '<input type="text" name="weight" class="form-control form-control-sm" value="' + productWeight + '">' +
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
                '<label class="small font-weight-bold">Alt Name <span class="text-danger">*</span></label>' +
                '<input type="text" name="alt_name" class="form-control" value="' + productAlt + '" placeholder="Alt Name..." required>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-12">' +
                '<div class="form-group">' +
                '<label class="small font-weight-bold">Model</label>' +
                '<input type="text" name="model" class="form-control" value="' + productModel + '" placeholder="Model...">' +
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
                '<div class="form-group mb-2">' +
                '<label class="small font-weight-bold">Tags <small>(comma separated)</small></label>' +
                '<input type="text" name="tags" class="form-control" value="' + productTags + '" placeholder="tags...">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="seo-settings border-top mt-2 pt-2">' +
                '<h6 class="small font-weight-bold text-muted mb-2"><i class="fas fa-search mr-1 text-info"></i> SEO Settings</h6>' +
                '<div class="row">' +
                '<div class="col-md-12">' +
                '<div class="form-group mb-2">' +
                '<input type="text" name="meta_title" class="form-control form-control-sm" placeholder="Meta Title" value="' + metaTitle + '">' +
                '</div>' +
                '<div class="form-group mb-2">' +
                '<input type="text" name="meta_keyword" class="form-control form-control-sm" placeholder="Meta Keywords" value="' + metaKeyword + '">' +
                '</div>' +
                '</div>' +
                '<div class="col-md-12">' +
                '<div class="form-group mb-0">' +
                '<textarea name="meta_description" class="form-control form-control-sm" placeholder="Meta Description" rows="2">' + metaDesc + '</textarea>' +
                '</div>' +
                '</div>' +
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

        const csrfName = $('#global-csrf').attr('name');
        const csrfHash = $('#global-csrf').val();
        formData.append(csrfName, csrfHash);

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
                    });p
                } else {
                    $statusMsg.html('<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Failed</span>');
                    showAlert('danger', response.message || 'An error occurred during verification.');
                    $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save This Product');
                }
            },
            error: function(xhr) {
                $statusMsg.html('<span class="text-danger"><i class="fas fa-times"></i> Error</span>');
                showAlert('danger', 'Server communication failure. Please check logs.');
                $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save This Product');
                console.error(xhr.responseText);
            }
        });
    });

    $(document).on('click', '.remove-card', function() {
        $(this).closest('.product-individual-save-form').remove();
        if ($('.product-individual-save-form').length === 0) {
            location.reload();
        }
    });

    // Helper notification renderer
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
</script>
<?= $this->endSection() ?>