<?php
/**
 * SEOmatic plugin for Craft CMS 3.x
 *
 * A turnkey SEO implementation for Craft CMS that is comprehensive, powerful,
 * and flexible
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2017 nystudio107
 */

namespace nystudio107\seomatic\events;

use nystudio107\seomatic\models\MetaBundle;
use yii\base\Event;

/**
 * @author    nystudio107
 * @package   Seomatic
 * @since     3.1.48
 */
class MetaBundleDebugDataEvent extends Event
{
    const GLOBAL_META_BUNDLE = 'global';
    const CONTENT_META_BUNDLE = 'content';
    const FIELD_META_BUNDLE = 'field';
    const COMBINED_META_BUNDLE = 'combined';

    // Properties
    // =========================================================================

    /**
     * @var string The category of the MetaBundle
     */
    public $metaBundleCategory = '';

    /**
     * @var MetaBundle|null $metaBundle The MetaBundle to record debug data for
     */
    public $metaBundle;
}
