<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateThemeColumnInThemeSettingsTable extends Migration
{
    public function up()
    {
        $fields = [
            'theme' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'default' => null,
                'after' => 'value'
            ],
        ];
        $this->forge->addColumn('cc_theme_settings', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('cc_theme_settings', 'theme');
    }
}
