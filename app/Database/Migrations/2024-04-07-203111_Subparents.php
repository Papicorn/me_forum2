<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Subparents extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_subparents' => [
                'type'                  => 'INT',
                'constraint'            => 11,
                'unsigned'              => 'true',
                'autoincrement'         => 'true',
            ],
            'title' => [
                'type'=> 'INT',
                'constraint'=> 11,
            ],
            'id_parents' => [
                'type'                  => 'INT',
                'constraint' => 11,
                'unsigned' => 'true',
                'autoincrement'=> 'true',
            ],
            'created_at  timestamp default current_timestamp',
            'updated_at  timestamp default current_timestamp ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->forge->addPrimaryKey('id_subparents');
        $this->forge->createTable('subparents');
        $this->forge->addForeignKey('id_parents','parents','id_parents','CASCADE','CASCADE');
    }

    public function down()
    {
        //
    }
}
