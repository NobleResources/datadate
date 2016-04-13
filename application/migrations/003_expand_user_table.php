<?php

/**
 * Class Migration_Expand_user_table
 *
 * @property CI_DB_forge dbforge
 */
class Migration_Expand_user_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('user', [
            'nickname' => ['type' => 'varchar', 'constraint' => 20],
            'first_name' => ['type' => 'varchar', 'constraint' => 50],
            'last_name' => ['type' => 'varchar', 'constraint' => 50],
            'gender' => ['type' => 'varchar', 'constraint' => 6],
            'birthday' => ['type' => 'date'],
            'description' => ['type' => 'text'],
        ]);

    }

    public function down()
    {
        $this->dbforge->drop_column('user', 'nickname');
        $this->dbforge->drop_column('user', 'first_name');
        $this->dbforge->drop_column('user', 'last_name');
        $this->dbforge->drop_column('user', 'gender');
        $this->dbforge->drop_column('user', 'birthday');
        $this->dbforge->drop_column('user', 'description');
    }
}