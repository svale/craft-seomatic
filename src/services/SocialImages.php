<?php
/**
 * SEOmatic plugin for Craft CMS 3.x
 *
 * A turnkey SEO implementation for Craft CMS that is comprehensive, powerful,
 * and flexible
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\seomatic\services;

use Craft;
use craft\base\Component;
use craft\base\Element;
use craft\base\VolumeInterface;
use craft\errors\VolumeException;
use craft\helpers\Assets;
use craft\helpers\ElementHelper;
use craft\helpers\FileHelper;
use nystudio107\seomatic\helpers\ImageTransform;
use nystudio107\seomatic\helpers\PullField;
use nystudio107\seomatic\helpers\Queue as QueueHelper;
use nystudio107\seomatic\jobs\GenerateElementSocialImages;
use nystudio107\seomatic\models\MetaBundle;
use nystudio107\seomatic\models\MetaBundleSettings;
use nystudio107\seomatic\Seomatic;
use Spatie\Browsershot\Browsershot;

/**
 * @author    nystudio107
 * @package   Seomatic
 * @since     3.4.0
 */
class SocialImages extends Component
{
    /**
     * Get social image URL.
     *
     * @param Element $element
     * @param string $transformName
     * @param string $template
     * @return string
     */
    public function getSocialImageUrl(Element $element, $transformName = 'base', $template = ''): string
    {
        $transformParameters = ImageTransform::getTransformParametersByName($transformName);

        if (empty($transformParameters)) {
            Craft::error(Craft::t('seomatic', 'Cannot find the transform parameters for ' . $transformName), 'seomatic');
            return '';
        }

        $width = $transformParameters['width'];
        $height = $transformParameters['height'];

        $imagePath = $this->getSocialImageSubpath($element, $transformName, $template);

        /** @var Seomatic $seomatic */
        $seomatic = Seomatic::getInstance();

        $volume = $this->getSocialImageVolume();
        if (!$volume) {
            Craft::error(Craft::t('seomatic', 'Cannot find the specified social image volume.', 'seomatic'));
            return '';
        }

        $volumePath = $this->getSocialImageVolumePath($seomatic);

        $fullPath = $volumePath . DIRECTORY_SEPARATOR . $imagePath;

        if (!$volume->fileExists($fullPath)) {
            if (empty($template)) {
                $metaBundle = $seomatic->metaBundles->getMetaBundleByElement($element);

                if (!$metaBundle) {
                    Craft::error(Craft::t('seomatic', 'Cannot resolve meta bundle for element ' . $element->id), 'seomatic');
                    return '';
                }

                $template = $metaBundle->metaBundleSettings->seoImageTemplate ?? '';

                if (empty($template)) {
                    Craft::error(Craft::t('seomatic', 'Cannot resolve social image template for element ' . $element->id), 'seomatic');
                    return '';
                }
            }

            try {
                $this->createSocialImage($template, $element, $width, $height, $volume, $fullPath);
            } catch (\Exception $exception) {
                Craft::$app->getErrorHandler()->logException($exception);

                return '';
            }
        }

        return rtrim($volume->getRootUrl(), '/\\') . '/' . $fullPath;
    }

    /**
     * Update the social images for an element.
     *
     * @param Element $element
     * @param bool $allSites
     * @param bool $instant
     *
     * @throws \Throwable
     * @throws \yii\base\Exception
     */
    public function updateSocialImages(Element $element, $allSites = false, $instant = false)
    {
        if ($element->getIsRevision() || $element->getIsDraft()) {
            return;
        }

        $metaBundle = Seomatic::getInstance()->metaBundles->getMetaBundleByElement($element);

        // No vagrants beyond this point
        if (!$metaBundle) {
            return;
        }

        $queue = Craft::$app->getQueue();

        $queue->push(new GenerateElementSocialImages([
            'elementId' => $element->id,
            'allSites' => $allSites,
            'title' => $element->title,
        ]));

        if ($instant) {
            QueueHelper::run();
        }
    }

    /**
     * Invalidate all social images for a meta bundle.
     *
     * @param MetaBundle $metaBundle
     */
    public function invalidateSocialImagesForMetaBundle(MetaBundle $metaBundle)
    {
        $volume = $this->getSocialImageVolume();
        $volumePath = $this->getSocialImageVolumePath();

        if ($volume) {
            $folder = $this->getSocialImageMetaBundleSubfolder($metaBundle);

            try {
                $volume->deleteDir($volumePath . DIRECTORY_SEPARATOR . $folder);
            } catch (VolumeException $exception) {
                // Consider invalidated.
            }
        }
    }

    /**
     * Invalidate social images for an element.
     *
     * @param Element $element
     * @param bool $allSites whether elements in all sites should be invalidated
     */
    public function invalidateSocialImagesForElement(Element $element, $allSites = false)
    {
        $volume = $this->getSocialImageVolume();
        $volumePath = $this->getSocialImageVolumePath();

        if ($volume) {
            if ($allSites) {
                foreach (ElementHelper::supportedSitesForElement($element) as $site) {
                    $folder = $this->getSocialImageSubfolder($element, $site['siteId']);

                    try {
                        $volume->deleteDir($volumePath . DIRECTORY_SEPARATOR . $folder);
                    } catch (VolumeException $exception) {
                        // Consider invalidated.
                    }
                }
            } else {
                $folder = $this->getSocialImageSubfolder($element, $element->siteId);

                try {
                    $volume->deleteDir($volumePath . DIRECTORY_SEPARATOR . $folder);
                } catch (VolumeException $exception) {
                    // Consider invalidated.
                }
            }
        }
    }

    /**
     * Get the social image filename from components
     *
     * @param Element $element
     * @param string $transformName
     * @param string $templatePath
     * @return string
     */
    protected function getSocialImageSubpath(Element $element, string $transformName, string $templatePath = ''): string
    {
        $templateHash = !empty($templatePath) ? '_' . substr(sha1($templatePath), 0, 7) : '';
        return $this->getSocialImageSubfolder($element, $element->siteId) . DIRECTORY_SEPARATOR . $transformName . $templateHash . '.' . ImageTransform::DEFAULT_SOCIAL_FORMAT;
    }

    /**
     * @param Element $element
     * @param int $siteId
     * @return string
     */
    protected function getSocialImageSubfolder(Element $element, int $siteId): string
    {
        return $this->getSocialImageMetaBundleSubfolder(Seomatic::getInstance()->metaBundles->getMetaBundleByElement($element)) . DIRECTORY_SEPARATOR . $element->id . '-' . $siteId;
    }

    /**
     * @return VolumeInterface|null
     */
    protected function getSocialImageVolume(): VolumeInterface
    {
        $volume = Craft::$app->getVolumes()->getVolumeByUid(Seomatic::getInstance()->getSettings()->socialImageVolumeUid);
        return $volume;
    }

    /**
     * @return string
     */
    protected function getSocialImageVolumePath(): string
    {
        return rtrim(Seomatic::getInstance()->getSettings()->socialImageSubpath, '/\\');
    }

    /**
     * @param string $template
     * @param Element $element
     * @param $width
     * @param $height
     * @param VolumeInterface $volume
     * @param string $fullPath
     * @throws \Throwable
     */
    protected function createSocialImage(string $template, Element $element, $width, $height, VolumeInterface $volume, string $fullPath)
    {
        $view = Craft::$app->getView();
        $templateContent = file_get_contents($view->resolveTemplate($template));
        $html = $view->renderObjectTemplate($templateContent, $element);

        $tempPath = Assets::tempFilePath(ImageTransform::DEFAULT_SOCIAL_FORMAT);
        $browserShot = Browsershot::html($html)
            ->width($width)
            ->height($height)
            ->quality(ImageTransform::SOCIAL_TRANSFORM_QUALITY);

        $seomaticSettings = Seomatic::getInstance()->getSettings();

        if (!$seomaticSettings->socialImagesEnableSandbox) {
            $browserShot->noSandbox();
        }

        if ($seomaticSettings->socialImagesChromePath) {
            $browserShot->setChromePath($seomaticSettings->socialImagesChromePath);
        }

        if ($seomaticSettings->socialImagesNodeModulePath) {
            $browserShot->setNodeModulePath($seomaticSettings->socialImagesNodeModulePath);
        }

        $browserShot->save($tempPath);

        $fileStream = fopen($tempPath, 'rb');
        $volume->createFileByStream($fullPath, $fileStream, [
            'mimetype' => FileHelper::getMimeType($tempPath)
        ]);

        fclose($fileStream);
        unlink($tempPath);
    }

    /**
     * Get the social image meta bundle subpath for a meta bundle.
     *
     * @param MetaBundle $metaBundle
     * @return string
     */
    protected function getSocialImageMetaBundleSubfolder(MetaBundle $metaBundle): string
    {
        return "{$metaBundle->sourceType}_{$metaBundle->sourceId}" . (!empty($metaBundle->typeId) ? "_{$metaBundle->typeId}" : '');
    }
}
