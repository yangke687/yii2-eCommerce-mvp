<?php

use yii\db\Migration;

/**
 * Class m230125_064515_add_firstname_lastname_cols_to_user_table
 */
class m230125_064515_add_firstname_lastname_cols_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'firstname', $this->string(255)->notNull()->after('id'));
        $this->addColumn('{{%user}}', 'lastname', $this->string(255)->notNull()->after('firstname'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230125_064515_add_firstname_lastname_cols_to_user_table cannot be reverted.\n";

        $this->dropColumn('{{%user}}', 'firstname');
        $this->dropColumn('{{%user}}', 'lastname');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230125_064515_add_firstname_lastname_cols_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
