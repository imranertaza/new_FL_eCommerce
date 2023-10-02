<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ThemeSettingsFT3 extends Seeder
{
    public function run()
    {
        $data = [
            [
                'theme_settings_id' => '19',
                'label' => 'head_side_baner_1',
                'title' => 'Side Banner ',
                'value' => 'head_side_baner_1696138195_c4f0352c5232d3336f62.jpg',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '20',
                'label' => 'head_side_baner_2',
                'title' => 'Side Banner',
                'value' => 'head_side_baner_1696138199_672fc6ed1837d41e9e56.jpg',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '21',
                'label' => 'head_side_category_1',
                'title' => 'Side Category',
                'value' => '24',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '22',
                'label' => 'head_side_category_2',
                'title' => 'Side Category',
                'value' => '1',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '23',
                'label' => 'head_side_title_1',
                'title' => 'Side Title',
                'value' => 'Mans Fashion',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '24',
                'label' => 'head_side_title_2',
                'title' => 'Side Title',
                'value' => 'Woman Fashion',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '25',
                'label' => 'home_category_1',
                'title' => 'Home Category',
                'value' => '24',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '26',
                'label' => 'home_category_baner_1',
                'title' => 'Category Banner',
                'value' => 'home_category_1696138213_8dd42dc39de719d5d4bc.jpg',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '27',
                'label' => 'home_category_title_1',
                'title' => 'Category title',
                'value' => 'Apparels',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '28',
                'label' => 'home_category_2',
                'title' => 'Home Category',
                'value' => '50',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '29',
                'label' => 'home_category_baner_2',
                'title' => 'Category Banner',
                'value' => 'home_category_1696138225_357430eef07c3c384322.jpg',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '30',
                'label' => 'home_category_title_2',
                'title' => 'Category title',
                'value' => 'Treasures',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '31',
                'label' => 'home_category_3',
                'title' => 'Home Category',
                'value' => '2',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '32',
                'label' => 'home_category_baner_3',
                'title' => 'Category Banner',
                'value' => 'home_category_1696138235_9df6785b410bdac5b3ec.jpg',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '33',
                'label' => 'home_category_title_3',
                'title' => 'Category title',
                'value' => 'Bag',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '34',
                'label' => 'home_category_4',
                'title' => 'Home Category',
                'value' => '11',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '35',
                'label' => 'home_category_baner_4',
                'title' => 'Category Banner',
                'value' => 'home_category_1696138248_b78ac38e00434b86d187.jpg',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '36',
                'label' => 'home_category_title_4',
                'title' => 'Category title',
                'value' => 'Jewelry',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '37',
                'label' => 'home_category_5',
                'title' => 'Category',
                'value' => '37',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '38',
                'label' => 'home_category_baner_5',
                'title' => 'Category Banner',
                'value' => 'home_category_1696138255_05bc6203d368950ddba5.jpg',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '39',
                'label' => 'home_category_title_5',
                'title' => 'Category title',
                'value' => 'Shoes',
                'theme' => 'Theme_3',
            ],
            [
                'theme_settings_id' => '40',
                'label' => 'banner_bottom',
                'title' => 'Banner Bottom',
                'value' => 'banner_bottom_1696138263_690247f533caa5a3f0d8.jpg',
                'theme' => 'Theme_3',
            ],
        ];
        // Using Query Builder
        $this->db->table('cc_theme_settings')->insertBatch($data);
    }
}
