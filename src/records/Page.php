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

use craft\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @author    Dutch Height
 * @package   Reviewer
 * @since     1.0.0
 *
 * @property int $id
 * @property string $url
 * @property string $password
 * @property bool $anonymous
 * @property DateTime $startDate
 * @property DateTime $expiryDate
 * @property Comment[] $comments
 */
class Page extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%reviewer_pages}}';
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
                [['url'], 'required'],
                [['url', 'password'], 'string'],
                [['anonymous'], 'boolean'],
            ]
        );
    }

    /**
     * Returns the page's comments
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['pageId' => 'id']);
    }
}
