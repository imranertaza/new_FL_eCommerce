<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<style>
    .gemini-upload-zone {
        border: 2px dashed #007bff;
        border-radius: 8px;
        padding: 40px;
        text-align: center;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .gemini-upload-zone:hover {
        background: #e9ecef;
        border-color: #0056b3;
    }

    .gemini-upload-zone i {
        font-size: 3rem;
        color: #007bff;
        margin-bottom: 15px;
    }

    .batch-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .batch-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
    }

    .ai-analyzing {
        animation: pulse-blue 2s infinite;
    }

    @keyframes pulse-blue {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.05);
            opacity: 0.8;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .status-badge {
        font-size: 0.8rem;
        padding: 0.4em 0.8em;
    }
</style>
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
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-primary font-weight-bold">
                    <i class="fas fa-magic mr-2"></i> Bulk AI Product Generator
                </h3>
            </div>
            <div class="card-body">


                <form id="productForm" action="<?= base_url('product_create_gemini_action') ?>" method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="gemini-upload-zone mb-4" onclick="document.getElementById('product_images').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <h5>Drop multiple images here or click to upload</h5>
                        <p class="text-muted">Gemini AI will automatically extract product details from your images.</p>
                        <input type="file" name="product_images[]" id="product_images" multiple class="d-none"
                            onchange="previewQueue(this)">
                    </div>

                    <div id="imageQueue" class="row mb-4"></div>

                    <div class="text-center">
                        <button type="button" id="btnAnalyze" class="btn btn-primary btn-lg px-5 shadow-sm"
                            onclick="analyzeAllImages()">
                            <i class="fas fa-robot mr-2"></i> Start AI Analysis
                        </button>
                    </div>

                    <hr class="my-5">
                    <div id="productFormsContainer"></div>

                    <div class="text-right mt-4" id="saveBtnContainer">
                        <button type="submit" class="btn btn-success btn-lg px-5 shadow" id="saveBtn">
                            <i class="fas fa-save mr-2"></i> Save All Products
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </section>
    <div class="form-group category d-none">
        <label>Category <span class="requi">*</span></label>
        <select class="select2bs4" name="categorys[]" multiple="multiple" data-placeholder="Select a State"
            style="width: 100%;" required>
            <?php foreach ($prodCat as $cat) { ?>
                <option value="<?php echo $cat->prod_cat_id; ?>">
                    <?php echo display_category_with_parent($cat->prod_cat_id); ?>
                </option>
            <?php } ?>

        </select>
    </div>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>


<script>

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
    $('#saveBtnContainer').hide();

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
            url: "<?= base_url('product_ai_analyze_batch') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    $('meta[name="csrf-token"]').attr('content', res.csrfHash);
                    $('input[name="<?= csrf_token() ?>"]').val(res.csrfHash);
                    let productsWithPreview = res.products.map((p, i) => ({
                        ...p,
                        unique_id: metadata[i].unique_id,     // Attach identifier
                        file_name: metadata[i].file_name,
                        image: URL.createObjectURL(input.files[i])
                    }));
                    renderBatchForms(productsWithPreview, categoryOptions, input.files);
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

    function renderBatchForms(products, categoryOptions, originalFiles) {
        let container = $('#productFormsContainer').empty();

        products.forEach((p, i) => {
            let categoryHtml = categoryOptions.map(cat => {
                let catId = cat.id.toString();
                let isSelected = p.category_ids && (p.category_ids.includes(parseInt(catId)) || p.category_ids.includes(catId)) ? 'selected' : '';
                return `<option value="${cat.id}" ${isSelected}>${cat.name}</option>`;
            }).join('');

            container.append(`
            <div class="card card-outline card-info shadow-sm mb-5 batch-card">
                <div class="card-header border-0">
                    <h3 class="card-title font-weight-bold text-info">
                        <span class="badge badge-info mr-2">Product #${i + 1}</span>
                        ${(p.name || 'New Product')}
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool text-danger" onclick="$(this).closest('.card').remove()"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <!-- Left Column: Image -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="small text-muted text-uppercase font-weight-bold">Product Image</label>
                                <div class="mb-2 p-1 border rounded bg-white shadow-sm text-center position-relative" style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                    <img src="${p?.image || ''}" class="img-fluid img-preview-${i}" style="max-height:180px; ${p?.image ? '' : 'display:none;'}">
                                    ${!p?.image ? `<div class="text-muted small"><i class="fas fa-image fa-3x mb-2 d-block"></i> No image</div>` : ''}
                                </div>
                                <button type="button" class="btn btn-xs btn-outline-secondary btn-block mt-2" onclick="$(this).next().click()">
                                    <i class="fas fa-sync-alt mr-1"></i> Change Image
                                </button>
                                <input type="file" name="batch[${i}][image]" class="d-none" onchange="previewBatchImage(this, ${i})">
                            </div>
                        </div>

                        <!-- Middle Column: Basic Details -->
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="small text-muted text-uppercase font-weight-bold">Product Name</label>
                                <input type="text" name="batch[${i}][name]" class="form-control form-control-lg border-primary-soft" value="${(p.name || '').replace(/"/g, '&quot;')}" placeholder="Enter product name...">
                            </div>
                           <div class="form-group">
                                <label class="small text-muted font-weight-bold">Model</label>
                                <input type="text" name="batch[${i}][model]" class="form-control form-control-sm" value="${(p.model || '')}" placeholder="Model...">
                            </div>
                            <div class="form-group">
                                <label class="small text-muted text-uppercase font-weight-bold">Description</label>
                                <textarea name="batch[${i}][description]" class="form-control" rows="4" placeholder="AI generated description...">${(p.description || '')}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="small text-muted text-uppercase font-weight-bold">Categories</label>
                                <select class="form-control select2bs4" name="batch[${i}][category_ids][]" multiple="multiple" style="width: 100%;">
                                    ${categoryHtml}
                                </select>
                            </div>
                        </div>

                        <!-- Right Column: Numbers & SEO -->
                        <div class="col-md-4 bg-light p-3 rounded">
                            <div class="row mb-3">
                                <div class="col-4">
                                    <div class="form-group mb-0">
                                        <label class="small text-muted font-weight-bold">Qty</label>
                                        <input type="number" name="batch[${i}][quantity]" class="form-control form-control-sm" value="18">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-0">
                                        <label class="small text-muted font-weight-bold">Price</label>
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="batch[${i}][price]" min="0" step="0.01" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-0">
                                        <label class="small text-muted font-weight-bold">Weight</label>
                                        <input type="text" name="batch[${i}][weight]" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="small text-muted font-weight-bold">Tags</label>
                                <input type="text" name="batch[${i}][tags]" class="form-control form-control-sm" value="${(p.tags || '')}" placeholder="comma separated...">
                            </div>

                            <div class="seo-settings border-top mt-3 pt-2">
                                <h6 class="small font-weight-bold text-muted mb-2"><i class="fas fa-search mr-1 text-info"></i> SEO Settings</h6>
                                <input type="text" name="batch[${i}][meta_title]" class="form-control form-control-sm mb-2" placeholder="Meta Title" value="${p.meta_title || ''}">
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

        $('#saveBtnContainer').show();

        // Assign original files to each product card's file input
        if (originalFiles) {
            products.forEach((p, i) => {
                const fileInput = document.querySelector(`input[name="batch[${i}][image]"]`);
                if (fileInput && originalFiles[i]) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(originalFiles[i]);
                    fileInput.files = dataTransfer.files;
                }
            });
        }
    }
</script>
<?= $this->endSection() ?>