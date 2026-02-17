<?php

use App\Libraries\Permission;
use CodeIgniter\Session\Session;
use Config\Services;

/**
 * @description This function provides database connection
 * @return \CodeIgniter\Database\BaseConnection
 */
function DB()
{
    $db = \Config\Database::connect();
    return $db;
}

/**
 * @description This function provides Session
 * @return Session
 */
function newSession()
{
    $session = \Config\Services::session();
    return $session;
}

/**
 * @description This function provides cart
 * @return mixed
 */
function Cart()
{
    $cart = \Config\Services::cart();
    return $cart;
}

/**
 * @description This function provides bd date format
 * @param string $data
 * @return false|string
 */
function bdDateFormat($data = '0000-00-00')
{
    return ($data == '0000-00-00') ? 'Unknown' : date('d/m/y', strtotime($data));
}


/**
 * @description This function provides global date format
 * @param string $datetime
 * @return false|string
 */
function globalDateTimeFormat($datetime = '0000-00-00 00:00:00')
{

    if ($datetime == '0000-00-00 00:00:00' or $datetime == '0000-00-00' or $datetime == '') {
        return 'Unknown';
    }
    return date('h:i A d/m/y', strtotime($datetime));
}

/**
 * @description This function provides invoice date format
 * @param string $datetime
 * @return false|string
 */
function invoiceDateFormat($datetime = '0000-00-00 00:00:00')
{

    if ($datetime == '0000-00-00 00:00:00' or $datetime == '0000-00-00' or $datetime == '') {
        return 'Unknown';
    }
    //    return date('d M Y h:i A ', strtotime($datetime));
    return date('d M Y', strtotime($datetime));
}

/**
 * @description This function provides sale date format
 * @param string $datetime
 * @return string
 */
function saleDate($datetime = '0000-00-00 00:00:00')
{

    if ($datetime == '0000-00-00 00:00:00' or $datetime == '0000-00-00' or $datetime == '') {
        return 'Unknown';
    }

    $date = date('d/m/y', strtotime($datetime));
    $time = date('h:i a', strtotime($datetime));

    return $date . ' ' . $time;
}

/**
 * @description This function provides get data by id
 * @param string|int $needCol
 * @param string $table
 * @param string|int $whereCol
 * @param string|int $whereInfo
 * @return false|null
 */
function get_data_by_id($needCol, $table, $whereCol, $whereInfo)
{
    $table = DB()->table($table);

    $query = $table->where($whereCol, $whereInfo)->get();
    $findResult = $query->getRow();
    if (!empty($findResult)) {
        $col = ($findResult->$needCol == NULL) ? NULL : $findResult->$needCol;
    } else {
        $col = false;
    }
    return $col;
}

/**
 * @description This function provides get  last row by id
 * @param string|int $needCol
 * @param string $table
 * @param string|int $whereCol
 * @param string|int $whereInfo
 * @return false|null
 */
function getLastRowById($needCol, $table, $whereCol, $whereInfo)
{
    $table = DB()->table($table);

    $query = $table->where($whereCol, $whereInfo)->get();
    $findResult = $query->getLastRow();
    if (!empty($findResult)) {
        $col = ($findResult->$needCol == NULL) ? NULL : $findResult->$needCol;
    } else {
        $col = false;
    }
    return $col;
}

/**
 * @description This function provides show with currency symbol
 * @param string|int|float  $money
 * @return string
 */
function showWithCurrencySymbol($money)
{
    //    $table = DB()->table('gen_settings');
    //    $currency_before_symbol = $table->where('sch_id',$_SESSION['shopId'])->where('label','currency_before_symbol')->get()->getRow();
    //    $currency_after_symbol = $table->where('sch_id',$_SESSION['shopId'])->where('label','currency_after_symbol')->get()->getRow();
    //    $result = $currency_before_symbol->value." ".number_format($money, 2, '.', ',')." ".$currency_after_symbol->value;
    //    return $result;
    return '৳ ' . number_format($money, 2, '.', ',') . ' /-';
}

/**
 * @description This function provides status view
 * @param int $selected
 * @return string
 */
function statusView($selected = '1')
{
    $status = [
        '0' => 'Inactive',
        '1' => 'Active',
    ];

    $row = '';
    foreach ($status as $key => $option) {
        $row .= ($selected == $key) ? $option : '';
    }
    return $row;
}

/**
 * @description This function provides global status view
 * @param int $selected
 * @return string
 */
function globalStatus($selected = 'sel')
{
    $status = [
        '1' => 'Active',
        '0' => 'Inactive',
    ];

    $row = '';
    foreach ($status as $key => $option) {
        $row .= '<option value="' . $key . '"';
        $row .= ($selected == $key) ? ' selected' : '';
        $row .= '>' . $option . '</option>';
    }
    return $row;
}

/**
 * @description This function provides get package other db
 * @param int $selected
 * @return string
 * @throws Exception
 */
function get_package_other_db($selected = 'sel')
{

    $db2 = \Config\Database::connect('custom');
    $newDb = $db2->database;
    DB()->query('use ' . $newDb);
    $packageTable = $db2->table('package');
    $pack = $packageTable->get()->getResult();

    $row = '';
    foreach ($pack as $key => $option) {
        $row .= '<option value="' . $option->package_id . '"';
        $row .= ($selected == $option->package_id) ? ' selected' : '';
        $row .= '>' . $option->package_name . '</option>';
    }
    return $row;
}

/**
 * @description This function provides package expiry
 * @param int $shop_id
 * @return string
 * @throws Exception
 */
function package_expiry($shop_id)
{

    $db2 = \Config\Database::connect('custom');
    $newDb = $db2->database;
    $db2->query('use ' . $newDb);

    $tab = $db2->table('license');
    $pack = $tab->where('sch_id', $shop_id)->get()->getRow();

    $end_date = '';
    if (!empty($pack)) {
        $end_date = $pack->end_date;
    }
    return $end_date;
}

/**
 * @description This function provides get list in option
 * @param string $selected
 * @param int $tblId
 * @param string $needCol
 * @param string $table
 * @return string
 */
function getListInOption($selected, $tblId, $needCol, $table)
{
    $table = DB()->table($table);
    $query = $table->get();
    $options = '';
    foreach ($query->getResult() as $value) {
        $options .= '<option value="' . $value->$tblId . '" ';
        $options .= ($value->$tblId == $selected) ? ' selected="selected"' : '';
        $options .= '>' . $value->$needCol . '</option>';
    }
    return $options;
}

/**
 * @description This function provides get id by list in option
 * @param int|string $selected
 * @param int|string $tblId
 * @param int|string $needCol
 * @param string $table
 * @param int|string $where
 * @param int|string $needwhere
 * @return string
 */
function getIdByListInOption($selected, $tblId, $needCol, $table, $where, $needwhere)
{
    $table = DB()->table($table);
    $query = $table->where($where, $needwhere)->get();
    $options = '';
    foreach ($query->getResult() as $value) {
        $options .= '<option value="' . $value->$tblId . '" ';
        $options .= ($value->$tblId == $selected) ? ' selected="selected"' : '';
        $options .= '>' . $value->$needCol . '</option>';
    }
    return $options;
}

/**
 * @description This function provides image view
 * @param int|string $url
 * @param int|string $slug
 * @param int|string $image
 * @param int|string $no_image
 * @param int|string $class
 * @param int|string $id
 * @return string
 */
function image_view($url, $slug, $image, $no_image, $class = '', $id = '')
{
    $bas_url = base_url();

    $dir = FCPATH . '/' . $url . '/' . $slug;
    $img = $bas_url . '/' . $url . '/' . $slug . '/' . $image;

    if (empty($slug)) {
        $dir = FCPATH . '/' . $url;
        $img = $bas_url . '/' . $url . '/' . $image;
    }
    $no_img = $bas_url . '/' . $url . '/' . $no_image;
    if (!empty($image)) {
        if (!file_exists($dir)) {
            $result = '<img data-sizes="auto" id="' . $id . '" src="' . $no_img . '" class="' . $class . '" loading="lazy">';
        } else {
            $imgPath = $dir . '/' . $image;
            if (file_exists($imgPath)) {
                $result = '<img data-sizes="auto" leance id="' . $id . '" src="' . $img . '" class="' . $class . '" loading="lazy">';
            } else {
                $result = '<img data-sizes="auto" id="' . $id . '" src="' . $no_img . '" class="' . $class . '" loading="lazy">';
            }
        }
    } else {
        $result = '<img data-sizes="auto" id="' . $id . '" src="' . $no_img . '" class="' . $class . '" loading="lazy">';
    }
    return $result;
}

/**
 * @description This function provides multi image view
 * @param int|string $url
 * @param int|string $slug
 * @param int|string $slug2
 * @param int|string $image
 * @param int|string $no_image
 * @param int|string $class
 * @return string
 */
function multi_image_view($url, $slug, $slug2, $image, $no_image, $class = '',$id='')
{
    $bas_url = base_url();

    $dir = FCPATH . '/' . $url . '/' . $slug . '/' . $slug2;
    $img = $bas_url . '/' . $url . '/' . $slug . '/' . $slug2 . '/' . $image;


    $no_img = $bas_url . '/' . $url . '/' . $no_image;
    if (!empty($image)) {
        if (!file_exists($dir)) {
            $result = '<img data-sizes="auto" src="' . $no_img . '" class="' . $class . '" id="'.$id.'" loading="lazy">';
        } else {
            $imgPath = $dir . '/' . $image;
            if (file_exists($imgPath)) {
                $result = '<img data-sizes="auto" src="' . $img . '" class="' . $class . '" id="'.$id.'" loading="lazy">';
            } else {
                $result = '<img data-sizes="auto" src="' . $no_img . '" class="' . $class . '" id="'.$id.'" loading="lazy">';
            }
        }
    } else {
        $result = '<img data-sizes="auto" src="' . $no_img . '" class="' . $class . '" id="'.$id.'" loading="lazy">';
    }
    return $result;
}

/**
 * @description This function provides exists check
 * @param string $table
 * @param string|int $whereCol
 * @param string|int $whereInfo
 * @return bool
 */
function is_exists($table, $whereCol, $whereInfo)
{
    $table = DB()->table($table);
    $query = $table->where($whereCol, $whereInfo)->countAllResults();
    if (!empty($query)) {
        $col = false;
    } else {
        $col = true;
    }
    return $col;
}

/**
 * @description This function provides exists check double condition
 * @param string|int $table
 * @param string|int $whereCol
 * @param string|int $whereInfo
 * @param string|int $orWhereCol
 * @param string|int $orWhereInfo
 * @return bool
 */
function is_exists_double_condition($table, $whereCol, $whereInfo, $orWhereCol, $orWhereInfo)
{
    $table = DB()->table($table);
    $query = $table->where($whereCol, $whereInfo)->where($orWhereCol, $orWhereInfo)->countAllResults();
    if (!empty($query)) {
        $col = false;
    } else {
        $col = true;
    }
    return $col;
}

/**
 * @description This function provides exists check update
 * @param string|int $table
 * @param string|int $whereCol
 * @param string|int $whereInfo
 * @param string|int $whereId
 * @param string|int $id
 * @return bool
 */
function is_exists_update($table, $whereCol, $whereInfo, $whereId, $id)
{
    $table = DB()->table($table);
    $query = $table->where($whereCol, $whereInfo)->where($whereId . ' !=', $id)->countAllResults();
    if (!empty($query)) {
        $col = false;
    } else {
        $col = true;
    }
    return $col;
}

/**
 * @description This function provides add main based menu with permission
 * @param string $title
 * @param string $url
 * @param string $roleId
 * @param string $icon
 * @param string $module_name
 * @return string|void
 */
function add_main_based_menu_with_permission($title, $url, $roleId, $icon, $module_name)
{

    $active_url = current_url(true);

    $permission = new Permission();

    // $module_name = ucfirst($url);
    $menu = '';

    $access = $permission->have_access($roleId, $module_name, 'mod_access');
    if ($access == 1) {
        $class_active = ($active_url === $url) ? 'active' : '';
        $menu .= '<li class="nav-item" ><a class="nav-link' . $class_active . '"  href="' . $url . '" >';
        $menu .= '<i class="nav-icon fas ' . $icon . '"></i>';
        $menu .= '<p>' . $title . '</p>';
        $menu .= '</a><li>';

        return $menu;
    }
}

/**
 * @description This function provides all menu permission check
 * @param string $module_name_array
 * @param string|int $role_id
 * @return bool
 */
function all_menu_permission_check($module_name_array, $role_id)
{
    $permission = new Permission();

    foreach ($module_name_array as $module_name) {
        $access[] = $permission->have_access($role_id, $module_name, 'mod_access');
    }

    if (empty(array_filter($access))) {
        $result = false;
    } else {
        $result = true;
    }

    return $result;
}

/**
 * @description This function provides admin username
 * @return mixed
 */
function admin_user_name()
{
    $userId = newSession()->adUserId;
    $table = DB()->table('cc_users');
    $query = $table->where('user_id', $userId)->get()->getRow()->name;
    return $query;
}

/**
 * @description This function provides all settings
 * @return array
 */
function get_settings(){
    $table = DB()->table('cc_settings');
    $data = $table->get()->getResult();

    $settings = array();
    foreach ($data as $key=>$val){
        foreach($val as $k=>$v) {
            if ($k == 'label'){
                $settings[$v] = $data[$key]->value;
            }
        }
    }
    return $settings;
}

/**
 * @description This function provides get label by value in settings
 * @param string $lable
 * @return string
 */
function get_lebel_by_value_in_settings($lable)
{
    $table = DB()->table('cc_settings');
    $data = $table->where('label', $lable)->get()->getRow();
    if (!empty($data)) {
        $result = $data->value;
    } else {
        $result = '';
    }
    return $result;
}

/**
 * @description This function provides get label by title in settings
 * @param string $lable
 * @return string
 */
function get_lebel_by_title_in_settings($lable)
{
    $table = DB()->table('cc_settings');
    $data = $table->where('label', $lable)->get()->getRow();
    if (!empty($data)) {
        $result = $data->title;
    } else {
        $result = '';
    }
    return $result;
}

/**
 * @description This function provides get list in parent category
 * @param int $selected
 * @return string
 */
function getListInParentCategory($selected)
{
    $table = DB()->table('cc_product_category');
    $query = $table->where('parent_id', null)->get();
    $options = '';
    foreach ($query->getResult() as $value) {
        $options .= '<option value="' . $value->prod_cat_id . '" ';
        $options .= ($value->prod_cat_id == $selected) ? ' selected="selected"' : '';
        $options .= '>' . $value->category_name . '</option>';
    }
    return $options;
}

/**
 * @description This function provides get parent category array
 * @return array
 */
function getParentCategoryArray()
{
    $table = DB()->table('cc_product_category');
    $query = $table->where('parent_id', null)->get()->getResult();
    return $query;
}

/**
 * @description This function provides get category by sub array
 * @param int $cat_id
 * @return array
 */
function getCategoryBySubArray($cat_id,$orderBy,$type)
{
    $table = DB()->table('cc_product_category');
    $query = $table->where('parent_id', $cat_id)->where('status','1')->orderBy($orderBy, $type)->get()->getResult();
    return $query;
}

/**
 * @description This function provides check is parent category
 * @param int $product_category_id
 * @return mixed
 */
function check_is_parent_category($product_category_id)
{
    $table = DB()->table('cc_product_category');
    $cat = $table->where('prod_cat_id', $product_category_id)->get()->getRow();
    if (!empty($cat->parent_id)) {
        $result = $cat->parent_id;
    } else {
        $result = $cat->prod_cat_id;
    }
    return $result;
}

/**
 * @description This function provides check is sub category
 * @param int $product_category_id
 * @return bool
 */
function check_is_sub_category($product_category_id)
{
    $table = DB()->table('cc_product_category');
    $cat = $table->where('prod_cat_id', $product_category_id)->get()->getRow();
    if (!empty($cat->parent_id)) {
        $result = false;
    } else {
        $result = true;
    }
    return $result;
}

/**
 * @description This function provides available theme
 * @param string $sel
 * @return string
 */
function available_theme($sel = '')
{
    helper('filesystem');
    $file = get_dir_file_info(FCPATH . '../app/Views/Theme');
    $view = '';
    foreach ($file as $key => $val) {
        $s = ($key == $sel) ? "selected" : "";
        $view .= '<option value="' . $key . '" ' . $s . ' >' . $key . '</option>';
    }
    return $view;
}

/**
 * @description This function provides country
 * @param string $sel
 * @return string
 */
function country($sel = '')
{
    $table = DB()->table('cc_country');
    $data = $table->get()->getResult();
    $options = '';
    foreach ($data as $value) {
        $options .= '<option value="' . $value->country_id . '" ';
        $options .= ($value->country_id == $sel) ? ' selected="selected"' : '';
        $options .= '>' . $value->name . '</option>';
    }
    return $options;
}

/**
 * @description This function provides state with country
 * @param string $country
 * @param string|int $sel
 * @return string
 */
function state_with_country($country, $sel = '')
{
    $table = DB()->table('cc_zone');
    $data = $table->where('country_id', $country)->get()->getResult();
    $options = '';
    foreach ($data as $value) {
        $options .= '<option value="' . $value->zone_id . '" ';
        $options .= ($value->zone_id == $sel) ? ' selected="selected"' : '';
        $options .= '>' . $value->name . '</option>';
    }
    return $options;
}

/**
 * @description This function provides attribute array by product_id
 * @param int $productId
 * @return array
 */
function attribute_array_by_product_id($productId)
{
    $table = DB()->table('cc_product_attribute');
    $query = $table->where('product_id', $productId)->get()->getResult();

    return $query;
}

/**
 * @description This function provides get all data array
 * @param string $table
 * @return array
 */
function get_all_data_array($table)
{
    $tableSel = DB()->table($table);
    $query = $tableSel->get()->getResult();

    return $query;
}

/**
 * @description This function provides get array data by id
 * @param string $table
 * @param string $whereInfo
 * @param string|int $whereId
 * @return array
 */
function get_array_data_by_id($table, $whereInfo, $whereId)
{
    $tableSel = DB()->table($table);
    $query = $tableSel->where($whereInfo, $whereId)->get()->getResult();

    return $query;
}

/**
 * @description This function provides category id by product count
 * @param int $category_id
 * @return int|string
 */
function category_id_by_product_count($category_id)
{
    $table = DB()->table('cc_product_to_category');
    $count = $table->join('cc_products', 'cc_products.product_id = cc_product_to_category.product_id')->where('cc_product_to_category.category_id', $category_id)->where('cc_products.status','Active')->countAllResults();
    return $count;
}

/**
 * @description This function provides check review
 * @param int $productId
 * @return int|string
 */
function check_review($productId)
{
    $table = DB()->table('cc_product_feedback');
    $count = $table->where('product_id', $productId)->where('customer_id', newSession()->cusUserId)->countAllResults();
    return $count;
}

/**
 * @description This function provides product id by rating
 * @param int $productId
 * @param int $ratingCount
 * @return string
 */
function product_id_by_rating($productId, $ratingCount = 0)
{

    $table = DB()->table('cc_product_feedback');
    $pro = $table->where('product_id', $productId)->get()->getResult();

    $average = 0;
    $numberOfReviews = count($pro);
    if (!empty($numberOfReviews)) {
        $totalStar = 0;
        foreach ($pro as $val) {
            $totalStar += $val->feedback_star;
        }
        $average = $totalStar / $numberOfReviews;
    }
    $sty = (!empty($ratingCount)) ? 'display: flex;' : '';
    $view = '<div class="js-wc-star-rating" style="' . $sty . '">';
    $starColor = 'rgb(0, 0, 0)';
    $starType = 'fa-solid';
    for ($x = 1; $x <= 5; $x++) {
        if ($x > $average) {
            $starColor = 'lightgray';
            $starType = 'fa-regular';
        }
        $view .= '<i data-index="0"  class="' . $starType . ' fa-star" style="color: ' . $starColor . '; margin: 2px; font-size: 1em;"></i>';
    }

    if (!empty($ratingCount)) {
        $view .= $numberOfReviews . ' Rating';
    }
    $view .= '</div>';

    return $view;
}

/**
 * @description This function provides product id by average rating
 * @param int $productId
 * @return float|int
 */
function product_id_by_average_rating($productId)
{
    $table = DB()->table('cc_product_feedback');
    $pro = $table->where('product_id', $productId)->get()->getResult();

    $average = 0;
    $numberOfReviews = count($pro);
    if (!empty($numberOfReviews)) {
        $totalStar = 0;
        foreach ($pro as $val) {
            $totalStar += $val->feedback_star;
        }
        $average = $totalStar / $numberOfReviews;
    }
    return $average;
}

/**
 * @description This function provides available template
 * @param string $sel
 * @return string
 */
function available_template($sel = '')
{
    helper('filesystem');
    $tem = get_lebel_by_value_in_settings('Theme');
    $file = get_dir_file_info(FCPATH . '../app/Views/Theme/' . $tem . '/Page');
    $view = '';
    foreach ($file as $key => $val) {
        $s = ($key == $sel) ? "selected" : "";
        $view .= '<option value="' . $key . '" ' . $s . ' >' . $key . '</option>';
    }
    return $view;
}

/**
 * @description This function provides top menu
 * @return string
 */
function top_menu()
{
    $table = DB()->table('cc_product_category');
    $query = $table->where('header_menu', '1')->get()->getResult();
    $view = '';
    foreach ($query as $val) {
        $url = base_url('category/' . $val->prod_cat_id);
        $view .= '<li class="nav-item"><a class="nav-link" aria-current="page" href="' . $url . '" >' . $val->category_name . '</a></li>';
    }
    return $view;
}

/**
 * @description This function provides modules key by access
 * @param string $key
 * @return string
 */
function modules_key_by_access($key)
{
    $table = DB()->table('cc_modules');
    $data = $table->where('module_key', $key)->get()->getRow();
    if (!empty($data)) {
        $result = $data->status;
    } else {
        $result = '';
    }
    return $result;
}

/**
 * @description This function provides get label by value in theme settings
 * @param string $lable
 * @return string
 */
function get_lebel_by_value_in_theme_settings($lable)
{
    $table = DB()->table('cc_theme_settings');
    $data = $table->where('label', $lable)->get()->getRow();
    return $data;
}

/**
 * @description This function provides get label by title in theme settings
 * @param string $lable
 * @return string
 */
function get_lebel_by_title_in_theme_settings($lable)
{
    $table = DB()->table('cc_theme_settings');
    $data = $table->where('label', $lable)->get()->getRow();
    if (!empty($data)) {
        $result = $data->title;
    } else {
        $result = '';
    }
    return $result;
}

/**
 * @description This function provides get label by title in theme settings with theme
 * @param string $lable
 * @param string $theme
 * @return string
 */
function get_lebel_by_title_in_theme_settings_with_theme($lable, $theme)
{
    $table = DB()->table('cc_theme_settings');
    $data = $table->where('label', $lable)->where('theme', $theme)->get()->getRow();
    if (!empty($data)) {
        $result = $data->title;
    } else {
        $result = '';
    }
    return $result;
}

/**
 * @description This function provides get label by value in theme settings with theme
 * @param string $lable
 * @param string $theme
 * @return string
 */
function get_lebel_by_value_in_theme_settings_with_theme($lable, $theme)
{
    $table = DB()->table('cc_theme_settings');
    $data = $table->where('label', $lable)->where('theme', $theme)->get()->getRow();
    if (!empty($data)) {
        $result = $data->value;
    } else {
        $result = '';
    }
    return $result;
}

/**
 * @description This function provides email send
 * @param string $to
 * @param string $subject
 * @param string $message
 * @return void
 */
function email_send($to, $subject, $message,$replyEmail=null,$title=null)
{

    $email = \Config\Services::email();

    $config['protocol'] = get_lebel_by_value_in_settings('mail_protocol');
    $config['SMTPHost'] = get_lebel_by_value_in_settings('smtp_host');
    $config['SMTPUser'] = get_lebel_by_value_in_settings('smtp_username');
    $config['SMTPPass'] = get_lebel_by_value_in_settings('smtp_password');
    $config['SMTPPort'] = get_lebel_by_value_in_settings('smtp_port');
    $config['SMTPCrypto'] = get_lebel_by_value_in_settings('smtp_crypto');
    $config['mailType'] = 'html';
    $config['charset'] = 'utf-8';

    $email->initialize($config);

    $titleStore = get_lebel_by_value_in_settings('store_name');
    $form = get_lebel_by_value_in_settings('mail_address');

    $email->setFrom($form, $titleStore);
    $reply = !empty($replyEmail)?$replyEmail:$form;
    $email->setReplyTo($reply,$title);
    $email->setTo($to);

    $email->setSubject($subject);
    $email->setMessage($message);

    if ($email->send()) {
        //echo 'Email successfully sent';
        $result = true;
    } else {
        $email->printDebugger(['headers']);
        $result = false;
    }

    return $result;
}

/**
 * @description This function provides currency symbol
 * @param string|int $amount
 * @return string
 */
function currency_symbol($amount)
{
    $symbol = get_lebel_by_value_in_settings('currency_symbol');
    $cur = !empty($amount) ? $amount : 0;
    $split = explode('.', $cur);
    $flot = empty($split[1]) ? '00' : $split[1];
    $result = $symbol . '' . $split[0] . '<sup>' . $flot . '</sup>';

    return $result;
}

/**
 * @description This function provides order email template
 * @param int $orderId
 * @return string
 */
function order_email_template($orderId)
{
    $table = DB()->table('cc_order');
    $val = $table->where('order_id', $orderId)->get()->getRow();

    $tableItem = DB()->table('cc_order_item');
    $item = $tableItem->where('order_id', $orderId)->get()->getResult();
    $logoImg = get_lebel_by_value_in_theme_settings('side_logo')->value;
    $logo = image_view('uploads/logo', '', $logoImg, 'noimage.png', 'logo-css');

    $titleStore = get_lebel_by_value_in_settings('store_name');

    $paymentMet = get_data_by_id('name','cc_payment_method','payment_method_id',$val->payment_method);
    $state = get_data_by_id('name', 'cc_zone', 'zone_id', $val->shipping_city);
    $country = get_data_by_id('name', 'cc_country', 'country_id', $val->shipping_country_id);
    $view = '';
    $view .= "<div style='width:680px'><style> .logo-css{ margin-bottom:20px;border:none; } </style>
    <a href='#' title='$titleStore' target='_blank' >
        $logo
    </a>
    <p style='margin-top:0px;margin-bottom:20px'>
        Thank you for your interest in        
        <span class='il'> $titleStore </span> products. Your
        <span class='il'>order</span>
        has been received and will be processed once payment has been confirmed.
    </p>
    
    <table style='border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;margin-bottom:20px'>
        <thead>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222'
                colspan='2'><span class='il'>Order</span> Details
            </td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                <b><span class='il'>Order</span> ID:</b> $val->order_id<br>
                <b>Date Added:</b> $val->createdDtm<br>
                <b>Payment Method:</b> $paymentMet<br>
                <b>Shipping Method:</b> $val->shipping_method
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                <b>Name:</b> $val->payment_firstname $val->payment_lastname<br>
                <b>Email:</b> <a href='mailto:$val->payment_email' target='_blank'>$val->payment_email</a><br>
                <b>Telephone:</b> $val->payment_phone<br>
            </td>
        </tr>
        </tbody>
    </table>

    <table style='border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;margin-bottom:20px'>
        <thead>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222'>
                Payment Address
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222'>
                Shipping Address
            </td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                $val->payment_address_1, $val->shipping_postcode, $state, $country
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                $val->shipping_address_1, $val->shipping_postcode, $state, $country
            </td>
        </tr>
        </tbody>
    </table>";

    $view .= "<table style='border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;margin-bottom:20px'>
        <thead>
        <tr>
            <td style='border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222'>
                Image
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222'>
                Product
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222'>
                Model
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222'>
                Quantity
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222'>
                Price
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222'>
                Total
            </td>
        </tr>
        </thead>
        <tbody>";

    foreach ($item as $row) {
        $proName = get_data_by_id('name', 'cc_products', 'product_id', $row->product_id);
        $model = get_data_by_id('model', 'cc_products', 'product_id', $row->product_id);
        $image = get_data_by_id('image', 'cc_products', 'product_id', $row->product_id);
        $imgView = '<img data-sizes="auto"  id="" src="'.product_image_view('uploads/products', $row->product_id, $image, 'noimage.png',  '100', '100').'" >';
        $url = base_url('detail/' . $row->product_id);
        $price = currency_symbol($row->total_price);
        $total = currency_symbol($row->final_price);
        $view .= "<tr>
            <td style='border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
            <a href='$url' target='_blank' title='".$proName."' style='padding:1px;border:1px solid #dddddd' >
                    $imgView
            </a>
            </td>

            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                <a href='$url' target='_blank'>$proName</a>
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                $model
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>
                $row->quantity
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>
                $price
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>
                $total
            </td>
        </tr>";
    }

    $subTo = currency_symbol($val->total);
    $shipping_charge = currency_symbol($val->shipping_charge);
    $discount = currency_symbol($val->discount);
    $final_amount = currency_symbol($val->final_amount);
    $view .= "</tbody>
        <tfoot>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'
                colspan='5'><b>Sub-Total:</b></td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>
                $subTo
            </td>
        </tr>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'
                colspan='5'><b>Shipping Charge:</b></td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>
                $shipping_charge
            </td>
        </tr>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'
                colspan='5'><b>Discount:</b></td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>
                $discount
            </td>
        </tr>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'
                colspan='5'><b>Total:</b></td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>
                $final_amount
            </td>
        </tr>
        </tfoot>
    </table>
</div>";

    return $view;
}

/**
 * @description This function provides order email template card
 * @param int $orderId
 * @return string
 */
function order_email_template_card($orderId)
{
    $table = DB()->table('cc_order');
    $val = $table->where('order_id', $orderId)->get()->getRow();

    $tableItem = DB()->table('cc_order_card_details');
    $cardDetail = $tableItem->where('order_id', $orderId)->get()->getRow();

    $logoImg = get_lebel_by_value_in_theme_settings('side_logo')->value;
    $logo = image_view('uploads/logo', '', $logoImg, 'noimage.png', 'logo-css');

    $titleStore = get_lebel_by_value_in_settings('store_name');

    $paymentMet = get_data_by_id('name','cc_payment_method','payment_method_id',$val->payment_method);

    $view = '';
    $view .= "<div style='width:680px'><style> .logo-css{ margin-bottom:20px;border:none; } </style>
    <a href='#' title='$titleStore' target='_blank' >
        $logo
    </a>
    <p style='margin-top:0px;margin-bottom:20px'>
        Thank you for your interest in        
        <span class='il'> $titleStore </span> products. Your
        <span class='il'>order</span>
        has been received and will be processed once payment has been confirmed.
    </p>
    
    <table style='border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;margin-bottom:20px'>
        <thead>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222'
                colspan='2'><span class='il'>Order</span> Details
            </td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                <b><span class='il'>Order</span> ID:</b> $val->order_id<br>
                <b>Date Added:</b> $val->createdDtm<br>
                <b>Payment Method:</b> $paymentMet<br>
                <b>Shipping Method:</b> $val->shipping_method
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                <b>Email:</b> <a href='mailto:$val->payment_email' target='_blank'>$val->payment_email</a><br>
                <b>Telephone:</b> $val->payment_phone<br>
            </td>
        </tr>
        </tbody>
    </table>

    <table style='border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;margin-bottom:20px'>
        <thead>
        <tr>
            <td colspan='2' style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222'>
                Credit Card / Debit Card Details
            </td>
            
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                Card Name:
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                ".$cardDetail->card_name."
            </td>
        </tr>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                Card Number:
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                ".$cardDetail->card_number."
            </td>
        </tr>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                Expiration:
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                ".$cardDetail->card_expiration."
            </td>
        </tr>
        <tr>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                CVC:
            </td>
            <td style='font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>
                ".$cardDetail->card_cvc."
            </td>
        </tr>
        </tbody>
    </table>

    
</div>";

    return $view;
}

/**
 * @description This function provides success email template
 * @param string $title
 * @param string $message
 * @param string $url
 * @return string
 */
function success_email_template($title, $message, $url)
{
    $address = get_lebel_by_value_in_settings('address');
    $logoImg = get_lebel_by_value_in_theme_settings('side_logo')->value;
    $logo = image_view('uploads/logo', '', $logoImg, 'noimage.png', 'logo-css');
    $titleStore = get_lebel_by_value_in_settings('store_name');

    $insUrl = get_lebel_by_value_in_settings('instagram_url');
    $telUrl = get_lebel_by_value_in_settings('telegram_url');
    $pinUrl = get_lebel_by_value_in_settings('pinterest_url');

    $ins = '<img src="'.base_url("icon/instagram.png").'" width="30" height="30" alt="Instagram" >';
    $tel = '<img src="'.base_url("icon/telegram.png").'" width="30" height="30" alt="Telegram" >';
    $pin = '<img src="'.base_url("icon/pinterest.png").'" width="30" height="30" alt="Pinterest" >';
    $view = '';
    $view .= "<div style='width:680px'>
            <style> .logo-css{ margin-top:20px;border:none; } </style>
    <div style='width:100%;text-align: center;'>        
        $logo
        <h1 style='color:#000000; '>Welcome!</h1>
        <center><p style='background-color: #ffffff;color:#000000;width: 300px;font-size: 20px;padding: 5px; '>
        $title
        </p></center>
    </div>

    <div style='width:100%;'>
        <div style='padding:20px;'>
            <p style='margin-bottom: 30px;'>
                $message
            </p>
            <center><a href='$url' target='_blank' style='background-color: #000000;border: none;padding: 10px 18px;color: #ffffff;font-size:18px;text-decoration: none;width:100%' >Visit</a></center>
            <hr style='margin-top: 30px;margin-bottom: 30px;border: 2px solid #d5d5d5;'>
            <center> <a href='$insUrl' target='_blank'>$ins</a> <a href='$telUrl' target='_blank'>$tel</a> <a href='$pinUrl' target='_blank'>$pin</a></center>
            <center> <p>$address</p></center>
            <center><hr style='width:300px;'></center>
            <center> <p>© 2015 $titleStore || All rights reserved.</p></center>
        </div>

    </div>

</div>";

    return $view;
}

/**
 * @description This function provides order id by status
 * @param int $order_id
 * @return false|null
 */
function order_id_by_status($order_id)
{
    $table = DB()->table('cc_order_history');
    $order = $table->where('order_id', $order_id)->get()->getLastRow();

    $status = get_data_by_id('name', 'cc_order_status', 'order_status_id', $order->order_status_id);

    return $status;
}

/**
 * @description This function provides get side menu array
 * @return array
 */
function getSideMenuArray()
{
    $table = DB()->table('cc_product_category');
    $query = $table->where('side_menu', 1)->where('status','1')->orderBy('sort_order', 'ASC')->get()->getResult();
    return $query;
}

/**
 * @description This function provides add to cart btn
 * @param int $product_id
 * @return string
 */
function addToCartBtn($product_id)
{
    $qtyCheck = get_data_by_id('quantity', 'cc_products', 'product_id', $product_id);
    $optionCheck = is_exists('cc_product_option', 'product_id', $product_id);
    $btn = '';
    if (!empty($qtyCheck)) {
        if ($optionCheck == true) {
            $btn = '<button type="button" onclick="addToCart(' . $product_id . ')" class="border-0 btn btn-cart w-100 rounded-0 mt-auto">Add to Cart</button>';
        } else {
            $url = base_url('detail/' . $product_id);
            $btn = '<a href="' . $url . '"  class="btn btn-cart w-100 rounded-0 mt-auto">Add to Cart</a>';
        }
    } else {
        $btn = '<button type="button"  class="border-0 btn btn-cart w-100 rounded-0 mt-auto">Out of Stock</button>';
    }
    return $btn;
}

/**
 * @description This function provides add to cart btn icon
 * @param int $product_id
 * @return string
 */
function addToCartBtnIcon($product_id)
{
    $qtyCheck = get_data_by_id('quantity', 'cc_products', 'product_id', $product_id);
    $optionCheck = is_exists('cc_product_option', 'product_id', $product_id);
    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none"><path d="M14.55 11C15.3 11 15.96 10.59 16.3 9.97L19.88 3.48C19.9643 3.32843 20.0075 3.15747 20.0054 2.98406C20.0034 2.81064 19.956 2.64077 19.8681 2.49126C19.7803 2.34175 19.6549 2.21778 19.5043 2.13162C19.3538 2.04545 19.1834 2.00009 19.01 2H4.21L3.27 0H0V2H2L5.6 9.59L4.25 12.03C3.52 13.37 4.48 15 6 15H18V13H6L7.1 11H14.55ZM5.16 4H17.31L14.55 9H7.53L5.16 4ZM6 16C4.9 16 4.01 16.9 4.01 18C4.01 19.1 4.9 20 6 20C7.1 20 8 19.1 8 18C8 16.9 7.1 16 6 16ZM16 16C14.9 16 14.01 16.9 14.01 18C14.01 19.1 14.9 20 16 20C17.1 20 18 19.1 18 18C18 16.9 17.1 16 16 16Z" fill="white"/></svg>';
    $btn = '';
    if (!empty($qtyCheck)) {
        if ($optionCheck == true) {
            $btn = '<a href="javascript:void(0)" onclick="addToCart(' . $product_id . ')" class="btn btn-cart bg-custom-color text-white rounded-0 mt-3">' . $icon . '</a>';
        } else {
            $url = base_url('detail/' . $product_id);
            $btn = '<a href="' . $url . '"  class="btn btn-cart bg-custom-color text-white rounded-0 mt-3">' . $icon . '</a>';
        }
    } else {
        $btn = '<a href="javascript:void(0)"  class="btn btn-cart bg-black text-white rounded-0 mt-3">' . $icon . '</a>';
    }
    return $btn;
}

/**
 * @description This function provides option id or product id by option value
 * @param int $option_id
 * @param int $product_id
 * @return array
 */
function option_id_or_product_id_by_option_value($option_id, $product_id)
{
    $table = DB()->table('cc_product_option');
    $data = $table->where('option_id', $option_id)->where('product_id', $product_id)->get()->getResult();
    return $data;
}

/**
 * @description This function provides order item id by order options
 * @param int $order_item_id
 * @return array
 */
function order_iten_id_by_order_options($order_item_id)
{
    $table = DB()->table('cc_order_option');
    $data = $table->where('order_item_id', $order_item_id)->get()->getResult();
    return $data;
}

/**
 * @description This function provides get all row data by id
 * @param string $table
 * @param string|int $whereCol
 * @param string|int $whereInfo
 * @return array|mixed|object|stdClass|null
 */
function get_all_row_data_by_id($table, $whereCol, $whereInfo)
{
    $db = \Config\Database::connect();
    $tabledta = $db->table($table);
    $result = $tabledta->where($whereCol, $whereInfo)->get()->getRow();
    return $result;
}

/**
 * @description This function provides get model settings value by modelId o label
 * @param string|int $modelId
 * @param string $label
 * @return int
 */
function get_model_settings_value_by_modelId_or_label($modelId, $label)
{
    $table = DB()->table('cc_module_settings');
    $row = $table->where('module_id', $modelId)->where('label', $label)->get()->getRow();
    $data = 0;
    if (!empty($row)) {
        $data = $row->value;
    }
    return $data;
}

/**
 * @description This function provides paypal settings
 * @return array
 */
function paypal_settings()
{
    $rowApi = get_all_row_data_by_id('cc_payment_settings', 'label', 'api_url');
    $api_username = get_all_row_data_by_id('cc_payment_settings', 'label', 'api_username');
    $api_password = get_all_row_data_by_id('cc_payment_settings', 'label', 'api_password');
    $api_signature = get_all_row_data_by_id('cc_payment_settings', 'label', 'api_signature');
    $url_ex = ($rowApi->value == 'sandbox') ? 'sandbox.' : '';

    $settings = array(
        'api_username' => $api_username->value,
        'api_password' => $api_password->value,
        'api_signature' => $api_signature->value,
        'api_endpoint' => 'https://api-3t.' . $url_ex . 'paypal.com/nvp',
        'api_url' => 'https://www.' . $url_ex . 'paypal.com/webscr&cmd=_express-checkout&token=',
        'api_version' => '65.1',
        'payment_type' => 'Sale',
        'currency' => 'USD',
    );

    return $settings;
}

/**
 * @description This function provides get category id by product show home slide
 * @param int $category_id
 * @return string
 */
//this function only in used Theme 3
function get_category_id_by_product_show_home_slide($category_id)
{
    $table = DB()->table('cc_products');
    $table->join('cc_product_to_category', 'cc_product_to_category.product_id = cc_products.product_id')->where('cc_products.status', 'Active')->where('cc_products.featured', '1');
    $result = $table->where('cc_product_to_category.category_id', $category_id)->orderBy('cc_products.product_id','DESC')->limit(20)->get()->getResult();

    return  sectionProductViewByProductArray($result);
}

function getProductByScheduleIdShowHomeSlider($scheduleId){
//    $builder = DB()->table('cc_products p')
//        ->select('p.*, fp.featured_product_id, ptc.category_id')
//        ->join('cc_product_to_category ptc', 'ptc.product_id = p.product_id', 'left')
//        ->join('cc_featured_product fp',
//            '(fp.product_id = p.product_id
//                    OR fp.brand_id = p.brand_id
//                    OR fp.prod_cat_id = ptc.category_id)',
//            'left'
//        )
//        ->where('p.status', 'Active')
//        ->where('p.featured', '1')
//        ->where('fp.featured_schedule_id', $scheduleId)
//        ->groupBy('p.product_id')
//        ->orderBy('p.product_id', 'DESC')
//        ->limit(20);
//
//    $result = $builder->get()->getResult();


    $db = DB();
    $featured = $db->table('cc_featured_product')
        ->where('featured_schedule_id', $scheduleId)
        ->get()
        ->getResult();

    $result = [];

    // No row found
    if (empty($featured)) {
        return sectionProductViewByProductArray([]);
    }

    // Detect type from first row
    $type = null;
    $first = $featured[0];

    if (!empty($first->product_id)) {
        $type = 'product';
    } elseif (!empty($first->brand_id)) {
        $type = 'brand';
    } elseif (!empty($first->prod_cat_id)) {
        $type = 'category';
    }

    // Handle by type
    if ($type === 'product') {

        foreach ($featured as $item) {
            $product = $db->table('cc_products')
                ->where('product_id', $item->product_id)
                ->where('status', 'Active')
                ->where('featured', '1')
                ->get()
                ->getRow();

            if ($product) {
                $result[] = $product;
            }
        }

    } elseif ($type === 'brand') {

        foreach ($featured as $item) {
            $product = $db->table('cc_products')
                ->where('brand_id', $item->brand_id)
                ->where('status', 'Active')
                ->where('featured', '1')
                ->get()
                ->getRow();

            if ($product) {
                $result[] = $product;
            }
        }

    } elseif ($type === 'category') {

        foreach ($featured as $item) {
            $product = $db->table('cc_products p')
                ->join('cc_product_to_category ptc', 'ptc.product_id = p.product_id')
                ->where('ptc.category_id', $item->prod_cat_id)
                ->where('p.status', 'Active')
                ->where('p.featured', '1')
                ->get()
                ->getRow();

            if ($product) {
                $result[] = $product;
            }
        }

    }

    return  sectionProductViewByProductArray($result);
}

function sectionProductViewByProductArray($product){
    $modules = modules_access();
    $view = '';
    $count = 0;
    foreach ($product as $pro) {
        if ($count % 2 == 0) $view .= '<div class="swiper-slide">' . "\n";
        $view .= '<div class="border p-3 product-grid h-100 d-flex align-items-stretch flex-column position-relative">
            <div class="product-grid position-relative">';
        if ($modules['wishlist'] == 1) {
            if (!isset(newSession()->isLoggedInCustomer)) {
                $view .= '<a href="' . base_url('login') . '" class="btn-wishlist position-absolute mt-2 ms-2"  ><i class="fa-solid fa-heart"></i>
                    <span class="btn-wishlist-text position-absolute  mt-5 ms-2">Favorite</span>
                    </a>';
            } else {
                $view .= '<button type="button" class="border-0 btn-wishlist position-absolute mt-2 ms-2" onclick="addToWishlist(' . $pro->product_id . ')"><i class="fa-solid fa-heart"></i>
                    <span class="btn-wishlist-text position-absolute  mt-5 ms-2">Favorite</span>
                    </button>';
            }

        }

        if ($modules['compare'] == 1) {
            $view .= '<button type="button" onclick="addToCompare(' . $pro->product_id . ')" class="border-0 btn-compare position-absolute  mt-5 ms-2"><i class="fa-solid fa-code-compare"></i>
                    <span class="btn-compare-text position-absolute  mt-5 ms-2">Compare</span>
                </button>';
        }

        $view .= '<div class="product-top mb-2">
                <img data-sizes="auto" src="' . product_image_view('uploads/products', $pro->product_id, $pro->image, 'noimage.png', '132', '132') . '" alt="'.$pro->alt_name.'" class="img-fluid w-100" loading="lazy">                 
                </div>
                <div class="product-bottom mt-auto">
                    <div class="product-title product_title_area mb-2">
                        <a href="' . base_url('detail/' . $pro->product_id) . '">' . substr($pro->name, 0, 40) . '</a>
                    </div>
                    <div class="price mb-2">' . currency_symbol($pro->price) . '</div>';

        $view .= addToCartBtn($pro->product_id);
        $view .= '</div>                                            
            </div>  ';
        $view .= '</div>' . "\n";

        if ($count % 2 != 0) $view .= '</div>';

        $count++;
    }

    if ($count % 2 != 0) {
        $view .= '</div>';
    }
    return $view;
}

/**
 * @description This function provides get category name by id
 * @param int $cate_id
 * @return mixed
 */
function get_category_name_by_id($cate_id){
    $table = DB()->table('cc_product_category');
    $cat = $table->where('prod_cat_id', $cate_id)->get()->getRow();
    return $cat->category_name;
}

/**
 * @description This function provides category parent count
 * @param int $cate_id
 * @return int|void|null
 */
function category_parent_count($cate_id){
    $table = DB()->table('cc_product_category');
    $cat = $table->where('prod_cat_id', $cate_id)->get()->getRow();
    if ($cat->parent_id) {
        return category_parent_count($cat->parent_id) + 1;
    }
}

/**
 * @description This function provides display category with parent
 * @param int $cate_id
 * @return void
 */
function display_category_with_parent($cate_id)
{
    $catName = array();
    if (!empty($cate_id)) {
        $totalParent = category_parent_count($cate_id);
        for ($i=0; $i<=$totalParent; $i++) {
            $catName[] = get_category_name_by_id($cate_id);
            $table = DB()->table('cc_product_category');
            $cat = $table->where('prod_cat_id', $cate_id)->get()->getRow();
            $cate_id = $cat->parent_id;
        }
    }

    krsort($catName);

    foreach ($catName as $key => $val){
        if ($key == 0) {
            print $val;
        }else {
            print $val." > ";
        }
    }


}

/**
 * @description This function provides zone rate type
 * @return string[]
 */
function zone_rate_type(){
    $status = [
        '1' => 'Weight',
        '2' => 'Item',
        '3' => 'Price',
    ];
    return $status;
}

/**
 * @description This function provides get theme settings
 * @return array
 */
function get_theme_settings(){

    $settings = get_settings();
    $theme = $settings['Theme'];
    $table = DB()->table('cc_theme_settings');
    $data = $table->where('theme', $theme)->get()->getResult();
    $settings = array();
    foreach ($data as $key => $val){
        foreach($val as $k=>$v) {
            if ($k == 'label') {
                $settings[$v] = ['value' => $data[$key]->value,'alt_name' => $data[$key]->alt_name];
            }
        }
    }
    return $settings;
}

/**
 * @description This function provides get theme title settings
 * @return array
 */
function get_theme_title_settings(){

    $settings = get_settings();
    $theme = $settings['Theme'];
    $table = DB()->table('cc_theme_settings');
    $data = $table->where('theme', $theme)->get()->getResult();
    $settings = array();
    foreach ($data as $key => $val){
        foreach($val as $k=>$v) {
            if ($k == 'label') {
                $settings[$v] = $data[$key]->title;
            }
        }
    }
    return $settings;
}

/**
 * @description This function provides currency symbol with symbol
 * @param string $amount
 * @param string $symbol
 * @return string
 */
function currency_symbol_with_symbol($amount,$symbol) {
    $cur = !empty($amount) ? number_format($amount,2) : 0;
    $split = explode('.', $cur);
    $flot = empty($split[1]) ? '00' : $split[1];
    $result = $symbol . '' . $split[0] . '<sup>' . $flot . '</sup>';

    return $result;
}

/**
 * @description This function provides modules access
 * @return array
 */
function modules_access()
{
    $table = DB()->table('cc_modules');
    $data = $table->get()->getResult();
    $settings = array();
    foreach ($data as $key => $val){
        foreach($val as $k=>$v) {
            if ($k == 'module_key') {
                $settings[$v] = $data[$key]->status;
            }
        }
    }
    return $settings;
}

/**
 * @description This function provides get settings title
 * @return array
 */
function get_settings_title(){
    $table = DB()->table('cc_settings');
    $data = $table->get()->getResult();

    $settings = array();
    foreach ($data as $key=>$val){
        foreach($val as $k=>$v) {
            if ($k == 'label'){
                $settings[$v] = $data[$key]->title;
            }
        }
    }
    return $settings;
}

/**
 * @description This function provides product count by brand id
 * @param int $brand_id
 * @param array $products
 * @return int
 */
function product_count_by_brand_id($brand_id,$products){
    $count = 0;
    foreach ($products as $v){
        if($v->brand_id == $brand_id){
            $count++;
        }
    }
    return $count;
}

/**
 * @description This function provides display category parent with parent
 * @param int $album_id
 * @return void
 */
function display_category_parent_with_parent($album_id)
{
    $albumName = array();
    if (!empty($album_id)) {
        $totalParent = album_category_parent_count($album_id);
        for ($i=0; $i<=$totalParent; $i++) {
            $albumName[] = get_album_name_by_id($album_id);
            $table = DB()->table('cc_album');
            $cat = $table->where('album_id', $album_id)->get()->getRow();
            $album_id = $cat->parent_album_id;
        }
    }

    krsort($albumName);

    foreach ($albumName as $key => $val){
        if ($key == 0) {
            print $val;
        }else {
            print $val." > ";
        }
    }

}

function album_category_parent_count($album_id){
    $table = DB()->table('cc_album');
    $album = $table->where('album_id', $album_id)->get()->getRow();
    if ($album->parent_album_id) {
        return album_category_parent_count($album->parent_album_id) + 1;
    }
}

function get_album_name_by_id($album_id){
    $table = DB()->table('cc_album');
    $album = $table->where('album_id', $album_id)->get()->getRow();
    return $album->name;
}

function parent_qc_picture(){
    $table = DB()->table('cc_album');
    $album = $table->where('parent_album_id', '0')->orderBy('name','ASC')->get()->getResult();
    return $album;
}

function common_image_view($url, $slug, $image, $no_image, $width = '', $height = '')
{

    $imgMain = str_replace("pro_", "", $image);

    $dir = FCPATH . '/' . $url . '/' . $slug;

    $imageNo = explode('.', $no_image);
    $pathNewNo = 'cache/'.$url . '/' .$width.'x'.$height.'_'.$imageNo[0].'.webp';
    if(file_exists($pathNewNo)){
        $no_img = base_url($pathNewNo);
    }else{
        $urlNewNo = base64_encode($url . '/');
        $no_img = base_url('image-resize/' . $urlNewNo . '/' . $width . 'x' . $height . '/' . $no_image);
    }

    if (!empty($image)) {
        if (!file_exists($dir)) {
            $result = $no_img;
        } else {
            $imgPath = $dir . '/' . $imgMain;

            if (file_exists($imgPath)) {
                $image = explode('.', $imgMain);
                $pathNew = 'cache/'.$url . '/' . $slug . '/'.$width.'x'.$height.'_'.$image[0].'.webp';
                if(file_exists($pathNew)){
                    $imgFinal = base_url($pathNew);
                }else{
                    $urlNew = base64_encode($url . '/' . $slug . '/');
                    $imgFinal = base_url('image-resize/' . $urlNew . '/' . $width . 'x' . $height . '/' . $imgMain);
                }

                $result = $imgFinal;
            } else {
                $result = $no_img;
            }
        }
    } else {
        $result = $no_img;
    }

    return $result;
}
function product_image_view($url, $slug, $image, $no_image, $width = '', $height = '')
{
    $modules = modules_access();
    $im  = str_replace("pro_", "", $image);
    $imgMain = ($modules['watermark'] == '1')?'600_wm_'.$im:$im;

    $dir = FCPATH . '/' . $url . '/' . $slug;

    $imageNo = explode('.', $no_image);
    $pathNewNo = 'cache/'.$url . '/' .$width.'x'.$height.'_'.$imageNo[0].'.webp';
    if(file_exists($pathNewNo)){
        $no_img = base_url($pathNewNo);
    }else{
        $urlNewNo = base64_encode($url . '/');
        $no_img = base_url('image-resize/' . $urlNewNo . '/' . $width . 'x' . $height . '/' . $no_image);
    }

    if (!empty($image)) {
        if (!file_exists($dir)) {
            $result = $no_img;
        } else {
            $imgPath = $dir . '/' . $imgMain;

            if (file_exists($imgPath)) {
                $image = explode('.', $imgMain);
                $pathNew = 'cache/'.$url . '/' . $slug . '/'.$width.'x'.$height.'_'.$image[0].'.webp';
                if(file_exists($pathNew)){
                    $imgFinal = base_url($pathNew);
                }else{
                    $urlNew = base64_encode($url . '/' . $slug . '/');
                    $imgFinal = base_url('image-resize/' . $urlNew . '/' . $width . 'x' . $height . '/' . $imgMain);
                }
                $result   = $imgFinal;
            } else {
                $result = $no_img;
            }
        }
    } else {
        $result = $no_img;
    }

    return $result;
}
function product_multi_image_view($url, $slug, $slug2, $image, $no_image, $width = '', $height = '')
{
    $modules = modules_access();
    $im  = str_replace("pro_", "", $image);
    $imgMain = ($modules['watermark'] == '1')?'600_wm_'.$im:$im;

    $dir = FCPATH . '/' . $url . '/' . $slug . '/' . $slug2;



    $imageNo = explode('.', $no_image);
    $pathNewNo = 'cache/'.$url . '/' .$width.'x'.$height.'_'.$imageNo[0].'.webp';
    if(file_exists($pathNewNo)){
        $no_img = base_url($pathNewNo);
    }else{
        $urlNewNo = base64_encode($url . '/');
        $no_img = base_url('image-resize/' . $urlNewNo . '/' . $width . 'x' . $height . '/' . $no_image);
    }

    if (!empty($image)) {
        if (!file_exists($dir)) {
            $result = $no_img;
        } else {
            $imgPath = $dir . '/' . $imgMain;

            if (file_exists($imgPath)) {
                $image = explode('.', $imgMain);
                $pathNew = 'cache/'.$url . '/' . $slug . '/'. $slug2 . '/'.$width.'x'.$height.'_'.$image[0].'.webp';
                if(file_exists($pathNew)){
                    $imgFinal = base_url($pathNew);
                }else{
                    $urlNew = base64_encode($url . '/' . $slug . '/'. $slug2 . '/');
                    $imgFinal = base_url('image-resize/' . $urlNew . '/' . $width . 'x' . $height . '/' . $imgMain);
                }
                $result   = $imgFinal;
            } else {
                $result = $no_img;
            }
        }
    } else {
        $result = $no_img;
    }

    return $result;
}
function image_cache($path, $imageName, $width, $height)
{
    $imageUrl = $path . $imageName;
    $cache    = Services::cache(); // Get cache service
    $cacheKey = 'image_' . md5($imageName . $width . $height); // Unique key for the image

    // Check if image is already cached
    $imagePath = $cache->get($cacheKey);
    $seconds   = 30 * 24 * 60 * 60;

    if (!$imagePath) {
        // Image is not in cache, so generate it
        $imagePath = WRITEPATH . 'cache/generated_image_' . md5(time()) . '.jpg'; // Cache path

        // Load the image library
        $img = \Config\Services::image();

        // Create a simple image (e.g., image with text)
        $img->withFile($imageUrl)
            ->fit($width, $height, 'center')
            ->save($imagePath);

        // Save the image path to the cache
        $cache->save($cacheKey, file_get_contents($imagePath), $seconds); // $seconds Cache for 1 day (86400 seconds) 1 hour (3600 seconds) 30 day (2592000 seconds)
        unlink($imagePath);
    }

    // Serve the image
//    return $this->response->setHeader('Content-Type', 'image/png')->setBody($cache->get($cacheKey));

    $base64Image = base64_encode($cache->get($cacheKey));

    return 'data:image/png;base64,' . $base64Image;
}

/**
 * @description This function provides display blog category with parent.
 * @param int $cate_id
 * @return void
 */
function display_blog_category_with_parent($cate_id)
{
    $catName = [];

    if (!empty($cate_id)) {
        $totalParent = blog_category_parent_count($cate_id);

        for ($i = 0; $i <= $totalParent; $i++) {
            $catName[] = get_blog_category_name_by_id($cate_id);
            $table     = DB()->table('cc_category');
            $cat       = $table->where('cat_id', $cate_id)->get()->getRow();
            $cate_id   = $cat->parent_id;
        }
    }

    krsort($catName);

    foreach ($catName as $key => $val) {
        if ($key == 0) {
            print $val;
        } else {
            print $val . " > ";
        }
    }
}

/**
 * @description This function provides blog category parent count.
 * @param int $cate_id
 * @return int|void|null
 */
function blog_category_parent_count($cate_id)
{
    $table = DB()->table('cc_category');
    $cat   = $table->where('cat_id', $cate_id)->get()->getRow();

    if ($cat->parent_id) {
        return blog_category_parent_count($cat->parent_id) + 1;
    }
}

/**
 * @description This function provides get blog category name by id.
 * @param int $cate_id
 * @return mixed
 */
function get_blog_category_name_by_id($cate_id)
{
    $table = DB()->table('cc_category');
    $cat   = $table->where('cat_id', $cate_id)->get()->getRow();

    return $cat->category_name;
}

/**
 * @description This function provides count comment by blog_id.
 * @param int $blog_id
 * @return int|string
 */
function count_comment_by_blog_id($blog_id){
    $table = DB()->table('cc_blog_comments');
    return $table->where('blog_id', $blog_id)->countAllResults();
}

/**
 * @description This function provides comment id by reply comment.
 * @param int $comment_id
 * @return array
 */
function comment_id_by_reply_comment($comment_id){
    $table = DB()->table('cc_blog_comments');
    return $table->where('	comment_parent_id', $comment_id)->get()->getResult();
}

function idByShowPermission($parentId){
    $table = DB()->table('cc_album');
    $albums = $table->get()->getResult();

    $map = [];
    foreach ($albums as $album) {
        $map[$album->parent_album_id][] = $album;
    }
    $allAlbumIDs = getDescendantAlbumIds($parentId, $map);

    if (empty($allAlbumIDs)) {
        $allAlbumIDs = [$parentId];
    }

    return albumAvailableCheckByAlbumID($allAlbumIDs);
}

function getDescendantAlbumIds($parentId, $map) {
    $result = [];

    if (!isset($map[$parentId])) {
        return $result;
    }

    foreach ($map[$parentId] as $childAlbum) {
        $result[] = $childAlbum->album_id;
        $result = array_merge($result, getDescendantAlbumIds($childAlbum->album_id, $map));
    }

    return $result;
}

function albumAvailableCheckByAlbumID($allAlbumID){
    return DB()->table('cc_album_details')->whereIn('album_id',$allAlbumID)->countAllResults();
}

function getScheduleBySectionId($schedule,$sectionId)
{
    foreach ($schedule as $row) {
        if ($row->featured_section_id == $sectionId) {
            return $row;
        }
    }
    return null;
}
function scheduleLogo(){
    $now = date('Y-m-d H:i:s');
    return DB()->table('cc_logo_schedule')
        ->where('start_date <=',$now)
        ->where('end_date >=',$now)
        ->orderBy('start_date', 'ASC')
        ->get()
        ->getRow();
}