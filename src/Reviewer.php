<?php
/**
 * Page Reviewer plugin for Craft CMS 3.x
 *
 * Enables content editors to share a preview of a page, which can be viewed by a public or private URL.
 *
 * @link      https://www.dutchheight.com/
 * @copyright Copyright (c) 2019 Dutch Height
 */

namespace dutchheight\reviewer;

use dutchheight\reviewer\base\PluginTrait;
use dutchheight\reviewer\services\Comments as CommentsService;

use Craft;
use craft\base\Plugin;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\services\UserPermissions;

use yii\base\Event;

/**
 * Class Reviewer
 *
 * @author    Dutch Height
 * @package   Reviewer
 * @since     1.0.0
 *
 * @property  CommentsService $comments
 */
class Reviewer extends Plugin
{
    // Traits
    // =========================================================================
    use PluginTrait;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register our site routes
        $this->registerComponents();
        $this->registerEventListeners();

        Reviewer::info(Craft::t('reviewer', '{name} plugin loaded',
            ['name' => $this->name]
        ));
    }

    // Protected Methods
    // =========================================================================

    protected function registerEventListeners()
    {
        $request = Craft::$app->getRequest();

        // Install only for non-console Site requests
        if ($request->getIsSiteRequest() && !$request->getIsConsoleRequest()) {
            $this->registerSiteEventListeners();
        }

        // Install only for non-console Control Panel requests
        if ($request->getIsCpRequest() && !$request->getIsConsoleRequest()) {
            $this->registerCpEventListeners();
        }
    }

    protected function registerSiteEventListeners()
    {
        // Handler: UrlManager::EVENT_REGISTER_SITE_URL_RULES
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'page-reviewer/review';
            }
        );
    }

    protected function registerCpEventListeners()
    {
        // Handler: UserPermissions::EVENT_REGISTER_PERMISSIONS
        Event::on(
            UserPermissions::class,
            UserPermissions::EVENT_REGISTER_PERMISSIONS,
            function (RegisterUserPermissionsEvent $event) {
                // Register our custom permissions
                $event->permissions[Craft::t('reviewer', 'Page Reviewer')] = $this->registerCpPermissions();
            }
        );
    }

    /**
     * Returns the Control Panel user permissions.
     *
     * @return array
     */
    protected function registerCpPermissions(): array
    {
        return [
            'reviewer:share' => [
                'label' => Craft::t('reviewer', 'Page sharing'),
            ]
        ];
    }
}
