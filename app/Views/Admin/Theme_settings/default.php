<div class="row">
<div class="col-md-6 ">
        <form action="<?php echo base_url('home_category') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Home category</label>
                <select name="home_category" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                        $catSel = get_lebel_by_value_in_theme_settings('home_category');
                        $cat = get_all_data_array('cc_product_category');
                        foreach ($cat as $val){
                    ?>
                    <option value="<?php echo $val->prod_cat_id;?>"
                        <?php echo ($val->prod_cat_id == $catSel)?'selected':'';?>><?php echo display_category_with_parent($val->prod_cat_id);?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
        
        <form action="<?php echo base_url('home_category_banner') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group mt-5">
                <?php
                    $banner_1 = get_lebel_by_value_in_theme_settings('home_category_banner');
                    echo image_view('uploads/category_banner', '', $banner_1, 'noimage.png', 'w-25');
                ?>
            </div>
            <div class="form-group">
                <label>Home Category Banner</label>
                <br>
                <small>width-280 x height-440</small>
                <input type="file" name="home_category_banner" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="col-md-6">
    <form action="<?php echo base_url('settings_update') ?>" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label>Featured Products Limit</label>
    <input type="number" name="value" class="form-control"
        value="<?php echo get_lebel_by_value_in_theme_settings('featured_products_limit');?>" required>
    <input type="hidden" name="label" value="featured_products_limit" required>
</div>

<button class="btn btn-primary">Save</button>
</form>

        

        

       




    </div>

    
</div>