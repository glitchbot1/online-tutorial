<?php

use yii\db\Migration;

/**
 * Handles the creation of table `token`.
 */
class m190112_120735_create_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%token}}', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'token'=>$this->string()->notNull()->unique(),
            'expired_at' => $this->integer()->notNull(),

        ]);
        $this->createIndex('idx-token-user-id','{{%token}}','user_id');
        $this->addForeignKey('fk-token-user-id','{{%token}}','{{%user}}','id','CASCADE','RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%token}}');
    }
}
