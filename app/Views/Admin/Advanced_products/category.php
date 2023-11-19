
<div class="form-group category">
    <label>Category <span class="requi">*</span></label>
    <select class="select2bs4" name="categorys[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" required>
        <?php foreach ($prodCat as $key => $cat) { ?>
            <option value="<?php echo $cat->prod_cat_id;?>" <?php foreach ($prodCatSel as $valC) { echo ($valC->category_id == $cat->prod_cat_id) ? 'selected' : '';}?> ><?php echo display_category_with_parent($cat->prod_cat_id);?></option>
        <?php } ?>
    </select>
    <input type="hidden" name="product_id" class="form-control mb-2" value="<?php echo $product_id;?>" >
</div>