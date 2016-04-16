<?php

/**
 * Class Migration_Expand_user_table
 *
 * @property CI_DB_forge dbforge
 */
class Migration_Add_profile_picture_column extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('users', [
            'profile_picture' => ['type' => 'varchar', 'constraint' => 255],
        ]);

    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'profile_picture');
    }
}