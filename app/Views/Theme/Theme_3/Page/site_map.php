<section class="main-container my-0">
    <div class="container">
        <div class="contact-form bg-white  p-4 p-lg-5 mb-5 mt-5">
            <div class="row">
                <div class="col-lg-12 ">
                    <h3 class="text-capitalize mb-4"><?php echo $pageData->page_title;?></h3>
                    <?php //echo $pageData->page_description;?>
                    <?php
                        $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . "/sitemap.xml");

                        $view = "<ul>";
                        foreach ($xml->page as $val){
                            $view .= "<li> ";
                            if ($val->parent == '0'){
                                $view .= "<a href=".$val->url.">".htmlspecialchars($val->title)."</a>";
                            }
                            $view .= "<ul>";
                            if ($val->parent == '1'){
                                $view .= "<li class='li-css'><div><a href=".$val->url.">".htmlspecialchars($val->title)."</a></div></li>";
                            }
                            $view .= "</ul></li>";

                        }
                        $view .= "</ul>";
                        echo $view;
                    ?>


                </div>
            </div>
        </div>
    </div>
</section>