<?php
/**
 * Page Reviewer plugin for Craft CMS 3.x
 *
 * Enables content editors to share a preview of a page, which can be viewed by a public or private URL.
 *
 * @link      https://www.dutchheight.com/
 * @copyright Copyright (c) 2019 Dutch Height
 */

namespace dutchheight\reviewer\migrations;

use dutchheight\reviewer\records\Page;
use dutchheight\reviewer\records\Comment;

use Craft;
use craft\db\Table;
use craft\db\Migration;

/**
 * @author    Dutch Height
 * @package   Reviewer
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        if ($this->createTables()) {
            $this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->removeTables();
        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates the tables needed for the Records used by the plugin
     *
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        if (Craft::$app->db->schema->getTableSchema(Page::tableName()) === null) {
            $tablesCreated = true;
            $this->createTable(Page::tableName(), [
                'id' => $this->primaryKey(),
                'url' => $this->string(255)->notNull()->unique(),
                'password' => $this->string(),
                'anonymous' => $this->boolean()->defaultValue(false),
                'startDate' => $this->dateTime(),
                'expiryDate' => $this->dateTime(),

                'dateCreated' => $this->dateTime()->notNull(),
                'dateUpdated' => $this->dateTime()->notNull(),
                'uid' => $this->uid(),
            ]);
        }

        if (Craft::$app->db->schema->getTableSchema(Comment::tableName()) === null) {
            $tablesCreated = true;
            $this->createTable(Comment::tableName(), [
                'id' => $this->primaryKey(),
                'pageId' => $this->integer()->notNull(),
                'content' => $this->text()->notNull(),
                'target' => $this->text(),
                'name' => $this->string(100),

                'dateCreated' => $this->dateTime()->notNull(),
                'dateUpdated' => $this->dateTime()->notNull(),
                'uid' => $this->uid(),
            ]);
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        $this->createIndex(null, Page::tableName(), 'url', true);
        $this->createIndex(null, Comment::tableName(), 'pageId', false);
    }

    /**
     * @return void
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey(null, Comment::tableName(), 'pageId', Page::tableName(), 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @return void
     */
    protected function removeTables()
    {
        $this->dropTableIfExists(Comment::tableName());
        $this->dropTableIfExists(Page::tableName());
    }
}
