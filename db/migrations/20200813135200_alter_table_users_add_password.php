<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterTableUsersAddPassword extends AbstractMigration
{
    private const TABLE_NAME = 'users';
    public function up():void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('password', \Phinx\Db\Table\Column::STRING, ['limit' => 255, 'null' => true, 'after' => 'email'])
            ->save();
    }

    public function down():void
    {
        $this->table(self::TABLE_NAME)->removeColumn('password')->save();
    }
}
