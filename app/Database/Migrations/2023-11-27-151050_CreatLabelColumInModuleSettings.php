<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatLabelColumInModuleSettings extends Migration
{
    public function up()
    {
        $fields = [
            'label' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'default' => null,
                'after' => 'module_id'
            ],
        ];
        $this->forge->addColumn('cc_module_settings', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('cc_module_settings', 'label');
    }
}
