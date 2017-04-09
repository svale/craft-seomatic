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

namespace nystudio107\seomatic\base;

/**
 * @author    nystudio107
 * @package   Seomatic
 * @since     3.0.0
 */
interface MetaContainerInterface
{

    // Constants
    // =========================================================================

    const CONTAINER_TYPE = 'Generic';

    // Static Properties
    // =========================================================================

    // Static Methods
    // =========================================================================

    public static function create($config = []);

    // Public Properties
    // =========================================================================

    // Public Methods
    // =========================================================================

    /**
     * Normalizes the containers’s data for use.
     *
     * This is called after container data is loaded, to allow it to be parsed,
     * models instantiated, etc.
     */
    public function normalizeContainerData();

    // Private Methods
    // =========================================================================

}