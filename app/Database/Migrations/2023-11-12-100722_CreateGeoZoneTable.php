<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateGeoZoneTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'geo_zone_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'geo_zone_name' => [
                'type'       => 'varchar',
                'constraint' => 155,
            ],
            'geo_zone_description' => [
                'type'       => 'varchar',
                'constraint' => 300,
                'null' => true,
                'default' => null,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
            ],
            'createdDtm' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'createdBy' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => null,
            ],
            'updatedBy' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => null,
            ],
            'updatedDtm DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('geo_zone_id', true);
        $this->forge->createTable('cc_geo_zone');
    }

    public function down()
    {
        $this->forge->dropTable('cc_geo_zone');
    }
}
