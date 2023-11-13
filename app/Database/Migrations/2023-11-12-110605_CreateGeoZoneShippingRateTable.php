<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateGeoZoneShippingRateTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cc_geo_zone_shipping_rate_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'geo_zone_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'up_to_value' => [
                'type'       => 'float',
            ],
             'cost' => [
                 'type'       => 'INT',
                 'constraint' => 11,
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
        $this->forge->addKey('cc_geo_zone_shipping_rate_id', true);
        $this->forge->createTable('cc_geo_zone_shipping_rate');
    }

    public function down()
    {
        $this->forge->dropTable('cc_geo_zone_shipping_rate');
    }
}
