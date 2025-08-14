<div class="row">
    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('header_section_one_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Top Section One</h3>
            <?php
            $theme = get_lebel_by_value_in_settings('Theme');
            $themeSetting = get_theme_settings();
            $themeSettingTitle = get_theme_title_settings();
            $cat = get_all_data_array('cc_product_category');
            ?>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['head_side_title_1'];?></label>
                <input type="text" class="form-control"  name="head_side_title_1"
                    value="<?php echo $themeSetting['head_side_title_1']['value'];?>">
            </div>

            <div class="form-group">
                <label><?php echo $themeSettingTitle['head_side_category_1'];?></label>
                <select name="head_side_category_1" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel = $themeSetting['head_side_category_1']['value'];
                    foreach ($cat as $val){
                        ?>
                        <option value="<?php echo $val->prod_cat_id;?>"
                            <?php echo ($val->prod_cat_id == $catSel)?'selected':'';?>><?php echo display_category_with_parent($val->prod_cat_id);?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label><?php echo $themeSettingTitle['head_side_url_1'];?></label>
                <input type="text" class="form-control"  name="head_side_url_1" value="<?php echo $themeSetting['head_side_url_1']['value'];?>" >
            </div>

            <div class="form-group">
                <?php
                    $head_side_baner_1 = $themeSetting['head_side_baner_1']['value'];
                    echo image_view('uploads/top_side_baner', '', $head_side_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo $themeSettingTitle['head_side_baner_1'];?></label>
                <input type="file" class="form-control" name="head_side_baner_1">
                <span>Recommended Size: 228 x 199</span>
            </div>

            <div class="form-group">
                <label>ALT Name</label>
                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['head_side_baner_1']['alt_name']; ?>" >
            </div>

            <div class="form-group">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('header_section_two_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Top Section Two</h3>

            <div class="form-group">
                <label><?php echo $themeSettingTitle['head_side_title_2'];?></label>
                <input type="text" class="form-control"  name="head_side_title_2"
                    value="<?php echo $themeSetting['head_side_title_2']['value'];?>">
            </div>

            <div class="form-group">
                <label><?php echo $themeSettingTitle['head_side_category_2'];?></label>
                <select name="head_side_category_2" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel2 = $themeSetting['head_side_category_2']['value'];
                    foreach ($cat as $val){
                        ?>
                        <option value="<?php echo $val->prod_cat_id;?>"
                            <?php echo ($val->prod_cat_id == $catSel2)?'selected':'';?>><?php echo display_category_with_parent($val->prod_cat_id);?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label><?php echo $themeSettingTitle['head_side_url_2'];?></label>
                <input type="text" class="form-control"  name="head_side_url_2" value="<?php echo $themeSetting['head_side_url_2']['value'];?>" >
            </div>

            <div class="form-group">
                <?php
                    $head_side_baner_2 = $themeSetting['head_side_baner_2']['value'];
                    echo image_view('uploads/top_side_baner', '', $head_side_baner_2, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo $themeSettingTitle['head_side_baner_2'];?></label>
                <input type="file" class="form-control" name="head_side_baner_2">
                <span>Recommended Size: 228 x 199</span>
            </div>
            <div class="form-group">
                <label>ALT Name</label>
                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['head_side_baner_2']['alt_name']; ?>" >
            </div>

            <div class="form-group">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('home_category_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Category Section One</h3>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_title_1'];?></label>
                <input type="text" class="form-control" required name="home_category_title_1"
                    value="<?php echo $themeSetting['home_category_title_1']['value'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_1'];?> </label>
                <select name="home_category_1" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel_1 = get_lebel_by_value_in_theme_settings('home_category_1')->value;
                    foreach ($cat as $val){
                        ?>
                        <option value="<?php echo $val->prod_cat_id;?>"
                            <?php echo ($val->prod_cat_id == $catSel_1)?'selected':'';?>><?php echo display_category_with_parent($val->prod_cat_id);?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_url_1'];?></label>
                <input type="text" class="form-control"  name="home_category_url_1" value="<?php echo $themeSetting['home_category_url_1']['value'];?>" >
            </div>

            <div class="form-group">
                <?php
                    $home_category_baner_1 = $themeSetting['home_category_baner_1']['value'];
                    echo image_view('uploads/home_category', '', $home_category_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo $themeSettingTitle['home_category_baner_1'];?></label>
                <input type="file" class="form-control" name="home_category_baner_1">
                <span>Recommended Size: 271 x 590</span>
            </div>
            <div class="form-group">
                <label>ALT Name</label>
                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['home_category_baner_1']['alt_name']; ?>" >
            </div>
            <input type="hidden" class="form-control" required name="prefix" value="1">
            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('home_category_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Category Section Two</h3>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_title_2'];?></label>
                <input type="text" class="form-control" required name="home_category_title_2"
                    value="<?php echo $themeSetting['home_category_title_2']['value'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_2'];?> </label>
                <select name="home_category_2" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel_1 = get_lebel_by_value_in_theme_settings('home_category_2')->value;
                    foreach ($cat as $val){
                        ?>
                        <option value="<?php echo $val->prod_cat_id;?>"
                            <?php echo ($val->prod_cat_id == $catSel_1)?'selected':'';?>><?php echo display_category_with_parent($val->prod_cat_id);?>
                        </option>
                    <?php } ?>
                </select>

            </div>

            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_url_2'];?></label>
                <input type="text" class="form-control"  name="home_category_url_2" value="<?php echo $themeSetting['home_category_url_2']['value'];?>" >
            </div>

            <div class="form-group">
                <?php
                    $home_category_baner_1 = $themeSetting['home_category_baner_2']['value'];
                    echo image_view('uploads/home_category', '', $home_category_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo $themeSettingTitle['home_category_baner_2'];?></label>
                <input type="file" class="form-control" name="home_category_baner_2">
                <span>Recommended Size: 271 x 590</span>
            </div>
            <div class="form-group">
                <label>ALT Name</label>
                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['home_category_baner_2']['alt_name']; ?>" >
            </div>

            <input type="hidden" class="form-control" required name="prefix" value="2">
            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('home_category_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Category Section Three</h3>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_title_3'];?></label>
                <input type="text" class="form-control" required name="home_category_title_3"
                    value="<?php echo $themeSetting['home_category_title_3']['value'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_3'];?> </label>
                <select name="home_category_3" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel_1 = get_lebel_by_value_in_theme_settings('home_category_3')->value;
                    foreach ($cat as $val){
                        ?>
                        <option value="<?php echo $val->prod_cat_id;?>"
                            <?php echo ($val->prod_cat_id == $catSel_1)?'selected':'';?>><?php echo display_category_with_parent($val->prod_cat_id);?>
                        </option>
                    <?php } ?>
                </select>

            </div>

            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_url_3'];?></label>
                <input type="text" class="form-control"  name="home_category_url_3" value="<?php echo $themeSetting['home_category_url_3']['value'];?>" >
            </div>

            <div class="form-group">
                <?php
                    $home_category_baner_1 = $themeSetting['home_category_baner_3']['value'];
                    echo image_view('uploads/home_category', '', $home_category_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo $themeSettingTitle['home_category_baner_3'];?></label>
                <input type="file" class="form-control" name="home_category_baner_3">
                <span>Recommended Size: 271 x 590</span>
            </div>
            <div class="form-group">
                <label>ALT Name</label>
                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['home_category_baner_3']['alt_name']; ?>" >
            </div>
            <input type="hidden" class="form-control" required name="prefix" value="3">
            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('home_category_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Category Section Four</h3>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_title_4'];?></label>
                <input type="text" class="form-control" required name="home_category_title_4"
                    value="<?php echo $themeSetting['home_category_title_4']['value'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_4'];?> </label>
                <select name="home_category_4" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel_1 = get_lebel_by_value_in_theme_settings('home_category_4')->value;
                    foreach ($cat as $val){
                        ?>
                        <option value="<?php echo $val->prod_cat_id;?>"
                            <?php echo ($val->prod_cat_id == $catSel_1)?'selected':'';?>><?php echo display_category_with_parent($val->prod_cat_id);?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_url_4'];?></label>
                <input type="text" class="form-control"  name="home_category_url_4" value="<?php echo $themeSetting['home_category_url_4']['value'];?>" >
            </div>

            <div class="form-group">
                <?php
                    $home_category_baner_1 = $themeSetting['home_category_baner_4']['value'];
                    echo image_view('uploads/home_category', '', $home_category_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo $themeSettingTitle['home_category_baner_4'];?></label>
                <input type="file" class="form-control" name="home_category_baner_4">
                <span>Recommended Size: 271 x 590</span>
            </div>
            <div class="form-group">
                <label>ALT Name</label>
                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['home_category_baner_4']['alt_name']; ?>" >
            </div>
            <input type="hidden" class="form-control" required name="prefix" value="4">
            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('home_category_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Category Section Five</h3>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_title_5'];?></label>
                <input type="text" class="form-control" required name="home_category_title_5"
                    value="<?php echo $themeSetting['home_category_title_5']['value'];?>">
            </div>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_5'];?> </label>
                <select name="home_category_5" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel_1 = $themeSetting['home_category_5']['value'];
                    foreach ($cat as $val){
                        ?>
                        <option value="<?php echo $val->prod_cat_id;?>"
                            <?php echo ($val->prod_cat_id == $catSel_1)?'selected':'';?>><?php echo display_category_with_parent($val->prod_cat_id);?>
                        </option>
                    <?php } ?>
                </select>

            </div>

            <div class="form-group">
                <label><?php echo $themeSettingTitle['home_category_url_5'];?></label>
                <input type="text" class="form-control"  name="home_category_url_5" value="<?php echo $themeSetting['home_category_url_5']['value'];?>" >
            </div>

            <div class="form-group">
                <?php
                    $home_category_baner_1 = $themeSetting['home_category_baner_5']['value'];
                    echo image_view('uploads/home_category', '', $home_category_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo $themeSettingTitle['home_category_baner_5'];?></label>
                <input type="file" class="form-control" name="home_category_baner_5">
                <span>Recommended Size: 271 x 590</span>
            </div>
            <div class="form-group">
                <label>ALT Name</label>
                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['home_category_baner_5']['alt_name']; ?>" >
            </div>
            <input type="hidden" class="form-control" required name="prefix" value="5">
            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('banner_bottom_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Banner Bottom</h3>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['banner_bottom_category'];?></label>
                <select name="banner_bottom_category" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel = $themeSetting['banner_bottom_category']['value'];
                    foreach ($cat as $val){
                        ?>
                        <option value="<?php echo $val->prod_cat_id;?>"
                            <?php echo ($val->prod_cat_id == $catSel)?'selected':'';?>><?php echo display_category_with_parent($val->prod_cat_id);?>
                        </option>
                    <?php } ?>
                </select>

            </div>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['banner_bottom_url'];?></label>
                <input type="text" class="form-control"  name="banner_bottom_url" value="<?php echo $themeSetting['banner_bottom_url']['value'];?>" >
            </div>
            <div class="form-group">
                <?php
                $banner_bottom = $themeSetting['banner_bottom']['value'];
                echo image_view('uploads/banner_bottom', '', $banner_bottom, 'noimage.png', 'w-100');
                ?><br>
                <label><?php echo $themeSettingTitle['banner_bottom'];?></label>
                <input type="file" class="form-control" name="banner_bottom">
                <span>Recommended Size: 1116 x 422</span>
            </div>
            <div class="form-group">
                <label>ALT Name</label>
                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['banner_bottom']['alt_name']; ?>" >
            </div>
            <button class="btn btn-primary">Save</button>

        </form>

        <form action="<?php echo base_url('banner_featured_category_update') ?>" method="post" enctype="multipart/form-data">
            <h3 class="mt-5"><?php echo $themeSettingTitle['banner_featured_category'];?></h3>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['banner_featured_category_category'];?></label>
                <select name="banner_featured_category_category" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel = $themeSetting['banner_featured_category_category']['value'];
                    foreach ($cat as $val){
                        ?>
                        <option value="<?php echo $val->prod_cat_id;?>"
                            <?php echo ($val->prod_cat_id == $catSel)?'selected':'';?>><?php echo display_category_with_parent($val->prod_cat_id);?>
                        </option>
                    <?php } ?>
                </select>

            </div>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['banner_featured_category_url'];?></label>
                <input type="text" class="form-control"  name="banner_featured_category_url" value="<?php echo $themeSetting['banner_featured_category_url']['value'];?>" >
            </div>
            <div class="form-group">
                <?php
                $banner_featured_category = $themeSetting['banner_featured_category']['value'];
                echo image_view('uploads/banner_featured_category', '', $banner_featured_category, 'noimage.png', 'w-100');
                ?><br>
                <label><?php echo $themeSettingTitle['banner_featured_category'];?></label>
                <input type="file" class="form-control" name="banner_featured_category">
                <span>Recommended Size: 1116 x 211</span>
            </div>

            <div class="form-group">
                <label>ALT Name</label>
                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['banner_featured_category']['alt_name']; ?>" >
            </div>
            <button class="btn btn-primary">Save</button>

        </form>
    </div>

    <div class="col-md-6 card p-2">

        <form action="<?php echo base_url('banner_top_update') ?>" method="post" enctype="multipart/form-data">
            <h3 class="mt-5"><?php echo $themeSettingTitle['banner_top'];?></h3>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['banner_top_category'];?></label>
                <select name="banner_top_category" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel = $themeSetting['banner_top_category']['value'];
                    foreach ($cat as $val){
                        ?>
                        <option value="<?php echo $val->prod_cat_id;?>"
                            <?php echo ($val->prod_cat_id == $catSel)?'selected':'';?>><?php echo display_category_with_parent($val->prod_cat_id);?>
                        </option>
                    <?php } ?>
                </select>

            </div>
            <div class="form-group">
                <label><?php echo $themeSettingTitle['banner_top_category_url'];?></label>
                <input type="text" class="form-control"  name="banner_top_category_url" value="<?php echo $themeSetting['banner_top_category_url']['value'];?>" >
            </div>
            <div class="form-group">
                <?php
                $banner_top = $themeSetting['banner_top']['value'];
                echo image_view('uploads/banner_top', '', $banner_top, 'noimage.png', 'w-100');
                ?><br>
                <label><?php echo $themeSettingTitle['banner_top'];?></label>
                <input type="file" class="form-control" name="banner_top">
                <span>Recommended Size: 1116 x 211</span>
            </div>
            <div class="form-group">
                <label>ALT Name</label>
                <input type="text" name="alt_name" class="form-control" placeholder="Alt Name" value="<?php echo $themeSetting['banner_top']['alt_name']; ?>" >
            </div>
            <button class="btn btn-primary">Save</button>

        </form>
    </div>

</div>