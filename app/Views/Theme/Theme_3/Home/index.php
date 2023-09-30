<section class="banner">
    <div class="container">
        <div class="row gx-0">
            <div class="col-xl-9 offset-xl-3 d-flex flex-column flex-lg-row">
                <div class="swiper bannerSlide me-1">
                    <div class="swiper-wrapper">
                    <?php $sli_1 = get_lebel_by_value_in_theme_settings('slider_1'); ?>
                        <div class="swiper-slide">
                            <?php echo image_view('uploads/slider', '', $sli_1, 'noimage.png', 'img-fluid w-100 '); ?>
                        </div>
                        <?php $sli_2 = get_lebel_by_value_in_theme_settings('slider_2'); ?>
                        <div class="swiper-slide">
                            <?php echo image_view('uploads/slider', '', $sli_2, 'noimage.png', 'img-fluid w-100 '); ?>
                        </div>
                        <?php $sli_3 = get_lebel_by_value_in_theme_settings('slider_3'); ?>
                        <div class="swiper-slide">
                            <?php echo image_view('uploads/slider', '', $sli_3, 'noimage.png', 'img-fluid w-100 '); ?>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="side-banner d-flex flex-column flex-sm-row flex-lg-column gap-1">
                    <div class="side-banner-box position-relative h-50">                        
                        <?php
                            $side_baner_1 = get_lebel_by_value_in_theme_settings_with_theme('head_side_baner_1',$theme);
                            echo image_view('uploads/top_side_baner', '', $side_baner_1, 'noimage.png', 'img-fluid w-100 h-100');
                        ?>
                        <div class="position-absolute top-0 p-3">
                            <h4><?php echo get_lebel_by_value_in_theme_settings_with_theme('head_side_title_1',$theme);?></h4>
                            <a class="btn btn-sidebanner" href="<?php echo base_url('category/'.get_lebel_by_value_in_theme_settings_with_theme('head_side_category_1',$theme)); ?>">
                                Shop Now                                
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12L17.25 12L12 6.75L12.66 6L19.16 12.5L12.66 19L12 18.25L17.25 13L5 13L5 12Z" fill="#818181"/>
                                </svg>    
                            </a>
                        </div>
                    </div>
                    <div class="side-banner-box position-relative h-50">
                        <?php
                            $side_baner_2 = get_lebel_by_value_in_theme_settings_with_theme('head_side_baner_2',$theme);
                            echo image_view('uploads/top_side_baner', '', $side_baner_2, 'noimage.png', 'img-fluid w-100 h-100');
                        ?>

                        <div class="position-absolute top-0 p-3">
                            <h4><?php echo get_lebel_by_value_in_theme_settings_with_theme('head_side_title_2',$theme);?></h4>
                            <a class="btn btn-sidebanner" href="<?php echo base_url('category/'.get_lebel_by_value_in_theme_settings_with_theme('head_side_category_2',$theme)); ?>" >
                                Shop Now                                
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12L17.25 12L12 6.75L12.66 6L19.16 12.5L12.66 19L12 18.25L17.25 13L5 13L5 12Z" fill="#818181"/>
                                </svg>    
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="main-container">
    <div class="container">
        <div class="featured-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header">Featured Category</h3>
                    </div>
                </div>
            </div>
            <div class="row row-cols-lg-6 row-cols-md-3 row-cols-sm-3 row-cols-2 row-cols-1">
            <?php
                    foreach ($populerCat as $key => $catPop) {
                    $icon_id = get_data_by_id('icon_id', 'cc_product_category', 'prod_cat_id', $catPop->prod_cat_id);
                    $icon = get_data_by_id('code', 'cc_icons', 'icon_id', $icon_id);
                    $imageCat = get_data_by_id('image', 'cc_product_category', 'prod_cat_id', $catPop->prod_cat_id);
                ?>
                <div class="col">
                    <a href="<?php echo base_url('category/'.$catPop->prod_cat_id) ?>">   
                    <?php echo image_view('uploads/category', '', $imageCat, 'noimage.png', 'w-100'); ?>
                    <div class="category-title"><?php echo get_data_by_id('category_name', 'cc_product_category', 'prod_cat_id', $catPop->prod_cat_id); ?></div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="product-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header"><?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_1',$theme);?></h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="apparels-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="apparels-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        $category_baner_1 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_1',$theme);
                        echo image_view('uploads/home_category', '', $category_baner_1, 'noimage.png', 'w-100 h-100');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper apparelsSlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_1 = get_lebel_by_value_in_theme_settings_with_theme('home_category_1',$theme); 
                                echo get_category_id_by_product_show_home_slide($home_category_1);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header"><?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_2',$theme);?></h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="treasures-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="treasures-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        $category_baner_2 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_2',$theme);
                        echo image_view('uploads/home_category', '', $category_baner_2, 'noimage.png', 'w-100 h-100');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper treasuresSlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_2 = get_lebel_by_value_in_theme_settings_with_theme('home_category_2',$theme); 
                                echo get_category_id_by_product_show_home_slide($home_category_2);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header"><?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_3',$theme);?></h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="bag-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="bag-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        $category_baner_3 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_3',$theme);
                        echo image_view('uploads/home_category', '', $category_baner_3, 'noimage.png', 'w-100 h-100');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper bagSlide">
                            <div class="swiper-wrapper">
                                <?php 
                                    $home_category_3 = get_lebel_by_value_in_theme_settings_with_theme('home_category_3',$theme); 
                                    echo get_category_id_by_product_show_home_slide($home_category_3);                                  
                                        
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header"><?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_4',$theme);?></h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="jewelry-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="jewelry-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        $category_baner_4 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_4',$theme);
                        echo image_view('uploads/home_category', '', $category_baner_4, 'noimage.png', 'w-100 h-100');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper jewelrySlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_4 = get_lebel_by_value_in_theme_settings_with_theme('home_category_4',$theme); 
                                echo get_category_id_by_product_show_home_slide($home_category_4);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-category mb-5">
            <div class="cat-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header"><?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_5',$theme);?></h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="shoes-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="shoes-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        $category_baner_5 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_5',$theme);
                        echo image_view('uploads/home_category', '', $category_baner_5, 'noimage.png', 'w-100 h-100');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="products h-100">
                        <div class="swiper shoesSlide">
                            <div class="swiper-wrapper">
                            <?php 
                                $home_category_5 = get_lebel_by_value_in_theme_settings_with_theme('home_category_5',$theme); 
                                echo get_category_id_by_product_show_home_slide($home_category_5);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-banner mb-5">
            <?php
                $banner_bottom = get_lebel_by_value_in_theme_settings_with_theme('banner_bottom',$theme);
                echo image_view('uploads/banner_bottom', '', $banner_bottom, 'noimage.png', 'w-100');
            ?>
        </div>

        <div class="brands-slide mb-5">
            <div class="brands-title">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <h3 class="title-header">Brands</h3>
                    </div>
                    <div class="col-6 col-md-9 d-flex justify-content-end align-items-center">
                        <div class="brands-button-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18L8 12L14 6L15.4 7.4L10.8 12L15.4 16.6L14 18Z" fill="#141414"/>
                            </svg>
                        </div>
                        <div class="brands-button-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.4 18L8 16.6L12.6 12L8 7.4L9.4 6L15.4 12L9.4 18Z" fill="#141414"/>
                            </svg>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="border p-4">
                <div class="swiper brandsSlide">
                    <div class="swiper-wrapper">
                    <?php foreach($brand as $br){ ?>
                        <div class="swiper-slide">
                            <?php echo image_view('uploads/brand', '', $br->image, 'noimage.png', 'w-100') ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>                
        </div>
    </div>
    
    <div class="popular-category">
        <div class="container">
            <div class="text-center mb-5">
                <h5>Category</h5>
                <h2>Shop by Category</h2>
            </div>
            <div class="row row-cols-lg-5 row-cols-md-3 row-cols-sm-2 row-cols-1 gx-5">
                <?php foreach($shop_by as $valShop){ ?>        
                <div class="col mb-5">
                    <div class="card p-4 border-0 text-center rounded-4">
                        <div class="card-body p-0 d-flex flex-column justify-content-center align-items-center brand-icon">                                
                            
                            <?php 
                                $icon_id = get_data_by_id('icon_id','cc_product_category','prod_cat_id',$valShop->prod_cat_id);
                                echo get_data_by_id('code','cc_icons','icon_id',$icon_id);  
                            ?>
                            <h4><?php echo get_data_by_id('category_name','cc_product_category','prod_cat_id',$valShop->prod_cat_id)  ?></h4>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <!-- <div class="col mb-5">
                    <div class="card p-4 border-0 text-center rounded-4">
                        <div class="card-body p-0 d-flex flex-column justify-content-center align-items-center">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M70.0101 66.4719L66.1568 23.6434C65.8975 20.217 63.9342 17.2035 60.9045 15.5819L57.5308 13.7756C57.5102 12.7573 57.3764 9.88323 56.5553 6.51585C56.5536 6.50749 56.5517 6.49897 56.5498 6.49062H56.5496C56.5442 6.46488 56.5377 6.43897 56.53 6.41374C56.3117 5.60385 55.7822 4.89591 54.9565 4.30917C51.5216 1.8698 47.8862 0.790749 45.0498 0.326911C42.3855 -0.10897 37.6158 -0.10897 34.9513 0.326911C32.1151 0.790919 28.4799 1.8698 25.0453 4.30899C24.2291 4.88858 23.7026 5.58681 23.4794 6.38493C23.4646 6.42857 23.4533 6.47306 23.4455 6.5184C22.625 9.88425 22.4912 12.7569 22.4706 13.7755L19.0978 15.5819C16.0688 17.203 14.1048 20.2165 13.8449 23.6313L9.99096 66.4835C9.903 67.6354 10.1171 68.7983 10.6099 69.8472L11.2006 71.1025L11.0434 74.4039C11.0236 74.8185 11.3053 75.187 11.7103 75.2767L16.5352 76.3457C16.7593 76.3949 16.9944 76.3523 17.1868 76.2263C17.3791 76.1002 17.5123 75.9019 17.5562 75.6761L18.204 72.3447C18.6735 71.8375 19.0597 71.262 19.3535 70.632C19.6842 69.9258 19.8872 69.1723 19.9566 68.3926L21.9507 50.2932C21.9938 56.6869 21.9602 63.8706 21.6841 68.3958C21.5917 69.9092 22.2775 71.3248 23.4221 72.2136V77.422C23.4221 77.8211 23.699 78.1668 24.0885 78.2539C29.2937 79.4175 34.6473 79.9993 40.0008 79.9993C45.3543 79.9993 50.7076 79.4175 55.9118 78.2539C56.3013 78.1668 56.5781 77.8211 56.5781 77.422V72.2143C57.723 71.3253 58.4089 69.9097 58.3163 68.3963C58.04 63.8701 58.0064 56.6826 58.0497 50.2879L60.0454 68.3926C60.1772 69.8671 60.7959 71.2598 61.7962 72.3443L62.4443 75.6768C62.4883 75.9023 62.6215 76.1007 62.8138 76.2269C62.9537 76.3186 63.1163 76.3663 63.281 76.3663C63.3425 76.3663 63.4044 76.3596 63.4654 76.3462L68.2903 75.2772C68.6953 75.1875 68.9769 74.819 68.9572 74.4044L68.8 71.103L69.3903 69.8484C69.8828 68.8039 70.0976 67.6408 70.0101 66.4719ZM55.5369 10.3195C55.75 11.8956 55.8083 13.1361 55.824 13.7419C52.8246 15.9955 48.8362 17.5273 45.5967 18.496C46.6336 17.8561 47.7403 17.142 48.8316 16.3834C52.0921 14.1171 54.3187 12.1066 55.5369 10.3195ZM32.143 14.9837C29.8119 13.3635 28.0109 11.847 26.8078 10.5151C30.032 8.4491 33.4189 7.59848 35.9434 7.25908C38.2893 6.94372 41.7254 6.9386 44.091 7.25891C46.6091 7.60001 49.9777 8.45251 53.1942 10.5148C51.9933 11.8444 50.1962 13.358 47.8709 14.9752C44.579 17.2646 41.1376 19.144 40.0006 19.7488C38.8655 19.1448 35.4339 17.2711 32.143 14.9837ZM25.1072 6.89957C25.1086 6.89394 25.1099 6.88848 25.1109 6.88269C25.1109 6.88269 25.1111 6.88218 25.1111 6.88184C25.1118 6.87894 25.1125 6.87621 25.113 6.87331C25.1135 6.87144 25.114 6.86973 25.1145 6.86803C25.225 6.44596 25.5337 6.05269 26.0323 5.69863C28.9287 3.64179 32.0273 2.63263 34.5614 2.14493C37.6393 1.55273 42.3715 1.54711 45.4632 2.14493C47.9897 2.63349 51.0755 3.6435 53.9693 5.69863C54.4679 6.05269 54.7766 6.4463 54.8871 6.86803C54.8876 6.86973 54.8881 6.87161 54.8886 6.87331C54.8905 6.88218 54.8924 6.89104 54.8946 6.89957C54.8946 6.90008 54.8948 6.90059 54.8949 6.9011C55.0443 7.51546 54.8175 8.28187 54.2477 9.16608C50.6411 6.8128 46.8909 5.88359 44.1314 5.53294C41.9416 5.25474 38.0611 5.25474 35.8723 5.53277C33.113 5.88325 29.3619 6.81246 25.7545 9.16642C25.1837 8.28153 24.957 7.51427 25.1072 6.89957ZM24.464 10.3186C25.6822 12.1059 27.9091 14.1169 31.1702 16.3834C32.2627 17.1429 33.3709 17.8578 34.409 18.4984C31.17 17.5305 27.1806 15.9985 24.1775 13.7416C24.1926 13.1362 24.2504 11.8971 24.464 10.3186ZM12.7803 73.7679L12.8669 71.9495L16.415 72.6149L16.0498 74.4924L12.7803 73.7679ZM25.1268 76.7364V73.0361C34.8599 75.5874 45.1407 75.5874 54.8734 73.0361V76.7364C45.1286 78.8149 34.8734 78.8149 25.1268 76.7364ZM63.9506 74.4924L63.5854 72.6149L67.1337 71.9495L67.2203 73.7679L63.9506 74.4924ZM67.8481 69.1215L67.3527 70.1741L62.8927 71.0104C62.2371 70.2282 61.8326 69.2574 61.7425 68.2337C61.742 68.2276 61.7413 68.2213 61.7407 68.2151L58.2459 36.5095C58.1968 36.0636 57.8051 35.731 57.3623 35.7514C56.9141 35.7705 56.5575 36.1338 56.5467 36.5823C56.5413 36.8027 56.019 58.7434 56.6149 68.5003C56.6956 69.8196 55.8245 71.0227 54.5441 71.3609C45.0294 73.8743 34.9709 73.8743 25.456 71.3609C24.1754 71.0227 23.3047 69.8196 23.3855 68.5003C23.9811 58.7434 23.4591 36.8027 23.4537 36.5823C23.4428 36.1338 23.0862 35.7705 22.638 35.7514C22.1859 35.7313 21.8034 36.0636 21.7543 36.5095L18.2611 68.2151C18.2604 68.2214 18.2598 68.2277 18.2592 68.2341C18.2079 68.8179 18.0567 69.3815 17.8087 69.9108C17.6229 70.3095 17.3882 70.6779 17.1084 71.0108L12.6475 70.1743L12.1525 69.1222C11.7848 68.3396 11.625 67.4721 11.6895 66.625L15.5435 23.7725C15.7602 20.9296 17.3895 18.4295 19.9025 17.0847L23.3407 15.2428C25.9375 17.1499 29.4275 18.7751 33.7294 20.0779C33.8908 20.1269 34.0498 20.1739 34.2075 20.2201V44.1309C34.2075 44.6017 34.589 44.9832 35.0599 44.9832C35.5307 44.9832 35.9122 44.6017 35.9122 44.1309V20.6906C38.1168 21.2617 39.6643 21.5204 39.8506 21.5508C39.8994 21.5595 39.9495 21.5639 40.0001 21.5639C40.0005 21.5639 40.0008 21.5639 40.0011 21.5639C40.0519 21.5639 40.1019 21.5595 40.1506 21.5508C40.3373 21.5204 41.8846 21.2615 44.0893 20.6906V44.131C44.0893 44.6018 44.4708 44.9834 44.9416 44.9834C45.4124 44.9834 45.7939 44.6018 45.7939 44.131V20.2203C45.9516 20.1741 46.1106 20.127 46.2721 20.0781C50.5736 18.7752 54.0634 17.1502 56.6603 15.2434L60.0999 17.0849C62.6131 18.4302 64.2419 20.9299 64.4579 23.7842L68.3111 66.6119C68.3757 67.4748 68.2156 68.3423 67.8481 69.1215Z" fill="#231F20"/>
                            </svg>    
                            <h4>Jackets & Coats</h4>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card p-4 border-0 text-center rounded-4">
                        <div class="card-body p-0 d-flex flex-column justify-content-center align-items-center">                                
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.6574 0.987798C11.7646 1.443 11.8342 3.0374 12.7622 3.387C13.0598 3.5094 22.6926 3.5446 40.2598 3.527C65.8134 3.4742 67.3022 3.4566 67.5998 3.159C68.003 2.7558 68.003 1.5654 67.5998 1.1622C67.3022 0.864601 65.8134 0.846998 40.1894 0.811798C18.7526 0.777398 13.0078 0.812598 12.6574 0.987798Z" fill="#231F20"/>
                                <path d="M11.8173 6.57451C11.5893 6.69691 11.3621 7.02972 11.2741 7.39771C11.1869 7.74812 10.9765 10.3577 10.8365 13.1953C10.6789 16.0329 10.4685 19.6233 10.3813 21.1641C10.2237 23.7561 9.57569 38.3281 9.15489 48.3993C8.89249 54.8097 8.92689 60.0289 9.24209 62.1657C9.94289 66.7897 11.3437 70.0993 13.6205 72.5169L14.6717 73.6201H21.6077H28.5437L29.3141 73.0769C30.9957 71.8681 32.3437 70.2921 33.5173 68.1201C35.2157 64.9673 35.8645 61.7625 36.0221 55.8425C36.3373 44.3881 37.1957 38.6609 38.8421 36.9097C40.2957 35.3681 41.7317 36.9449 42.6077 41.0433C43.3085 44.2481 43.6237 47.8913 44.0085 57.2441C44.1309 60.4489 44.2541 61.6401 44.6037 63.1289C45.6893 67.8225 48.2989 71.9913 50.9965 73.3225C51.5221 73.5857 52.3629 73.6201 58.2125 73.6201H64.8157L65.5861 72.9897C67.3029 71.5537 68.7565 69.2769 69.6669 66.5265C71.4709 61.1673 71.4709 56.3153 69.6669 19.5881L69.0541 7.15291L68.5989 6.75051L68.1613 6.36491L40.1909 6.38251C20.4165 6.38171 12.0973 6.45211 11.8173 6.57451ZM23.4117 9.72731C23.3413 10.0425 23.0789 11.0057 22.7813 11.8817C21.2573 16.5577 17.9469 19.6401 13.7437 20.2881L12.9909 20.4105L13.0957 19.1145C13.1485 18.4137 13.3061 16.1369 13.4461 14.0705C13.6037 12.0041 13.7613 10.0425 13.8141 9.72731L13.9189 9.16651H18.7181H23.5165L23.4117 9.72731ZM66.4269 10.8657C66.4445 11.8113 66.5493 14.4385 66.6725 16.6977C66.8125 18.9569 66.8829 20.8489 66.8477 20.8833C66.6373 21.0937 64.0805 20.4633 62.9245 19.9201C61.2605 19.1321 59.1237 17.0129 58.1605 15.2089C57.4245 13.8081 56.5317 11.2329 56.3565 9.98972L56.2341 9.16651H61.3309H66.4277V10.8657H66.4269ZM53.1861 9.72731C54.0621 14.1761 55.4981 17.1705 57.9325 19.6057C60.0165 21.6897 62.8013 23.0385 65.5509 23.2833C66.2341 23.3537 66.8293 23.4937 66.8645 23.5985C66.9517 23.8089 67.8805 44.3353 68.1957 52.6025C68.3005 55.4401 68.3533 58.7153 68.2829 59.8713C68.0549 64.3377 66.8293 67.9633 64.8325 70.1345L64.2021 70.8177H58.1245C51.1717 70.8177 51.6965 70.9401 50.2605 69.0833C49.1925 67.7169 48.6317 66.7017 48.0189 65.0201C47.0909 62.4977 46.8277 60.6769 46.6349 55.5801C46.2669 45.4217 45.5837 40.4129 44.1653 37.2249C43.1677 34.9305 41.5213 33.7393 39.6477 33.9145C39.0869 33.9497 38.3869 34.1249 38.0885 34.2825C36.6349 35.0353 35.3741 37.1369 34.6557 39.9921C33.8853 43.1097 33.3421 49.4145 33.3245 55.4577C33.3245 59.9937 32.8693 62.9889 31.7309 65.9137C31.0829 67.6129 29.7341 69.6969 28.7357 70.5553L28.0005 71.1681H21.9229H15.8453L14.9525 70.1697C13.2885 68.3129 12.0629 65.0729 11.5893 61.4297C11.4493 60.2561 11.4141 58.1193 11.4845 54.5465C11.5717 49.5025 12.5877 25.0345 12.7629 23.9489C12.8333 23.4233 12.8853 23.4057 13.8661 23.3009C19.9085 22.6705 24.6373 17.4337 25.8813 9.98972L25.9861 9.34171H39.5421H53.1157L53.1861 9.72731Z" fill="#231F20"/>
                                <path d="M15.4594 76.6501C14.5658 77.1053 14.6362 78.6997 15.5642 79.0669C15.8618 79.1717 18.261 79.2245 22.0442 79.1893C28.8218 79.1365 28.6818 79.1541 28.6818 77.8229C28.6818 76.4741 28.8394 76.5093 21.9738 76.4565C17.3338 76.4221 15.7922 76.4749 15.4594 76.6501Z" fill="#231F20"/>
                                <path d="M51.61 76.8608C51.2244 77.2464 51.1724 77.4384 51.242 77.964C51.4524 79.1728 51.2068 79.1376 58.1956 79.1376C65.3068 79.1376 65.114 79.1728 65.114 77.824C65.114 76.4752 65.2892 76.5104 58.2836 76.4576L52.066 76.4048L51.61 76.8608Z" fill="#231F20"/>
                            </svg>        
                            <h4>Bottoms</h4>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card p-4 border-0 text-center rounded-4">
                        <div class="card-body p-0 d-flex flex-column justify-content-center align-items-center">                                
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M36.0003 33.3336C36.7366 33.3336 37.3336 32.7366 37.3336 32.0003C37.3336 31.2639 36.7366 30.667 36.0003 30.667C35.2639 30.667 34.667 31.2639 34.667 32.0003C34.667 32.7366 35.2639 33.3336 36.0003 33.3336Z" fill="#231F20"/>
                                <path d="M36.0003 42.6666C36.7366 42.6666 37.3336 42.0696 37.3336 41.3333C37.3336 40.5969 36.7366 40 36.0003 40C35.2639 40 34.667 40.5969 34.667 41.3333C34.667 42.0696 35.2639 42.6666 36.0003 42.6666Z" fill="#231F20"/>
                                <path d="M36.0003 51.9996C36.7366 51.9996 37.3336 51.4026 37.3336 50.6663C37.3336 49.9299 36.7366 49.333 36.0003 49.333C35.2639 49.333 34.667 49.9299 34.667 50.6663C34.667 51.4026 35.2639 51.9996 36.0003 51.9996Z" fill="#231F20"/>
                                <path d="M36.0003 61.3336C36.7366 61.3336 37.3336 60.7366 37.3336 60.0003C37.3336 59.2639 36.7366 58.667 36.0003 58.667C35.2639 58.667 34.667 59.2639 34.667 60.0003C34.667 60.7366 35.2639 61.3336 36.0003 61.3336Z" fill="#231F20"/>
                                <path d="M60 33.334H49.3333C48.5969 33.334 48 33.9309 48 34.6673V48.0005C48 48.737 48.5969 49.3338 49.3333 49.3338H60C60.7364 49.3338 61.3333 48.737 61.3333 48.0005V34.6673C61.3333 33.9309 60.7364 33.334 60 33.334ZM58.6667 46.6673H50.6667V36.0005H58.6667V46.6673Z" fill="#231F20"/>
                                <path d="M73.3332 14.6667H69.3326V10.6661C69.3326 8.45734 67.542 6.66609 65.3326 6.66609H51.8393C51.8359 6.66609 51.8326 6.66641 51.8291 6.66641H51.7979C50.5718 2.68422 43.8984 0 35.9999 0C28.1015 0 21.428 2.68422 20.2021 6.66641H20.1709C20.1674 6.66641 20.1641 6.66609 20.1607 6.66609H6.66602C4.45758 6.66609 2.66602 8.45766 2.66602 10.6661V67.9994C2.66602 70.2088 4.45727 71.9994 6.66602 71.9994H10.6666V76C10.6666 78.2097 12.457 80 14.6666 80H73.3334C75.543 80 77.3334 78.2097 77.3334 76V18.6667C77.3332 16.457 75.543 14.6667 73.3332 14.6667ZM20.1657 9.33313C20.5362 9.33453 20.8913 9.49156 21.1435 9.76641L28.037 17.2866L25.262 23.5411L18.158 9.33313H20.1657ZM50.8565 9.76609C51.1087 9.49141 51.4638 9.33453 51.8341 9.33313H53.8418L46.7379 23.5411L43.9629 17.2866L50.8565 9.76609ZM35.9999 2.66672C43.0205 2.66672 48.6529 5.04391 49.2759 7.54297L41.407 16.1281L41.4068 16.1283L36.9813 20.9561C36.4527 21.5306 35.5471 21.5306 35.0185 20.9561L30.5929 16.1283C30.5929 16.1283 30.5929 16.1281 30.5927 16.1281L22.7238 7.54297C23.347 5.04391 28.9793 2.66672 35.9999 2.66672ZM5.33258 67.9995V10.6661C5.33258 9.93047 5.93023 9.33281 6.66586 9.33281H15.1763L24.1413 27.2627C24.6454 28.2709 26.0955 28.2375 26.5526 27.2072L30.0027 19.4311L33.0509 22.7564C33.052 22.7577 33.0532 22.7588 33.0543 22.76L35.0168 24.9009C35.5452 25.4775 36.4541 25.4775 36.9826 24.9009L38.9452 22.7598C38.9463 22.7587 38.9474 22.7577 38.9485 22.7564L41.9968 19.4309L45.447 27.207C45.9041 28.2373 47.3541 28.2708 47.8582 27.2625L56.8235 9.33281H65.3327C66.0691 9.33281 66.666 9.93 66.666 10.6661V67.9994C66.666 68.7363 66.0696 69.3327 65.3327 69.3327H6.66602C5.92977 69.3328 5.33258 68.7359 5.33258 67.9995ZM74.6666 76C74.6666 76.7369 74.0702 77.3333 73.3334 77.3333H14.6666C13.9298 77.3333 13.3334 76.7369 13.3334 76V72H65.3334C67.543 72 69.3334 70.2097 69.3334 68V17.3333H73.3334C74.0704 17.3333 74.6666 17.9297 74.6666 18.6666V76Z" fill="#231F20"/>
                            </svg>       
                            <h4>Tees</h4>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card p-4 border-0 text-center rounded-4">
                        <div class="card-body p-0 d-flex flex-column justify-content-center align-items-center">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M73.5247 15.2269C73.3886 9.50781 69.6235 4.53469 64.1555 2.8525L56.6013 0.528125C55.4626 0.1775 54.2811 0 53.0896 0H26.9096C25.7182 0 24.5366 0.1775 23.3977 0.528125L15.8433 2.8525C10.3757 4.53484 6.61052 9.50781 6.47443 15.2269L5.36599 61.7802C5.34287 62.7481 5.85162 63.6273 6.68021 64.0939V68.5687C6.68021 69.5556 7.22849 70.4428 8.11115 70.8842L17.3691 75.513V77.4111C17.3691 78.8386 18.5304 79.9998 19.9579 79.9998H60.0413C61.4688 79.9998 62.6301 78.8386 62.6301 77.4111V75.513L71.888 70.8841C72.7707 70.4427 73.319 69.5555 73.319 68.5686V64.0938C74.1476 63.6273 74.6563 62.7481 74.6332 61.7803L73.5247 15.2269ZM48.0026 2.50516C47.3986 6.37891 44.0402 9.35281 39.9996 9.35281C35.959 9.35281 32.6005 6.37891 31.9966 2.50516H48.0026ZM26.9094 2.50516H29.4705C30.0926 7.76438 34.5757 11.858 39.9994 11.858C45.4232 11.858 49.9065 7.76438 50.5283 2.50516H53.0893C53.1882 2.50516 53.2869 2.50766 53.3855 2.51063C52.7522 9.39891 47.0022 14.6973 39.9996 14.6973C36.4969 14.6973 33.1807 13.3577 30.6618 10.9256C28.3301 8.67422 26.9111 5.70922 26.6149 2.51078C26.713 2.50766 26.8113 2.50516 26.9094 2.50516ZM14.8305 71.443L9.23162 68.6434C9.20302 68.6292 9.18537 68.6005 9.18537 68.5687V65.1862L14.8451 67.6119L14.7677 70.6302C14.7607 70.9061 14.7824 71.1781 14.8305 71.443ZM60.1249 77.4113C60.1249 77.4572 60.0876 77.4947 60.0415 77.4947H19.9579C19.9118 77.4947 19.8744 77.457 19.8744 77.4113V74.6555H60.1249V77.4113ZM62.3247 71.7217C62.0554 71.9981 61.6943 72.1505 61.3082 72.1505H18.6911V72.1503C18.3051 72.1503 17.944 71.998 17.6746 71.7216C17.4051 71.4452 17.2621 71.0802 17.2721 70.6944L17.4116 65.2519L20.4711 66.5408C20.7821 66.6717 21.1327 66.6717 21.4436 66.5408L27.3013 64.0733L33.1591 66.5408C33.4701 66.6717 33.8207 66.6717 34.1318 66.5408L39.9879 64.0734L45.8447 66.5408C46.1557 66.6719 46.5063 66.6719 46.8169 66.5409L52.6797 64.0731L58.5469 66.5409C58.7022 66.6064 58.8672 66.6389 59.0326 66.6389C59.1977 66.6389 59.3629 66.6064 59.5182 66.5409L62.5874 65.2502L62.7271 70.6947C62.7372 71.0806 62.5943 71.4453 62.3247 71.7217ZM20.4713 45.163C20.7822 45.2939 21.1329 45.2939 21.4438 45.163L27.3015 42.6955L33.1593 45.163C33.3147 45.2284 33.4801 45.2612 33.6457 45.2612C33.8113 45.2612 33.9765 45.2284 34.1321 45.163L39.9882 42.6956L45.8451 45.163C46.156 45.2941 46.5066 45.2941 46.8172 45.1631L52.6801 42.6953L58.5472 45.1631C58.8577 45.2938 59.208 45.2938 59.5185 45.1631L62.0454 44.1003L62.383 57.2738L59.0327 58.683L53.1654 56.2152C52.8547 56.0844 52.5043 56.0844 52.1938 56.2152L46.3313 58.6828L40.4743 56.2153C40.1635 56.0842 39.8127 56.0842 39.5016 56.2153L33.6455 58.6827L27.7879 56.2153C27.4769 56.0844 27.1263 56.0844 26.8154 56.2153L20.9577 58.6828L17.6165 57.2753L17.9541 44.1025L20.4713 45.163ZM18.0229 41.4131L18.0896 38.815L20.4711 39.8183C20.7821 39.9492 21.1327 39.9492 21.4436 39.8183L27.3013 37.3508L33.1591 39.8183C33.4699 39.9492 33.8207 39.9492 34.1316 39.8183L39.9877 37.3509L45.8446 39.8183C46.1554 39.9494 46.5061 39.9494 46.8168 39.8184L52.6796 37.3506L58.5468 39.8184C58.7021 39.8839 58.8671 39.9164 59.0324 39.9164C59.1977 39.9164 59.3627 39.8839 59.518 39.8184L61.9093 38.8127L61.9761 41.4113L59.0326 42.6494L53.1652 40.1816C52.8546 40.0508 52.5041 40.0508 52.1936 40.1816L46.3312 42.6492L40.4741 40.1817C40.1633 40.0506 39.8126 40.0506 39.5015 40.1817L33.6454 42.6491L27.7876 40.1817C27.4768 40.0508 27.1261 40.0508 26.8151 40.1817L20.9574 42.6492L18.0229 41.4131ZM20.4713 61.1961C20.7822 61.327 21.1329 61.327 21.4438 61.1961L27.3015 58.7286L33.1593 61.1961C33.4702 61.327 33.8208 61.327 34.1319 61.1961L39.988 58.7288L45.8449 61.1961C46.1557 61.3272 46.5065 61.3272 46.8171 61.1963L52.6799 58.7284L58.5471 61.1963C58.7024 61.2617 58.8676 61.2942 59.0327 61.2942C59.1979 61.2942 59.363 61.2617 59.5183 61.1963L62.4519 59.9623L62.5187 62.5611L59.0327 64.0273L53.1654 61.5595C52.8547 61.4287 52.5043 61.4287 52.1938 61.5595L46.3313 64.0272L40.4743 61.5597C40.1635 61.4286 39.8127 61.4286 39.5016 61.5597L33.6455 64.027L27.7877 61.5597C27.4769 61.4287 27.1263 61.4287 26.8152 61.5597L20.9576 64.0272L17.4807 62.5627L17.5471 59.9644L20.4713 61.1961ZM70.8138 68.5689C70.8138 68.6006 70.7961 68.6294 70.7677 68.6436L65.1686 71.4431C65.2169 71.1783 65.2387 70.9064 65.2315 70.6303L65.1541 67.612L70.8138 65.1864V68.5689ZM72.078 61.9186L65.0849 64.9156L63.9655 21.262C63.9479 20.5705 63.3711 20.0253 62.6811 20.042C61.9896 20.0597 61.4433 20.6348 61.4612 21.3264L61.8407 36.1237L59.0327 37.3048L53.1654 34.837C52.8547 34.7062 52.5043 34.7062 52.1938 34.837L46.3313 37.3047L40.4743 34.8372C40.1635 34.7061 39.8127 34.7061 39.5016 34.8372L33.6455 37.3045L27.7877 34.8372C27.4769 34.7062 27.1263 34.7062 26.8152 34.8372L20.9574 37.3047L18.1583 36.1256L18.5379 21.3264C18.5555 20.6348 18.0093 20.0597 17.3179 20.042C16.6252 20.0242 16.0513 20.5706 16.0335 21.262L14.9141 64.9156L7.92115 61.9188C7.88958 61.9052 7.86974 61.8742 7.87052 61.8398L8.9788 15.2864C9.08927 10.6464 12.1441 6.61188 16.5801 5.24688L24.1343 2.92234C24.1361 2.92187 24.1382 2.92141 24.1399 2.92062C24.5268 6.64828 26.1985 10.0986 28.9213 12.7275C31.9097 15.6131 35.844 17.2023 39.9993 17.2023C44.1446 17.2023 48.0718 15.6197 51.0579 12.7462C53.7908 10.1161 55.471 6.6575 55.859 2.92078C55.8608 2.92125 55.8624 2.92172 55.8643 2.92234L63.4185 5.24688C67.8546 6.61188 70.9094 10.6464 71.0199 15.2864L72.1283 61.8398C72.1296 61.8742 72.1096 61.9053 72.078 61.9186Z" fill="#231F20"/>
                            </svg>
                            <h4>Sweaters</h4>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card p-4 border-0 text-center rounded-4">
                        <div class="card-body p-0 d-flex flex-column justify-content-center align-items-center">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M72.5957 26.8067L41.3331 11.1753V9.33328C41.3331 8.59734 40.7357 8 39.9998 8C38.5292 8 37.3331 6.80406 37.3331 5.33328C37.3331 3.86266 38.529 2.66656 39.9998 2.66656C41.4704 2.66656 42.6665 3.8625 42.6665 5.33328C42.6665 6.06922 43.2638 6.66656 43.9998 6.66656C44.7357 6.66656 45.3331 6.06922 45.3331 5.33328C45.3331 2.39203 42.941 0 39.9998 0C37.0585 0 34.6665 2.39203 34.6665 5.33328C34.6665 7.81328 36.3692 9.90391 38.6665 10.4986V11.1753L7.40368 26.8067C6.8504 27.0841 6.55962 27.7041 6.70228 28.3067C6.84368 28.9081 7.38103 29.3334 7.99962 29.3334H22.6662V73.3334C22.6662 73.3344 22.6663 73.3352 22.6663 73.3361V78.6667C22.6663 79.4027 23.2637 80 23.9996 80C24.7356 80 25.3329 79.4027 25.3329 78.6667V74.6667H27.9996V78.6667C27.9996 79.4027 28.597 80 29.3329 80C30.0688 80 30.6662 79.4027 30.6662 78.6667V74.6667H30.7974H33.3329V78.6667C33.3329 79.4027 33.9302 80 34.6662 80C35.4021 80 35.9995 79.4027 35.9995 78.6667V74.6667H38.5346H38.666V78.6667C38.666 79.4027 39.2634 80 39.9993 80C40.7352 80 41.3326 79.4027 41.3326 78.6667V74.6667H43.9993V78.6667C43.9993 79.4027 44.5966 80 45.3326 80C46.0685 80 46.6659 79.4027 46.6659 78.6667V73.3334C46.6659 73.3325 46.6657 73.3317 46.6657 73.3308V56H49.3326V60C49.3326 60.7359 49.9299 61.3333 50.6659 61.3333C51.4018 61.3333 51.9991 60.7359 51.9991 60V56H54.6659V60C54.6659 60.7359 55.2632 61.3333 55.9991 61.3333C56.7351 61.3333 57.3324 60.7359 57.3324 60V56C58.0684 56 58.6656 55.4027 58.6656 54.6667V29.3333H71.999C72.6176 29.3333 73.1537 28.908 73.2976 28.3066C73.4398 27.7041 73.149 27.0841 72.5957 26.8067ZM25.3331 28V26.6667H29.3657C29.3446 27.1166 29.3335 27.5622 29.3335 28C29.3335 32.2623 30.2698 36.56 32.082 38.6664C30.2695 40.7725 29.3331 45.0706 29.3331 49.3334C29.3331 53.5963 30.2695 57.8944 32.082 60.0005C30.2699 62.1067 29.3335 66.4045 29.3335 70.6669C29.3335 71.1047 29.3446 71.5503 29.3657 72.0002H25.3329V28.0027C25.3329 28.0017 25.3331 28.0009 25.3331 28ZM37.3335 28C37.3335 34.0627 35.4402 37.3333 34.6668 37.3333C33.8921 37.3333 32.0001 34.0627 32.0001 28C32.0001 27.5627 32.0107 27.1173 32.0348 26.6667H37.2974C37.3215 27.1173 37.3335 27.5627 37.3335 28ZM34.6663 58.6667C33.8917 58.6667 31.9996 55.3961 31.9996 49.3334C31.9996 43.2708 33.8917 40 34.6663 40C35.441 40 37.3331 43.2706 37.3331 49.3333C37.3331 55.3959 35.441 58.6667 34.6663 58.6667ZM32.0349 72C32.0109 71.5494 32.0002 71.1041 32.0002 70.6667C32.0002 64.6041 33.8923 61.3334 34.667 61.3334C35.4402 61.3334 37.3337 64.6041 37.3337 70.6667C37.3337 71.1041 37.3217 71.5494 37.2977 72H32.0349ZM43.9996 72H39.9674C39.9888 71.5502 40.0002 71.1045 40.0002 70.6667C40.0002 66.4039 39.0638 62.1058 37.2513 59.9997C39.0634 57.8934 39.9998 53.5956 39.9998 49.3333C39.9998 45.0709 39.0635 40.7733 37.2513 38.6669C39.0638 36.5608 40.0002 32.2627 40.0002 27.9998C40.0002 27.562 39.9888 27.1164 39.9674 26.6666H43.9996V54.6666V72ZM55.9996 53.3333H51.4913C51.8252 51.6981 51.9998 49.8866 51.9998 48C51.9998 43.7375 51.0634 39.4395 49.2512 37.3333C51.0634 35.2272 51.9998 30.9292 51.9998 26.6666H55.9996V53.3333ZM46.6663 36V26.6667H49.3331C49.3331 32.7294 47.441 36 46.6663 36ZM46.6663 53.3333V38.6666C47.441 38.6666 49.3331 41.9372 49.3331 47.9998C49.3331 49.8919 49.1331 51.7492 48.761 53.3331H46.6663V53.3333ZM58.6663 26.6667V25.3334C58.6663 24.5975 58.069 24.0002 57.3331 24.0002H57.3329H50.6316H45.3331H45.3329H38.5349H30.7976H23.9998H23.9996C23.2637 24.0002 22.6663 24.5975 22.6663 25.3334V26.6667H13.6477L39.9998 13.4906L66.3518 26.6666H58.6663V26.6667Z" fill="#231F20"/>
                            </svg>
                            <h4>Scarves</h4>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card p-4 border-0 text-center rounded-4">
                        <div class="card-body p-0 d-flex flex-column justify-content-center align-items-center">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M80 45.9492C80 44.7001 79.7589 43.3539 79.1195 42.0715C78.4823 40.789 77.4313 39.5997 75.9802 38.7232C74.5977 37.884 72.0348 36.3604 68.8661 34.5504L69.1072 34.1014C69.3719 33.614 69.1895 33.0053 68.7012 32.7415C68.213 32.4778 67.6052 32.6601 67.3403 33.1484L67.1188 33.559C65.6738 32.7425 64.1363 31.8875 62.548 31.0228C62.2714 30.8718 61.9852 30.7198 61.7047 30.5679L61.9303 30.1659C62.2028 29.6825 62.0303 29.0706 61.5459 28.799C61.0616 28.5284 60.4498 28.7011 60.1792 29.1843L59.9361 29.6187C58.1106 28.6481 56.2633 27.694 54.4436 26.7892L54.5358 26.6293C54.8142 26.15 54.6495 25.5353 54.1711 25.2578C53.6908 24.9793 53.077 25.144 52.7984 25.6234L52.6377 25.9039C49.918 24.5931 47.3139 23.4322 45.0491 22.592C42.7412 21.7439 40.9794 21.3154 39.4017 21.3076C38.5448 21.3067 37.7281 21.4489 36.9947 21.7695C36.4466 22.0087 35.9584 22.345 35.5603 22.7284C34.9622 23.305 34.5642 23.9578 34.2534 24.5901C33.9427 25.2256 33.7113 25.8559 33.4817 26.4786C32.9613 27.8943 32.4464 28.8425 31.868 29.5561C31.3817 30.1551 30.8464 30.6218 30.1973 31.0189C29.2288 31.6111 27.9717 32.0464 26.2981 32.3278C24.6284 32.6092 22.5617 32.7287 20.0694 32.7347H20.0322C18.6127 32.7337 17.5125 32.5297 16.6203 32.2209C15.2869 31.7542 14.3791 31.059 13.5691 30.2228C12.7613 29.3854 12.1053 28.4051 11.3406 27.4393C10.8161 26.7806 10.1553 26.2815 9.45328 25.9648C8.75031 25.6462 8.01203 25.5029 7.29437 25.5022C6.41594 25.504 5.56297 25.7139 4.79531 26.1247C4.03156 26.5345 3.33937 27.1628 2.89031 28.015C0.73625 32.124 0 36.3939 0 40.1715C0 42.6825 0.323594 44.9825 0.788281 46.9218C1.16172 48.464 1.61281 49.7553 2.10391 50.7965C2.27063 54.3123 2.76859 56.9929 2.77859 57.0508L3.0825 58.692H26.0366L28.1817 57.0479L34.7909 58.692H77.8822L78.1998 57.0686C78.5627 55.2095 78.7391 53.5115 78.7391 51.9437C78.7391 51.5848 78.7116 51.2476 78.6941 50.9025C79.0059 50.3622 79.2862 49.7817 79.5 49.1181C79.8019 48.165 79.998 47.0923 80 45.9492ZM74.5212 54.6761H35.2811L27.2748 52.6829L24.6737 54.6761H6.47875C6.37297 53.8584 6.25328 52.7956 6.17094 51.5789L74.6997 51.4082C74.7056 51.5887 74.7231 51.7553 74.7231 51.9436C74.7233 52.7729 74.6547 53.6868 74.5212 54.6761ZM75.6744 47.8962C75.49 48.4806 75.2292 48.9679 75.0528 49.1982L75.3214 49.3982L5.97687 49.5707C5.60031 48.9079 5.08078 47.6118 4.69344 45.9843C4.29844 44.3372 4.015 42.3342 4.01594 40.1714C4.01594 36.9084 4.65328 33.2995 6.4475 29.8807C6.46906 29.8376 6.53969 29.7464 6.69641 29.662C6.84937 29.5776 7.07484 29.517 7.29453 29.5189C7.475 29.5179 7.64656 29.5542 7.79359 29.6218C7.94172 29.6904 8.07109 29.7836 8.20234 29.9464C9.01797 30.9454 10.0759 32.6612 11.9123 34.1426C12.832 34.8807 13.9556 35.5495 15.3067 36.0162C16.6578 36.4848 18.2245 36.7506 20.0323 36.7506H20.0362H20.0755H20.0794C23.5619 36.7387 26.4228 36.5387 28.8934 35.8701C30.1269 35.5339 31.2633 35.074 32.2897 34.4465C33.3153 33.8222 34.225 33.0289 34.9878 32.0847C35.9389 30.912 36.6388 29.5276 37.2506 27.8657C37.4506 27.3226 37.6281 26.8529 37.7977 26.4882C37.9231 26.2147 38.0439 26.0029 38.1506 25.8529C38.3153 25.6264 38.4173 25.5461 38.5516 25.4734C38.688 25.4057 38.9153 25.3254 39.4016 25.3234C40.1839 25.3156 41.59 25.5872 43.6547 26.3578C45.6725 27.1029 48.0745 28.1697 50.6178 29.3903L48.2314 33.5129C48.1216 33.4973 48.0119 33.4787 47.8961 33.4787C46.4863 33.4787 45.345 34.6209 45.345 36.0298C45.345 37.4397 46.4863 38.5818 47.8961 38.5818C49.3059 38.5818 50.4473 37.4397 50.4473 36.0298C50.4473 35.4709 50.263 34.9582 49.9591 34.5386L52.4278 30.2717C54.2534 31.1757 56.1241 32.1395 57.9731 33.1229L55.9848 36.6692C55.8809 36.6564 55.7789 36.6378 55.673 36.6378C54.2631 36.6378 53.12 37.78 53.12 39.1898C53.12 40.5997 54.2631 41.7411 55.673 41.7411C57.0828 41.7411 58.2241 40.5998 58.2241 39.1898C58.2241 38.6222 58.0339 38.1036 57.7202 37.68L59.7419 34.072C60.0359 34.2307 60.3359 34.3906 60.6263 34.5495C62.2186 35.4162 63.7597 36.2751 65.2108 37.0939L63.7342 39.8262C63.6402 39.8154 63.548 39.7978 63.4498 39.7978C62.04 39.7978 60.8969 40.939 60.8969 42.3489C60.8969 43.7587 62.04 44.9009 63.4498 44.9009C64.8597 44.9009 66.0009 43.7587 66.0009 42.3489C66.0009 41.7723 65.803 41.2459 65.4814 40.8195L66.9559 38.0851C70.0561 39.8557 72.56 41.345 73.8936 42.155C74.7328 42.6706 75.2073 43.2403 75.527 43.8678C75.8408 44.4943 75.9839 45.2081 75.9839 45.9493C75.9841 46.6228 75.8625 47.31 75.6744 47.8962Z" fill="#231F20"/>
                            </svg>                                    
                            <h4>Shoes</h4>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card p-4 border-0 text-center rounded-4">
                        <div class="card-body p-0 d-flex flex-column justify-content-center align-items-center">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M64 45.333C64 58.5879 53.2549 69.333 40 69.333C26.7451 69.333 16 58.5879 16 45.333C16 35.4754 21.9541 27.0242 30.4528 23.3303L31.392 24.061L35.5195 27.2711C27.3952 29.2914 21.3333 36.5922 21.3333 45.333C21.3333 55.6258 29.7072 63.9997 40 63.9997C50.2928 63.9997 58.6667 55.6258 58.6667 45.333C58.6667 36.5922 52.6048 29.2914 44.4805 27.2711L49.5472 23.3309C58.0459 27.0247 64 35.4754 64 45.333ZM40 23.9997L53.3333 13.629L48 5.33301H32L26.6667 13.629L34.6667 19.8514L40 23.9997Z" fill="#231F20"/>
                            </svg>
                            <h4>Jewelry</h4>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card p-4 border-0 text-center rounded-4">
                        <div class="card-body p-0 d-flex flex-column justify-content-center align-items-center">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_92_3915)">
                                <path d="M47.9563 37.2792C47.9563 33.2777 48.6755 29.7636 49.7055 28.7337C49.8649 28.5741 49.9446 28.3651 49.9446 28.156C49.9446 27.9468 49.8647 27.7376 49.7053 27.578C49.3861 27.2592 48.869 27.259 48.5498 27.5782C47.52 28.6083 44.0062 29.3277 40.0049 29.3277C36.0037 29.3277 32.4898 28.6083 31.4603 27.5782C31.1412 27.2592 30.6241 27.259 30.3047 27.578C30.1451 27.7376 30.0654 27.9466 30.0654 28.1558C30.0654 28.365 30.145 28.5741 30.3046 28.7337C32.6201 31.05 32.6201 43.5083 30.3047 45.824C30.1451 45.9836 30.0654 46.1926 30.0654 46.4018C30.0654 46.6108 30.1451 46.8201 30.3047 46.9795C30.6239 47.2987 31.1412 47.2987 31.4601 46.9795C32.4898 45.9499 36.0033 45.2307 40.0049 45.2307C44.0066 45.2307 47.5203 45.9499 48.5502 46.9797C48.7098 47.1391 48.9188 47.2189 49.1279 47.2189C49.1292 47.2189 49.1307 47.2189 49.1316 47.2189C49.5828 47.2189 49.9486 46.853 49.9486 46.4018C49.9486 46.1567 49.8408 45.9368 49.6699 45.787C48.6588 44.7126 47.9563 41.2341 47.9563 37.2792ZM47.2327 44.5069C45.1644 43.854 42.4015 43.5963 40.0048 43.5963C37.6066 43.5963 34.8416 43.8542 32.7732 44.508C34.0135 40.6168 34.0135 33.9415 32.7732 30.0499C34.8418 30.704 37.6066 30.962 40.0048 30.962C42.4013 30.962 45.1644 30.7043 47.2327 30.0512C46.5798 32.1195 46.3221 34.8826 46.3221 37.2793C46.3221 39.6761 46.5796 42.4387 47.2327 44.5069Z" fill="#231F20"/>
                                <path d="M75.6808 49.1278C75.374 47.8824 74.54 44.7881 73.4406 43.0396C72.2846 41.2003 72.4327 37.5364 72.4344 37.4997C72.4349 37.4872 72.4322 37.4754 72.4322 37.4628C72.4322 37.4507 72.4349 37.4387 72.4344 37.4263C72.4327 37.3897 72.2846 33.7258 73.4406 31.8865C73.9483 31.079 74.3991 29.9841 74.7679 28.9171C74.9758 29.5019 75.2549 30.1073 75.63 30.6988C75.7411 30.8742 75.9147 31.0006 76.1159 31.0523C76.1754 31.0678 76.3951 31.1179 76.7174 31.1179C77.3709 31.1179 78.9918 30.884 79.9321 28.7186C80.0258 28.5029 80.0218 28.2571 79.9214 28.0443C79.8557 27.905 78.2847 24.654 75.1665 24.2801C74.7559 24.1824 72.3688 23.7136 69.0606 25.0792C68.3797 25.0044 66.1448 24.8125 61.0949 24.8025C60.2305 23.6454 58.7122 22.1459 56.5305 21.8876C56.0878 21.7808 53.3325 21.2247 49.4921 22.8181C48.7504 22.729 46.2135 22.4951 40.0045 22.4951C33.7957 22.4951 31.259 22.729 30.5173 22.8181C26.6776 21.225 23.9219 21.7808 23.4787 21.8876C21.2968 22.1458 19.7787 23.6452 18.914 24.8025C13.8569 24.8125 11.6193 25.0044 10.9382 25.0792C7.62961 23.7136 5.24269 24.1824 4.83216 24.2801C1.71387 24.6542 0.143111 27.9052 0.0772006 28.0443C-0.0232077 28.2571 -0.0270207 28.5027 0.066488 28.7186C1.00684 30.884 2.62772 31.1179 3.28119 31.1179C3.60329 31.1179 3.82299 31.0678 3.88273 31.0523C4.08373 31.0006 4.25731 30.8742 4.36861 30.6988C4.74374 30.1073 5.02299 29.5019 5.23071 28.9171C5.59948 29.9841 6.0505 31.0788 6.55798 31.8865C7.71059 33.7201 7.56697 37.3668 7.56443 37.426C7.56388 37.4385 7.56643 37.4507 7.56643 37.4632C7.56643 37.4755 7.56388 37.4874 7.56443 37.4997C7.56606 37.5364 7.71404 41.2003 6.55798 43.0396C5.45858 44.7881 4.62481 47.8824 4.31777 49.1278C1.5412 49.7693 0.139842 52.6722 0.0779269 52.8035C-0.0224814 53.0163 -0.0262944 53.262 0.0672143 53.4779C1.00738 55.6436 2.62862 55.8775 3.2821 55.8775C3.60402 55.8775 3.82372 55.8274 3.88346 55.812C4.08427 55.7602 4.25804 55.6337 4.36952 55.4584C5.46439 53.7317 5.74491 51.8871 5.80483 50.7808C5.9884 50.7935 6.19321 50.8019 6.41963 50.8019C7.50941 50.8019 9.07691 50.6145 10.9347 49.8485C11.6173 49.9285 13.8261 50.1241 19.0943 50.1241C20.4499 50.1241 21.9673 50.1117 23.1205 50.0923C23.0594 50.3269 23.0082 50.5324 22.9663 50.7038C19.7538 51.3967 18.128 54.7623 18.0565 54.9134C17.9561 55.1262 17.9522 55.3718 18.0457 55.5877C19.1059 58.0293 20.9236 58.2929 21.6559 58.2929C22.0234 58.2929 22.2745 58.233 22.3212 58.221C22.5222 58.1691 22.6958 58.0427 22.8071 57.8675C24.1091 55.8149 24.4065 53.6184 24.4595 52.3705C24.7017 52.3906 24.9814 52.405 25.298 52.405C26.5529 52.405 28.3651 52.1875 30.5176 51.2943C31.2593 51.3835 33.7961 51.6173 40.0048 51.6173C46.2138 51.6173 48.7507 51.3835 49.4924 51.2943C51.6451 52.1875 53.4568 52.405 54.7117 52.405C55.0283 52.405 55.3079 52.3908 55.5503 52.3705C55.6032 53.6184 55.9008 55.815 57.2026 57.8675C57.3137 58.0429 57.4873 58.1691 57.6885 58.221C57.7352 58.233 57.9863 58.2929 58.354 58.2929C59.0862 58.2929 60.9041 58.0293 61.9641 55.5877C62.0578 55.372 62.0538 55.1262 61.9534 54.9134C61.8819 54.7623 60.2557 51.3969 57.0434 50.7038C57.0016 50.5324 56.9502 50.3269 56.8892 50.0925C58.0411 50.1116 59.5536 50.1241 60.905 50.1241C66.1733 50.1241 68.3823 49.9285 69.0648 49.8485C70.9228 50.6145 72.4901 50.8021 73.5797 50.8019C73.8061 50.8019 74.0109 50.7935 74.1945 50.7808C74.2544 51.887 74.535 53.7317 75.6298 55.4584C75.7411 55.6338 75.9149 55.7602 76.1161 55.812C76.1756 55.8274 76.3953 55.8775 76.7172 55.8775C77.3707 55.8775 78.992 55.6436 79.9321 53.4779C80.0258 53.262 80.0218 53.0163 79.9214 52.8035C79.8595 52.6722 78.4581 49.7693 75.6808 49.1278ZM78.2624 28.415C77.807 29.2315 77.2445 29.4554 76.8069 29.4812C76.1288 28.2578 75.908 26.9799 75.8417 26.1329C77.0867 26.6529 77.9172 27.8384 78.2624 28.415ZM60.2975 26.5543C59.7067 27.6606 58.9473 27.9197 58.3825 27.9279C57.4948 26.3636 57.2515 24.7148 57.1928 23.7116C58.8302 24.301 59.8968 25.8703 60.2975 26.5543ZM22.817 23.7105C22.7584 24.7137 22.5153 26.3633 21.6274 27.9279C21.0624 27.9195 20.3025 27.6602 19.7115 26.5528C20.11 25.8676 21.1708 24.2985 22.817 23.7105ZM3.1924 29.4812C2.755 29.4554 2.19231 29.2314 1.73693 28.4152C2.08282 27.8373 2.91296 26.6527 4.15763 26.1329C4.09117 26.9803 3.87056 28.258 3.1924 29.4812ZM3.19258 54.2406C2.75518 54.2149 2.19231 53.991 1.73693 53.1743C2.08319 52.596 2.91442 51.4098 4.16071 50.8907C4.09607 51.735 3.87637 53.0096 3.19258 54.2406ZM19.0943 48.49C12.8147 48.49 10.9712 48.206 10.9558 48.2036C10.8015 48.1777 10.6424 48.1971 10.4981 48.2592C8.50405 49.1184 6.8977 49.2039 5.99784 49.1549C6.33992 47.8296 7.06511 45.3045 7.94209 43.9093C9.31749 41.7214 9.21563 37.8997 9.1991 37.4632C9.21563 37.0267 9.31749 33.205 7.94209 31.0171C7.06638 29.6239 6.34065 27.0975 5.9982 25.7715C6.8997 25.7211 8.50551 25.808 10.4981 26.6672C10.6364 26.727 10.7902 26.7464 10.9395 26.7253C10.9582 26.7224 12.7257 26.4775 17.9878 26.441C17.9722 26.5813 17.9884 26.7248 18.0457 26.8571C19.1059 29.2987 20.9236 29.5624 21.6559 29.5624C22.0234 29.5624 22.2745 29.5024 22.3212 29.4905C22.5222 29.4385 22.6958 29.3122 22.8071 29.1369C23.3156 28.3349 23.6699 27.5113 23.9172 26.7304C24.2754 27.8071 24.7096 28.9341 25.1987 29.8656C21.5368 31.2116 13.4379 30.8437 11.8106 29.2157C11.4914 28.8965 10.9743 28.8967 10.6551 29.2156C10.3359 29.5348 10.3359 30.0521 10.6549 30.3711C11.5228 31.2392 12.1291 34.2345 12.1291 37.6553C12.1291 41.0761 11.5228 44.0713 10.6551 44.9392H10.6549C10.3359 45.2582 10.3359 45.7755 10.6551 46.0945C10.8147 46.2541 11.0237 46.3338 11.2329 46.3338C11.4419 46.3338 11.6512 46.2541 11.8106 46.0945C13.3304 44.5749 20.7982 44.1246 24.7076 45.2831C24.264 46.3115 23.8816 47.4467 23.5804 48.4493C22.4076 48.4733 20.6186 48.49 19.0943 48.49ZM26.3482 41.5725C25.9232 38.9308 25.9724 35.5257 26.4681 33.0748C26.8363 35.0122 26.7589 36.9757 26.7571 37.0189C26.7566 37.0314 26.7593 37.0436 26.7593 37.0559C26.7593 37.0683 26.7566 37.0805 26.7571 37.093C26.7949 37.9228 26.7544 39.8603 26.3482 41.5725ZM13.0226 31.5923C16.3818 32.5991 21.8631 32.5706 25.148 31.6021C24.2204 34.7783 24.1739 40.1541 25.0869 43.4968C25.109 43.5783 25.1444 43.6524 25.1876 43.7201C22.1189 42.8148 16.4781 42.6868 13.0235 43.7141C14.0091 40.3778 14.0085 34.9276 13.0226 31.5923ZM21.6274 56.6586C21.0624 56.6503 20.3025 56.391 19.7115 55.2836C20.1098 54.5983 21.1708 53.0292 22.817 52.4413C22.7584 53.4446 22.5155 55.094 21.6274 56.6586ZM49.9284 49.7041C49.7857 49.6427 49.6252 49.6231 49.4728 49.6482C49.4521 49.6515 47.3127 49.9828 40.0047 49.9828C32.697 49.9828 30.5577 49.6516 30.5392 49.6486C30.3842 49.6226 30.2253 49.642 30.0815 49.7041C27.6252 50.763 25.6681 50.8211 24.6416 50.7436C25.0226 49.2471 25.8927 46.1528 26.9529 44.4664C28.5332 41.9523 28.4094 37.5346 28.3911 37.0559C28.4096 36.5773 28.5332 32.1595 26.9529 29.6453C25.8928 27.9591 25.0228 24.8651 24.6416 23.3685C25.6702 23.2915 27.6263 23.3496 30.0815 24.4081C30.2242 24.4693 30.3842 24.4887 30.537 24.4641C30.5577 24.4606 32.697 24.1294 40.0048 24.1294C47.3127 24.1294 49.4521 24.4606 49.4706 24.4637C49.6257 24.4897 49.7846 24.4702 49.9286 24.4079C52.3848 23.3492 54.3413 23.2913 55.3684 23.3683C54.9877 24.8642 54.1185 27.9569 53.0574 29.6453C51.4768 32.1595 51.6006 36.5773 51.619 37.0559C51.6005 37.5346 51.4768 41.9523 53.0574 44.4664C54.1187 46.1548 54.9893 49.2542 55.3695 50.7487C54.3507 50.8289 52.4079 50.773 49.9284 49.7041ZM66.9756 43.7139C63.5209 42.687 57.8797 42.8148 54.8115 43.7201C54.8547 43.6524 54.8903 43.5783 54.9125 43.4968C55.8254 40.1541 55.7791 34.7781 54.8511 31.6019C58.1363 32.5703 63.6173 32.5989 66.9769 31.5921C65.9908 34.9274 65.9903 40.3776 66.9756 43.7139ZM53.2508 37.0558C53.2508 37.0434 53.2533 37.0316 53.2528 37.0193C53.2515 36.9904 53.173 35.0371 53.5369 33.1013C54.0266 35.5464 54.0745 38.9297 53.6533 41.56C53.1589 39.4703 53.2508 37.1398 53.2528 37.093C53.2533 37.0805 53.2508 37.0683 53.2508 37.0558ZM60.2975 55.2849C59.7067 56.3913 58.9473 56.6503 58.3823 56.6584C57.4946 55.0942 57.2515 53.4454 57.1928 52.4422C58.8302 53.0316 59.8968 54.6011 60.2975 55.2849ZM69.5015 48.259C69.3589 48.1978 69.1993 48.1786 69.0463 48.2029C69.0283 48.206 67.1848 48.4898 60.905 48.4898C59.3853 48.4898 57.6024 48.4731 56.4297 48.4493C56.1281 47.4456 55.7455 46.3093 55.3014 45.28C59.2135 44.1254 66.6702 44.5757 68.1889 46.0941C68.3485 46.2537 68.5575 46.3335 68.7666 46.3335C68.9756 46.3335 69.185 46.2537 69.3444 46.0941C69.6636 45.7751 69.6636 45.2578 69.3446 44.9388C69.3446 44.9388 69.3446 44.9388 69.3444 44.9388C68.4767 44.0709 67.8704 41.0757 67.8704 37.6549C67.8704 34.2342 68.4767 31.2388 69.3446 30.3707C69.6636 30.0515 69.6636 29.5344 69.3444 29.2152C69.0252 28.8964 68.5081 28.8962 68.1889 29.2154C66.5628 30.8419 58.4758 31.2112 54.8093 29.8687C55.299 28.9367 55.7339 27.8082 56.0923 26.7306C56.3396 27.5113 56.6939 28.3349 57.2023 29.1368C57.3134 29.312 57.4872 29.4383 57.6883 29.4903C57.735 29.5023 57.9861 29.5622 58.3538 29.5622C59.0861 29.5622 60.9039 29.2985 61.9639 26.857C62.0213 26.7244 62.0377 26.5813 62.0219 26.441C67.2758 26.4777 69.0414 26.7224 69.0586 26.725C69.2093 26.7473 69.3622 26.7271 69.5013 26.667C71.4953 25.8075 73.1016 25.7218 74.0011 25.771C73.6587 27.097 72.9328 29.6235 72.0571 31.0169C70.6817 33.2048 70.7837 37.0265 70.8004 37.463C70.7837 37.8995 70.6817 41.7212 72.0571 43.9091C72.9341 45.3043 73.6607 47.8359 74.0026 49.1603C73.1105 49.2121 71.5171 49.1276 69.5015 48.259ZM76.8069 54.2406C76.1288 53.017 75.908 51.739 75.8417 50.8919C77.0867 51.412 77.9172 52.5976 78.2626 53.1743C77.807 53.9908 77.2445 54.215 76.8069 54.2406Z" fill="#231F20"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_92_3915">
                                <rect width="80" height="80" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                            <h4>Jewelry</h4>
                        </div>
                    </div>
                </div>
                <div class="col mb-5">
                    <div class="card p-4 border-0 text-center rounded-4">
                        <div class="card-body p-0 d-flex flex-column justify-content-center align-items-center">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_92_3963)">
                                <path d="M73.6911 5.93973C73.1215 5.37035 72.1986 5.37035 71.6292 5.93973C71.0598 6.5091 71.0598 7.43223 71.6292 8.00129C75.1473 11.5193 77.0846 16.1968 77.0846 21.1721V34.1805C77.0846 34.9857 77.7371 35.6383 78.5425 35.6383C79.3478 35.6383 80.0003 34.9857 80.0003 34.1805V21.1722C80.0004 15.4183 77.7596 10.0086 73.6911 5.93973Z" fill="#231F20"/>
                                <path d="M78.5422 36.8044C77.7369 36.8044 77.0844 37.4571 77.0844 38.2622V48.4986C74.9799 46.1399 71.9198 44.6508 68.5173 44.6508H11.4828C8.08031 44.6508 5.02016 46.1397 2.91578 48.4986V21.1721C2.91578 16.1969 4.85344 11.5194 8.37125 8.00129C8.94063 7.43191 8.94063 6.50895 8.37125 5.93973C7.80188 5.37051 6.87891 5.3702 6.30938 5.93973C2.24063 10.0085 0 15.4182 0 21.1721V56.1336V62.398C0 69.0644 5.42344 74.4879 12.09 74.4879C18.6919 74.4879 24.8984 71.9169 29.5664 67.2486C30.1358 66.6793 30.1358 65.7561 29.5663 65.1871C28.997 64.6175 28.0739 64.6177 27.5047 65.1871C23.3873 69.3047 17.9131 71.5721 12.09 71.5721C7.03141 71.5721 2.91594 67.4566 2.91594 62.398V56.1336C2.91594 51.4097 6.75906 47.5664 11.483 47.5664H33.8894V49.7729C33.8894 54.1574 32.5936 58.3844 30.1425 61.9968C29.6903 62.6632 29.8639 63.5697 30.5303 64.0216C31.1969 64.4739 32.1033 64.2999 32.5552 63.6338C34.5558 60.6857 35.8734 57.3763 36.4578 53.9007H43.5423C45.513 65.5702 55.6891 74.4875 67.9105 74.4875C74.5769 74.4875 80.0003 69.0641 80.0003 62.3977V56.1333V38.2621C80 37.4572 79.3474 36.8044 78.5422 36.8044ZM43.1953 49.7729V50.9852H36.805V49.7729V47.5664H43.1953V49.7729ZM77.0842 62.398C77.0842 67.4566 72.9688 71.5721 67.9102 71.5721C55.8902 71.5721 46.1109 61.7929 46.1109 49.7729V47.5664H68.5172C73.2411 47.5664 77.0842 51.4096 77.0842 56.1336V62.398Z" fill="#231F20"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_92_3963">
                                <rect width="80" height="80" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                            <h4>Pillows</h4>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>