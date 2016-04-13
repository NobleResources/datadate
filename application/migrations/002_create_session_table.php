<?php

class Migration_Create_session_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'VARCHAR', 'constraint' => 40],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45],
            'timestamp' => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'data' => ['type' => 'blob'],
        ]);

        $this->dbforge->create_table('session');
    }

    public function down()
    {
        $this->dbforge->drop_table('session');
    }
}