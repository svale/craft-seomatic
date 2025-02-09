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

namespace nystudio107\seomatic\models;

use Craft;
use nystudio107\seomatic\base\MetaContainer;
use nystudio107\seomatic\Seomatic;
use yii\caching\TagDependency;

/**
 * @author    nystudio107
 * @package   Seomatic
 * @since     3.0.0
 */
class MetaTitleContainer extends MetaContainer
{
    // Constants
    // =========================================================================

    const CONTAINER_TYPE = 'MetaTitleContainer';

    // Public Properties
    // =========================================================================

    /**
     * The data in this container
     *
     * @var MetaTitle[]|array $data
     */
    public $data = [];

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function includeMetaData($dependency)
    {
        Craft::beginProfile('MetaTitleContainer::includeMetaData', __METHOD__);
        $uniqueKey = $this->handle . $dependency->tags[3];
        $cache = Craft::$app->getCache();
        if ($this->clearCache) {
            TagDependency::invalidate($cache, $dependency->tags[3]);
        }
        $tagData = $cache->getOrSet(
            self::CONTAINER_TYPE . $uniqueKey,
            function() use ($uniqueKey) {
                Craft::info(
                    self::CONTAINER_TYPE . ' cache miss: ' . $uniqueKey,
                    __METHOD__
                );
                $tagData = '';
                if ($this->prepForInclusion()) {
                    foreach ($this->data as $metaTitleModel) {
                        if ($metaTitleModel->include) {
                            $title = $metaTitleModel->title;
                            if ($metaTitleModel->prepForRender($title)) {
                                $tagData = $title;
                                // If `devMode` is enabled, validate the Meta Tag and output any model errors
                                if (Seomatic::$devMode) {
                                    $scenario = [];
                                    $scenario['default'] = 'error';
                                    $scenario['warning'] = 'warning';
                                    $metaTitleModel->debugMetaItem(
                                        'Tag attribute: ',
                                        $scenario
                                    );
                                }
                            }
                        }
                    }
                }

                return $tagData;
            },
            Seomatic::$cacheDuration,
            $dependency
        );
        // Register the tags
        Seomatic::$view->title = $tagData;
        Craft::endProfile('MetaTitleContainer::includeMetaData', __METHOD__);
    }

    /**
     * @inheritdoc
     */
    public function normalizeContainerData()
    {
        parent::normalizeContainerData();

        /** @var array $config */
        foreach ($this->data as $key => $config) {
            $config['key'] = $key;
            $this->data[$key] = MetaTitle::create($config);
        }
    }
}
