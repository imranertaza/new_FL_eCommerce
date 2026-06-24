<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Update (Gemini AI)</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Bulk Product Update</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="col-md-12 mt-3">
        <div id="ajax-alert-container"></div>
        
        <?php if (session()->getFlashdata('message') !== NULL): ?>
            <?= session()->getFlashdata('message') ?>
        <?php endif; ?>
    </div>

    <section class="content">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-primary font-weight-bold">
                    <i class="fas fa-magic mr-2"></i> Bulk AI Product Update
                </h3>
            </div>
            <div class="card-body">
                
                <input type="hidden" id="global-csrf" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                <div id="productFormsContainer">
                    <?php foreach ($products as $i => $p): ?>
                        <form class="product-ajax-form" data-index="<?= $i ?>">
                            <div class="card card-outline card-info shadow-sm mb-5 batch-card" id="product-card-<?= $i ?>">
                                
                                <div class="card-header border-0 bg-light">
                                    <h3 class="card-title font-weight-bold text-info">
                                        <span class="badge badge-info mr-2">Product #<?= $i + 1 ?></span>
                                        <?= esc($p['name'] ?? 'New Product') ?>
                                    </h3>
                                    <div class="card-tools">
                                        <span class="status-msg mr-2 font-weight-bold" style="display:none;"></span>
                                        
                                        <button type="button" class="btn btn-tool text-danger" onclick="removeProductCard(<?= $i ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body pt-3">
                                    <div class="row">
                                        
                                        <div class="col-md-3 border-right">
                                            <div class="form-group mb-2">
                                                <label class="small text-muted text-uppercase font-weight-bold mb-1">Product Image</label>
                                                <div class="p-2 border rounded bg-white text-center" style="height: 180px; display:flex; align-items:center; justify-content:center;">
                                                    <?php if (!empty($p['image'])): ?>
                                                        <img src="<?= product_image_view('uploads/products', $p['unique_id'], $p['image'], 'noimage.png', '100', '100') ?>"
                                                             class="img-fluid rounded" style="max-height: 160px; object-fit: contain;">
                                                    <?php else: ?>
                                                        <div class="text-muted">
                                                            <i class="fas fa-image fa-3x mb-1"></i><br>
                                                            <small>No image</small>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            
                                            <span class="img-price-notice text-center font-italic">
                                                <i class="fas fa-tag mr-1"></i> Recommended: <strong><?= esc($p['price'] ?? '0.00') ?></strong>
                                            </span>
                                            <input type="hidden" name="product_id" value="<?= esc($p['unique_id'] ?? '') ?>">

                                            <div class="p-2 bg-light rounded border">
                                                <div class="form-group mb-2">
                                                    <label class="small font-weight-bold mb-1">Qty</label>
                                                    <input type="number" name="quantity" class="form-control form-control-sm" value="18" min="0">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label class="small font-weight-bold mb-1">Price</label>
                                                    <input type="number" step="0.01" name="price" class="form-control form-control-sm" value="<?= esc($p['price'] ?? '') ?>" min="0">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label class="small font-weight-bold mb-1">Weight</label>
                                                    <input type="text" name="weight" class="form-control form-control-sm" value="<?= esc($p['weight'] ?? '') ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="small font-weight-bold">Product Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control" value="<?= esc($p['name'] ?? '') ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="small font-weight-bold">Alt Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="alt_name" class="form-control" value="<?= esc($p['alt_name'] ?? '') ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="small font-weight-bold">Model</label>
                                                        <input type="text" name="model" class="form-control" value="<?= esc($p['model'] ?? '') ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">Description</label>
                                                        <textarea name="description" class="form-control editor" rows="4"><?= esc($p['description'] ?? '') ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">Categories</label>
                                                        <select name="categorys[]" class="form-control select2bs4" multiple data-placeholder="Select Categories">
                                                            <?php foreach ($categories as $cat): ?>
                                                                <option value="<?= $cat['prod_cat_id'] ?>"
                                                                    <?= in_array($cat['prod_cat_id'], $p['category_ids'] ?? []) ? 'selected' : '' ?>>
                                                                    <?= esc(display_category_with_parent($cat['prod_cat_id'])) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">Tags <small>(comma separated)</small></label>
                                                        <input type="text" name="tags" class="form-control" value="<?= esc($p['tags'] ?? '') ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="seo-settings border-top mt-2 pt-2">
                                                <h6 class="small font-weight-bold text-muted mb-2"><i class="fas fa-search mr-1"></i> SEO Optimization Data</h6>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-2">
                                                            <input type="text" name="meta_title" class="form-control form-control-sm mb-2" value="<?= esc($p['meta_title'] ?? '') ?>" placeholder="Meta Title">
                                                            <input type="text" name="meta_keyword" class="form-control form-control-sm" value="<?= esc($p['meta_keyword'] ?? '') ?>" placeholder="Meta Keywords">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-0">
                                                            <textarea name="meta_description" class="form-control form-control-sm" rows="2" placeholder="Meta Description"><?= esc($p['meta_description'] ?? '') ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="text-right border-top mt-3 pt-2">
                                        <button type="submit" class="btn btn-info btn-sm update-single-btn px-4">
                                            <i class="fas fa-save mr-1"></i> Save Changes
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: "Select categories",
            allowClear: true
        });

        // Intercept individual form submissions via AJAX
        $('.product-ajax-form').on('submit', function(e) {
            e.preventDefault();

            const $form = $(this);
            const $btn = $form.find('.update-single-btn');
            const $statusMsg = $form.find('.status-msg');
            
            let formData = new FormData(this);
            
            const csrfName = $('#global-csrf').attr('name');
            const csrfHash = $('#global-csrf').val();
            formData.append(csrfName, csrfHash);

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
            $statusMsg.removeClass('text-success text-danger').css('display', 'inline-block').html('<span class="text-muted">Saving...</span>');

            $.ajax({
                url: "<?= base_url('product-gemini-update') ?>", 
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
                        showAlert('success', response.message || 'Product updated successfully!');
                        
                        // Smoothly animate and eliminate the active card component from viewport
                        $form.delay(800).fadeOut(600, function() {
                            $(this).remove();
                            if($('.batch-card').length === 0) {
                                location.href = '<?= base_url('products') ?>';
                            }

                        });
                    } else {
                        $statusMsg.html('<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Failed</span>');
                        showAlert('danger', response.message || 'An error occurred during update.');
                        // Re-enable button ONLY if validation/saving fails so the user can try again
                        $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Changes');
                    }
                },
                error: function(xhr, status, error) {
                    $statusMsg.html('<span class="text-danger"><i class="fas fa-times"></i> Error</span>');
                    showAlert('danger', 'Server communication failure. Please check logs.');
                    console.error(xhr.responseText);
                    // Re-enable button on complete crash
                    $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Changes');
                },
                complete: function() {
                    setTimeout(() => { $statusMsg.fadeOut(); }, 4000);
                }
            });
        });
    });

    function removeProductCard(index) {
        if (confirm('Are you sure you want to remove this product from the batch?')) {
            const card = document.getElementById(`product-card-${index}`);
            if (card) {
                $(card).closest('.product-ajax-form').remove();
            }
        }
    }

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
        setTimeout(() => { $(".alert").alert('close'); }, 5000);
    }
</script>
<?= $this->endSection() ?>