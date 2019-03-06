<?php
/**
 * Page Reviewer plugin for Craft CMS 3.x
 *
 * Enables content editors to share a preview of a page, which can be viewed by a public or private URL.
 *
 * @link      https://www.dutchheight.com/
 * @copyright Copyright (c) 2019 Dutch Height
 */

namespace dutchheight\reviewer\controllers;

use Craft;
use craft\web\Controller;

/**
 * @author    Dutch Height
 * @package   Reviewer
 * @since     1.0.0
 */
class ReviewerController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/page-reviewer/review
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the ReviewController actionIndex() method';

        return $result;
    }
}
