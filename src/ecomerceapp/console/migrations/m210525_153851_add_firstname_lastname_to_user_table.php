<?php

use yii\db\Migration;

/**
 * Class m210525_153851_add_firstname_lastname_to_user_table
 */
class m210525_153851_add_firstname_lastname_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}','firstname',$this->string(255)->notNull()->after('id'));
        $this->addColumn('{{%user}}','lastname',$this->string(255)->notNull()->after('firstname'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}','firstname');
        $this->dropColumn('{{%user}}','lastname');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210525_153851_add_firstname_lastname_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
