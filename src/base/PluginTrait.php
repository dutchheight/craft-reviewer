<?php
 /**
 * Page Reviewer plugin for Craft CMS 3.x
 *
 * Enables content editors to share a preview of a page, which can be viewed by a public or private URL.
 *
 * @link      https://www.dutchheight.com/
 * @copyright Copyright (c) 2019 Dutch Height
 */

namespace dutchheight\reviewer\base;

use dutchheight\reviewer\Reviewer;
use dutchheight\reviewer\services\Comments;

use Craft;

use yii\log\Logger;

/**
 * @author    Dutch Height
 * @package   Reviewer
 * @since     1.0.0
 */
trait PluginTrait
{
    // Public Properties
    // =========================================================================

    /**
     * @var Reviewer
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * Returns the comments services
     *
     * @return Comments
     */
    public function getComments(): Comments
    {
        return $this->get('comments');
    }

    public static function info($message)
    {
        Craft::getLogger()->log($message, Logger::LEVEL_INFO, 'reviewer');
    }

    public static function warning($message)
    {
        Craft::getLogger()->log($message, Logger::LEVEL_WARNING, 'reviewer');
    }

    public static function error($message)
    {
        Craft::getLogger()->log($message, Logger::LEVEL_ERROR, 'reviewer');
    }

    // Protected Methods
    // =========================================================================

    protected function registerComponents()
    {
        $this->setComponents([
            'comments' => Comments::class
        ]);
    }
}
