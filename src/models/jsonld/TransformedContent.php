<?php

/**
 * SEOmatic plugin for Craft CMS
 *
 * A turnkey SEO implementation for Craft CMS that is comprehensive, powerful, and flexible
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) nystudio107
 */

namespace nystudio107\seomatic\models\jsonld;

use nystudio107\seomatic\models\MetaJsonLd;

/**
 * schema.org version: v26.0-release
 * TransformedContent - Content coded 'transformed content' in a [[MediaReview]], considered in the
 * context of how it was published or shared.  For a [[VideoObject]] to be
 * 'transformed content':  or all of the video has been manipulated to
 * transform the footage itself. This category includes using tools like the
 * Adobe Suite to change the speed of the video, add or remove visual elements
 * or dub audio. Deepfakes are also a subset of transformation.  For an
 * [[ImageObject]] to be 'transformed content': Adding or deleting visual
 * elements to give the image a different meaning with the intention to
 * mislead.  For an [[ImageObject]] with embedded text to be 'transformed
 * content': Adding or deleting visual elements to give the image a different
 * meaning with the intention to mislead.  For an [[AudioObject]] to be
 * 'transformed content': Part or all of the audio has been manipulated to
 * alter the words or sounds, or the audio has been synthetically generated,
 * such as to create a sound-alike voice.
 *
 * @author    nystudio107
 * @package   Seomatic
 * @see       https://schema.org/TransformedContent
 */
class TransformedContent extends MetaJsonLd implements TransformedContentInterface, MediaManipulationRatingEnumerationInterface, EnumerationInterface, IntangibleInterface, ThingInterface
{
    use TransformedContentTrait;
    use MediaManipulationRatingEnumerationTrait;
    use EnumerationTrait;
    use IntangibleTrait;
    use ThingTrait;

    /**
     * The Schema.org Type Name
     *
     * @var string
     */
    public static $schemaTypeName = 'TransformedContent';

    /**
     * The Schema.org Type Scope
     *
     * @var string
     */
    public static $schemaTypeScope = 'https://schema.org/TransformedContent';

    /**
     * The Schema.org Type Extends
     *
     * @var string
     */
    public static $schemaTypeExtends = 'MediaManipulationRatingEnumeration';

    /**
     * The Schema.org Type Description
     *
     * @var string
     */
    public static $schemaTypeDescription = "Content coded 'transformed content' in a [[MediaReview]], considered in the context of how it was published or shared.\n\nFor a [[VideoObject]] to be 'transformed content':  or all of the video has been manipulated to transform the footage itself. This category includes using tools like the Adobe Suite to change the speed of the video, add or remove visual elements or dub audio. Deepfakes are also a subset of transformation.\n\nFor an [[ImageObject]] to be 'transformed content': Adding or deleting visual elements to give the image a different meaning with the intention to mislead.\n\nFor an [[ImageObject]] with embedded text to be 'transformed content': Adding or deleting visual elements to give the image a different meaning with the intention to mislead.\n\nFor an [[AudioObject]] to be 'transformed content': Part or all of the audio has been manipulated to alter the words or sounds, or the audio has been synthetically generated, such as to create a sound-alike voice.";


    /**
     * @inheritdoc
     */
    public function getSchemaPropertyNames(): array
    {
        return array_keys($this->getSchemaPropertyExpectedTypes());
    }


    /**
     * @inheritdoc
     */
    public function getSchemaPropertyExpectedTypes(): array
    {
        return [
            'additionalType' => ['array', 'Text', 'Text[]', 'array', 'URL', 'URL[]'],
            'alternateName' => ['array', 'Text', 'Text[]'],
            'description' => ['array', 'TextObject', 'TextObject[]', 'array', 'Text', 'Text[]'],
            'disambiguatingDescription' => ['array', 'Text', 'Text[]'],
            'identifier' => ['array', 'Text', 'Text[]', 'array', 'URL', 'URL[]', 'array', 'PropertyValue', 'PropertyValue[]'],
            'image' => ['array', 'ImageObject', 'ImageObject[]', 'array', 'URL', 'URL[]'],
            'mainEntityOfPage' => ['array', 'URL', 'URL[]', 'array', 'CreativeWork', 'CreativeWork[]'],
            'name' => ['array', 'Text', 'Text[]'],
            'potentialAction' => ['array', 'Action', 'Action[]'],
            'sameAs' => ['array', 'URL', 'URL[]'],
            'subjectOf' => ['array', 'CreativeWork', 'CreativeWork[]', 'array', 'Event', 'Event[]'],
            'supersededBy' => ['array', 'SchemaClass', 'SchemaClass[]', 'array', 'Enumeration', 'Enumeration[]', 'array', 'Property', 'Property[]'],
            'url' => ['array', 'URL', 'URL[]'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function getSchemaPropertyDescriptions(): array
    {
        return [
            'additionalType' => 'An additional type for the item, typically used for adding more specific types from external vocabularies in microdata syntax. This is a relationship between something and a class that the thing is in. Typically the value is a URI-identified RDF class, and in this case corresponds to the     use of rdf:type in RDF. Text values can be used sparingly, for cases where useful information can be added without their being an appropriate schema to reference. In the case of text values, the class label should follow the schema.org <a href="https://schema.org/docs/styleguide.html">style guide</a>.',
            'alternateName' => 'An alias for the item.',
            'description' => 'A description of the item.',
            'disambiguatingDescription' => 'A sub property of description. A short description of the item used to disambiguate from other, similar items. Information from other properties (in particular, name) may be necessary for the description to be useful for disambiguation.',
            'identifier' => 'The identifier property represents any kind of identifier for any kind of [[Thing]], such as ISBNs, GTIN codes, UUIDs etc. Schema.org provides dedicated properties for representing many of these, either as textual strings or as URL (URI) links. See [background notes](/docs/datamodel.html#identifierBg) for more details.         ',
            'image' => 'An image of the item. This can be a [[URL]] or a fully described [[ImageObject]].',
            'mainEntityOfPage' => 'Indicates a page (or other CreativeWork) for which this thing is the main entity being described. See [background notes](/docs/datamodel.html#mainEntityBackground) for details.',
            'name' => 'The name of the item.',
            'potentialAction' => 'Indicates a potential Action, which describes an idealized action in which this thing would play an \'object\' role.',
            'sameAs' => 'URL of a reference Web page that unambiguously indicates the item\'s identity. E.g. the URL of the item\'s Wikipedia page, Wikidata entry, or official website.',
            'subjectOf' => 'A CreativeWork or Event about this Thing.',
            'supersededBy' => 'Relates a term (i.e. a property, class or enumeration) to one that supersedes it.',
            'url' => 'URL of the item.',
        ];
    }


    /**
     * @inheritdoc
     */
    public function getGoogleRequiredSchema(): array
    {
        return ['description', 'name'];
    }


    /**
     * @inheritdoc
     */
    public function getGoogleRecommendedSchema(): array
    {
        return ['image', 'url'];
    }


    /**
     * @inheritdoc
     */
    public function defineRules(): array
    {
        $rules = parent::defineRules();
        $rules = array_merge($rules, [
                [$this->getSchemaPropertyNames(), 'validateJsonSchema'],
                [$this->getGoogleRequiredSchema(), 'required', 'on' => ['google'], 'message' => 'This property is required by Google.'],
                [$this->getGoogleRecommendedSchema(), 'required', 'on' => ['google'], 'message' => 'This property is recommended by Google.'],
            ]);

        return $rules;
    }
}
