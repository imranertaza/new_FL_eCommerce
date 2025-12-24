<div class="accordion">
    <?php $uid = $prefix ?? 'default'; ?>
    <?php foreach (getSideMenuArray() as $pcat) { ?>

        <!--single-->
        <div class="accordion-item border-0">
            <h2 class="accordion-header d-flex p-1" >
                <a href="<?php echo base_url('category/' . $pcat->prod_cat_id); ?>" class="accordion-button collapsed py-2 px-2">
                                                <span class="arrow-width">
                                                    <svg class="svgIcon-accordion" width="100%" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="24" height="24" fill="white"/>
                                                    <path d="M9.5 7L14.5 12L9.5 17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>

                                                </span>
                    <span><?php echo $pcat->category_name; ?></span></a>
                    <?php $pCatAr = getCategoryBySubArray($pcat->prod_cat_id,$pcat->order_by,$pcat->order_type); if (!empty(count($pCatAr))) { ?>
                        <button class="btn ms-auto button-collapse py-2 collappse-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target= <?="#panelsStayOpen-collapse-".$uid."-".$pcat->prod_cat_id?> aria-expanded="false"
                                aria-controls=<?="panelsStayOpen-collapse-".$uid."-".$pcat->prod_cat_id?>>
                        </button>
                    <?php }?>


            </h2>
            <div id="<?="panelsStayOpen-collapse-".$uid."-".$pcat->prod_cat_id?>" class="accordion-collapse collapse"  >

                <?php if (!empty(count($pCatAr))) { ?>
                    <div class="accordion-body p-0">
                        <?php foreach ($pCatAr as $sCat) { ?>
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header d-flex" id="<?="panelsStayOpen-panelsStayOpen-heading-".$uid.$pcat->prod_cat_id."-inner-heading".$sCat->prod_cat_id?>">
                                    <a href=<?php echo base_url('category/' . $sCat->prod_cat_id); ?> class="accordion-button collapsed py-2 px-2 pl-20">
                                    <span class="arrow-width">
                                                                <svg class="svgIcon-accordion" width="100%" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="24" height="24" fill="white"/>
                                                                <path d="M9.5 7L14.5 12L9.5 17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </span>
                                    <span> <?php echo $sCat->category_name; ?></span></a>
                                    <?php $sCatAr = getCategoryBySubArray($sCat->prod_cat_id,$sCat->order_by,$sCat->order_type); if (!empty(count($sCatAr))) { ?>
                                        <button class="btn ms-auto button-collapse py-2 collappse-btn"
                                                id= "<?="accordionPanelsStayOpen-panelsStayOpen-heading-".$uid.$pcat->prod_cat_id."-inner-heading".$sCat->prod_cat_id?>" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target=<?="#panelsStayOpen-panelsStayOpen-heading-".$uid.$pcat->prod_cat_id."-inner-collapse".$sCat->prod_cat_id?> aria-expanded="false"
                                                 >
                                        </button>
                                    <?php }?>

                                </h2>
                                <div id="<?="panelsStayOpen-panelsStayOpen-heading-".$uid.$pcat->prod_cat_id."-inner-collapse".$sCat->prod_cat_id?>" class="accordion-collapse collapse" >
                                    <!-- Add your inner accordion content here -->
                                    <!-- Example: -->
                                    <?php if (!empty(count($sCatAr))) { ?>
                                        <div class="accordion-body p-0">
                                            <?php foreach ($sCatAr as $ssCat) { ?>
                                                <div class="accordion-item border-0 ">
                                                    <h2 class="accordion-header d-flex" id="panelsStayOpen-panelsStayOpen-heading-<?= $uid?>-<?= $ssCat->prod_cat_id?>-inner-heading-2">
                                                        <a href="<?php echo base_url('category/' . $ssCat->prod_cat_id); ?>" class="accordion-button collapsed py-2 px-2 pl-34">
                                                                            <span class="arrow-width">
                                                                                <svg class="svgIcon-accordion" width="100%" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <rect width="24" height="24" fill="white"/>
                                                                                <path d="M9.5 7L14.5 12L9.5 17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                </svg>
                                                                            </span>
                                                            <span><?php echo $ssCat->category_name; ?></span></a>
                                                            <?php if (!empty(count(getCategoryBySubArray($ssCat->prod_cat_id,$ssCat->order_by,$ssCat->order_type)))) { ?>
                                                                <button class="btn ms-auto button-collapse py-2 collappse-btn" type="button"
                                                                        data-bs-toggle="collapse" >
                                                                </button>
                                                            <?php }?>

                                                    </h2>

                                                </div>
                                            <?php }?>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                <?php }?>
            </div>
        </div>
        <!--single end-->
    <?php } ?>
</div>