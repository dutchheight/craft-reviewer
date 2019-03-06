<?php
/**
 * Page Reviewer plugin for Craft CMS 3.x
 *
 * Enables content editors to share a preview of a page, which can be viewed by a public or private URL.
 *
 * @link      https://www.dutchheight.com/
 * @copyright Copyright (c) 2019 Dutch Height
 */

namespace dutchheight\reviewer\records;

use dutchheight\reviewer\records\Page;

use craft\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @author    Dutch Height
 * @package   Reviewer
 * @since     1.0.0
 *
 * @property int $id
 * @property int $pageId
 * @property string $content content of a comment
 * @property string|null $target target on a page that as a comment about it
 * @property string|null $name name of the person who left a comment
 * @property Page $page
 */
class Comment extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%reviewer_comments}}';
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['pageId'], 'integer'],
                [['pageId', 'content'], 'required'],
                [['content', 'target'], 'string'],
                [['name'], 'string', 'max' => 100],
            ]
        );
    }

    /**
     * Returns the comment's page
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPage(): ActiveQuery
    {
        return $this->hasOne(Page::class, ['id' => 'pageId']);
    }
}
