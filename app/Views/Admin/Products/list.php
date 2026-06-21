<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Product List</li>
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
                    <div class="col-md-4">
                        <h3 class="card-title">Product List</h3>
                    </div>
                    <div class="col-md-8">
                        <form id="multisubmitform" action="<?php echo base_url('product_copy_action'); ?>" method="post">
                            <?= csrf_field() ?>
                            <a href="<?php echo base_url('product_create') ?>" class="mr-2 mt-2 btn btn-primary btn-xs float-right"><i class="fas fa-plus"></i> Add</a>
                            <a href="<?php echo base_url('product_create_gemini') ?>" class="mr-2 mt-2 btn btn-primary btn-xs float-right"><i class="fas fa-plus"></i> Add with Gemini ✦ </a>
                            <?php if (modules_key_by_access('bulk_edit_products') == '1') { ?>
                                <a href="<?php echo base_url('bulk_edit_products') ?>" onclick="bulk_datatable_reset()" class=" mt-2 btn btn-info btn-xs float-right mr-2"><i class="fas fa-plus"></i> Bulk Edit Products</a>
                            <?php } ?>
                            <?php if (modules_key_by_access('bulk_edit_products') == '1') { ?>
                                <button type="button" id="btnGeminiMultiEdit" class=" mt-2 btn btn-info btn-xs float-right mr-2"><i class="fas fa-edit"></i> Multi Edit with Gemini ✦</button> <?php } ?>

                            <!-- <button type="button" id="btnGeminiMultiEdit" class=" mt-2 btn btn-info btn-xs float-right mr-2"><i class="fas fa-edit"></i> Multi Edit with Gemini ✦</button> //<?php //} 
                                                                                                                                                                                                    ?> -->
                            <button type="submit" class=" mt-2 btn btn-secondary btn-xs float-right mr-2"><i class="nav-icon fas fa-copy"></i> Copy</button>
                            <?php if (modules_key_by_access('image_crop') == '1') { ?>
                                <button type="submit" formaction="<?php echo base_url('product_image_crop_action'); ?>" class=" mt-2 btn btn-info btn-xs float-right mr-2"><i class="fas fa-file"></i> Crop image</button>
                            <?php } ?>
                            <?php if (modules_key_by_access('multi_status_update') == '1') { ?>
                                <button type="submit" id="save" formaction="<?php echo base_url('product_status_update'); ?>" class=" mt-2 btn btn-primary btn-xs float-right mr-2"><i class="fas fa-file"></i> Status update</button>
                            <?php } ?>
                            <?php if (modules_key_by_access('multi_delete') == '1') { ?>
                                <button type="submit" formaction="<?php echo base_url('product_multi_delete_action'); ?>" class=" mt-2 btn btn-danger btn-xs float-right mr-2"><i class="fas fa-trash"></i> Multi delete</button>
                            <?php } ?>
                            <?php if (modules_key_by_access('remove_cropped_images') == '1') { ?>
                                <button type="submit" formaction="<?php echo base_url('remove_cropped_images_action'); ?>" class=" mt-2 btn btn-warning btn-xs float-right mr-2"><i class="fas fa-trash"></i> Remove Cropped Image</button>
                            <?php } ?>
                            <?php if (modules_key_by_access('remove_watermark_images') == '1') { ?>
                                <button type="submit" formaction="<?php echo base_url('remove-watermark-images-action'); ?>" class=" mt-2 btn btn-info btn-xs float-right mr-2"><i class="fas fa-trash"></i> Remove Watermark Image</button>
                            <?php } ?>
                        </form>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px" id="message">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message');
                        endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <?php echo $links; ?>
                </div>
                <form id="tableForm" action="<?php echo base_url('products') ?>" method="GET">
                    <?= csrf_field() ?>
                    <div class="row mb-3 mt-3">
                        <div class="col-md-2 mx-auto">

                            <label class="d-flex p-1 tab-lab">
                                Show
                                <select name="length" class="tables_length custom-select-sm mx-2" onchange="table_form_submit()">
                                    <option value="10" <?= ($length == 10) ? 'selected' : ''; ?>>10</option>
                                    <option value="25" <?= ($length == 25) ? 'selected' : ''; ?>>25</option>
                                    <option value="50" <?= ($length == 50) ? 'selected' : ''; ?>>50</option>
                                    <option value="100" <?= ($length == 100) ? 'selected' : ''; ?>>100</option>
                                </select>
                                entries
                            </label>

                        </div>
                        <div class="col-md-7 mx-auto"></div>
                        <div class="col-md-3 mx-auto">
                            <div class="input-group ">
                                <lable class="tab-lab">Search:</lable>
                                <input name="keyWord" class="form-control form-control-sm border-end-0 border search-tab ml-2" oninput="table_form_submit()" type="search" value="<?= $keyWord ?>" id="example-search-input">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" onclick="allchecked(this)"></th>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Model</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($product as $key => $val) { ?>
                                <tr id="hide_<?php echo $val->product_id; ?>">
                                    <td width="10">
                                        <input type="checkbox" class="product-select-checkbox" name="productId[]" value="<?php echo $val->product_id; ?>" form="multisubmitform" onclick="toggleImageInput(this, '<?php echo $val->product_id; ?>', '<?php echo $val->image; ?>','<?php echo $val->price; ?>','<?php echo $val->quantity; ?>')">
                                    </td>
                                    <td><?php echo $i++; ?></td>
                                    <td width="50"><img data-sizes="auto" id="" src="<?php echo product_image_view('uploads/products', $val->product_id, $val->image, 'noimage.png',  '50', '50') ?>" alt="<?php echo $val->alt_name ?>" class="img-fluid" loading="lazy"></td>
                                    <td><?php echo $val->name; ?></td>
                                    <td><?php echo $val->model; ?></td>
                                    <td> <?php echo $val->quantity; ?></td>
                                    <td> <?php echo $val->status; ?></td>
                                    <td width="140">
                                        <a href="<?php echo base_url('product_update/' . $val->product_id) ?>" class="btn btn-sm btn-info">Edit</a>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="product_delete('<?php echo $val->product_id; ?>')">delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>

                <div class="col-md-12">
                    <?php echo $links; ?>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <!--                --><?php //echo $total; 
                                        ?>
                <?php //echo $links; 
                ?>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

        <div class="modal fade" id="geminiPromptModal" tabindex="-1" aria-labelledby="geminiPromptModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius: 0px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="geminiPromptModalLabel">Gemini Multi Update Prompt</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group"> <label for="geminiInstructions">AI Prompt:</label>
                            <textarea class="form-control" id="geminiInstructions" rows="4" placeholder="e.g., Reduce price by 10%..." style="border-radius: 0px;"> <?= get_product_image_analyze_prompt() ?> </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 0px;">Cancel</button>
                        <button type="button" id="btnSubmitGeminiGet" class="btn btn-dark" style="border-radius: 0px;">Submit Update</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
<script>
    function allchecked(source) {
        const isChecked = source.checked;

        // Target only the row checkboxes to avoid targeting layout control nodes
        $('.product-select-checkbox').each(function() {
            const cb = this; // Raw DOM element
            const $cb = $(cb);

            // Only change status and trigger update if the row state needs synchronization
            if ($cb.prop('checked') !== isChecked) {
                $cb.prop('checked', isChecked);

                // Directly read the custom metadata args right from your HTML layout definition string
                // and pass them explicitly to your toggle engine without forcing DOM click cascades
                const onclickAttr = $cb.attr('onclick');
                if (onclickAttr) {
                    // Parse out the clean variable arguments defined inside the toggleImageInput() string
                    const match = onclickAttr.match(/toggleImageInput\s*\(([^)]+)\)/);
                    if (match && match[1]) {
                        // Split arguments by comma, map clean trims, and evaluate safe value states
                        const args = match[1].split(',').map(arg => {
                            let cleanArg = arg.trim();
                            if (cleanArg === 'this') return cb;
                            // Strip wrapping quotes to sanitize raw parameters
                            return cleanArg.replace(/^['"]|['"]$/g, '');
                        });

                        // Execute data array bindings seamlessly
                        toggleImageInput(args[0], args[1], args[2], args[3], args[4]);
                    }
                }
            }
        });
    }

    function product_delete(id) {
        if (confirm('Do you want to delete it?')) {
            let csrfName = $('meta[name="csrf-name"]').attr('content');
            let csrfHash = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('product_delete') ?>",
                data: {
                    [csrfName]: csrfHash,
                    product_id: id
                },
                beforeSend: function() {
                    $("#loading-image").show();
                },
                success: function(data) {
                    $("#message").html(data);
                    $('#hide_' + id).hide('slow');
                }
            });
        }
    }

    function toggleImageInput(checkbox, productId, imageName, priceValue, quantityValue) {
        const form = document.getElementById('multisubmitform');
        if (!form) return;

        const imgId = 'imgInput_' + productId;
        const priceId = 'price_' + productId;
        const qtyId = 'quantity_' + productId;

        if (checkbox.checked) {
            let imgInput = document.getElementById(imgId);
            if (!imgInput) {
                imgInput = document.createElement('input');
                imgInput.type = 'hidden';
                imgInput.className = 'gemini-temp-input'; // utility flag class
                imgInput.name = 'productImage[' + productId + ']';
                imgInput.value = imageName;
                imgInput.id = imgId;
                form.appendChild(imgInput);
            }

            let priceInput = document.getElementById(priceId);
            if (!priceInput) {
                priceInput = document.createElement('input');
                priceInput.type = 'hidden';
                priceInput.className = 'gemini-temp-input';
                priceInput.name = 'productPrice[' + productId + ']';
                priceInput.id = priceId;
                form.appendChild(priceInput);
            }
            priceInput.value = priceValue;

            let qtyInput = document.getElementById(qtyId);
            if (!qtyInput) {
                qtyInput = document.createElement('input');
                qtyInput.type = 'hidden';
                qtyInput.className = 'gemini-temp-input';
                qtyInput.name = 'productQuantity[' + productId + ']';
                qtyInput.id = qtyId;
                form.appendChild(qtyInput);
            }
            qtyInput.value = quantityValue;

        } else {
            const idsToRemove = [imgId, priceId, qtyId];
            idsToRemove.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.remove();
            });
        }
    }
    $(document).ready(function() {
        // Array to temporarily hold your key-value query string fragments
        let urlParams = [];

        // 1. Initial Click: Validate selection and open modal
        $('#btnGeminiMultiEdit').on('click', function(e) {
            e.preventDefault();

            let checkedBoxes = $('.product-select-checkbox:checked');

            if (checkedBoxes.length === 0) {
                alert('No products selected. Please check at least one product row.');
                return;
            }

            // Reset the parameters array on every click
            urlParams = [];

            // Build standard QueryString arguments safely
            checkedBoxes.each(function() {
                let prodId = $(this).val();
                urlParams.push('productId[]=' + encodeURIComponent(prodId));

                let imgVal = $('#imgInput_' + prodId).val() || '';
                let priceVal = $('#price_' + prodId).val() || '';
                let qtyVal = $('#quantity_' + prodId).val() || '';
                console.log(imgVal, priceVal, qtyVal);
                urlParams.push('productImage[' + prodId + ']=' + encodeURIComponent(imgVal));
                urlParams.push('productPrice[' + prodId + ']=' + encodeURIComponent(priceVal));
                urlParams.push('productQuantity[' + prodId + ']=' + encodeURIComponent(qtyVal));
            });

            // Clear previous input text and display the modal (BS4 Syntax)
            $('#geminiPromptModal').modal('show');
        });

        // 2. Modal Submission: Append prompt and execute standard GET redirect
        $('#btnSubmitGeminiGet').on('click', function() {
            let promptText = $('#geminiInstructions').val().trim();

            if (promptText === '') {
                alert('Please enter a prompt instruction before submitting.');
                return;
            }

            // Add the custom user prompt to the query string parameter array
            urlParams.push('gemini_prompt=' + encodeURIComponent(promptText));

            // Disable button to reflect submission state
            $(this).prop('disabled', true).text('Redirecting...');

            // Perform the standard window redirection using GET format
            let targetUrl = "<?php echo base_url('product-multi-update-with-gemini'); ?>?" + urlParams.join('&');
            window.location.href = targetUrl;
        });
    });
</script>
<?= $this->endSection() ?>