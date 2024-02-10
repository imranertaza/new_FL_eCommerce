
<form id="categoryForm" action="<?php echo base_url('bulk_category_update') ?>" data-row="update_<?php echo $product_id;?>" method="post">
    <div class="modal-header">
        <h4 class="modal-title">Default Modal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" >
        <div class="form-group category">
            <label>Category <span class="requi">*</span></label>
            <select class="select2bs4" name="categorys[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" required>
                <?php foreach ($prodCat as $key => $cat) { ?>
                    <option value="<?php echo $cat->prod_cat_id;?>" <?php foreach ($prodCatSel as $valC) { echo ($valC->category_id == $cat->prod_cat_id) ? 'selected' : '';}?> ><?php display_category_with_parent($cat->prod_cat_id);?></option>
                <?php } ?>
            </select>
            <input type="hidden" name="product_id" class="form-control mb-2" value="<?php echo $product_id;?>" >
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="categoryBulkUpdateAction()" class="btn btn-primary">Save
            changes</button>
    </div>
</form>