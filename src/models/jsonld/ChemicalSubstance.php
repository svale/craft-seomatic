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
 * ChemicalSubstance - A chemical substance is 'a portion of matter of constant composition,
 * composed of molecular entities of the same type or of different types'
 * (source:
 * [ChEBI:59999](https://www.ebi.ac.uk/chebi/searchId.do?chebiId=59999)).
 *
 * @author    nystudio107
 * @package   Seomatic
 * @see       https://schema.org/ChemicalSubstance
 */
class ChemicalSubstance extends MetaJsonLd implements ChemicalSubstanceInterface, BioChemEntityInterface, ThingInterface
{
    use ChemicalSubstanceTrait;
    use BioChemEntityTrait;
    use ThingTrait;

    /**
     * The Schema.org Type Name
     *
     * @var string
     */
    public static $schemaTypeName = 'ChemicalSubstance';

    /**
     * The Schema.org Type Scope
     *
     * @var string
     */
    public static $schemaTypeScope = 'https://schema.org/ChemicalSubstance';

    /**
     * The Schema.org Type Extends
     *
     * @var string
     */
    public static $schemaTypeExtends = 'BioChemEntity';

    /**
     * The Schema.org Type Description
     *
     * @var string
     */
    public static $schemaTypeDescription = 'A chemical substance is \'a portion of matter of constant composition, composed of molecular entities of the same type or of different types\' (source: [ChEBI:59999](https://www.ebi.ac.uk/chebi/searchId.do?chebiId=59999)).';


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
            'associatedDisease' => ['array', 'MedicalCondition', 'MedicalCondition[]', 'array', 'URL', 'URL[]', 'array', 'PropertyValue', 'PropertyValue[]'],
            'bioChemInteraction' => ['array', 'BioChemEntity', 'BioChemEntity[]'],
            'bioChemSimilarity' => ['array', 'BioChemEntity', 'BioChemEntity[]'],
            'biologicalRole' => ['array', 'DefinedTerm', 'DefinedTerm[]'],
            'chemicalComposition' => ['array', 'Text', 'Text[]'],
            'chemicalRole' => ['array', 'DefinedTerm', 'DefinedTerm[]'],
            'description' => ['array', 'TextObject', 'TextObject[]', 'array', 'Text', 'Text[]'],
            'disambiguatingDescription' => ['array', 'Text', 'Text[]'],
            'funding' => ['array', 'Grant', 'Grant[]'],
            'hasBioChemEntityPart' => ['array', 'BioChemEntity', 'BioChemEntity[]'],
            'hasMolecularFunction' => ['array', 'URL', 'URL[]', 'array', 'DefinedTerm', 'DefinedTerm[]', 'array', 'PropertyValue', 'PropertyValue[]'],
            'hasRepresentation' => ['array', 'PropertyValue', 'PropertyValue[]', 'array', 'Text', 'Text[]', 'array', 'URL', 'URL[]'],
            'identifier' => ['array', 'Text', 'Text[]', 'array', 'URL', 'URL[]', 'array', 'PropertyValue', 'PropertyValue[]'],
            'image' => ['array', 'ImageObject', 'ImageObject[]', 'array', 'URL', 'URL[]'],
            'isEncodedByBioChemEntity' => ['array', 'Gene', 'Gene[]'],
            'isInvolvedInBiologicalProcess' => ['array', 'DefinedTerm', 'DefinedTerm[]', 'array', 'PropertyValue', 'PropertyValue[]', 'array', 'URL', 'URL[]'],
            'isLocatedInSubcellularLocation' => ['array', 'URL', 'URL[]', 'array', 'DefinedTerm', 'DefinedTerm[]', 'array', 'PropertyValue', 'PropertyValue[]'],
            'isPartOfBioChemEntity' => ['array', 'BioChemEntity', 'BioChemEntity[]'],
            'mainEntityOfPage' => ['array', 'URL', 'URL[]', 'array', 'CreativeWork', 'CreativeWork[]'],
            'name' => ['array', 'Text', 'Text[]'],
            'potentialAction' => ['array', 'Action', 'Action[]'],
            'potentialUse' => ['array', 'DefinedTerm', 'DefinedTerm[]'],
            'sameAs' => ['array', 'URL', 'URL[]'],
            'subjectOf' => ['array', 'CreativeWork', 'CreativeWork[]', 'array', 'Event', 'Event[]'],
            'taxonomicRange' => ['array', 'DefinedTerm', 'DefinedTerm[]', 'array', 'Taxon', 'Taxon[]', 'array', 'Text', 'Text[]', 'array', 'URL', 'URL[]'],
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
            'associatedDisease' => 'Disease associated to this BioChemEntity. Such disease can be a MedicalCondition or a URL. If you want to add an evidence supporting the association, please use PropertyValue.',
            'bioChemInteraction' => 'A BioChemEntity that is known to interact with this item.',
            'bioChemSimilarity' => 'A similar BioChemEntity, e.g., obtained by fingerprint similarity algorithms.',
            'biologicalRole' => 'A role played by the BioChemEntity within a biological context.',
            'chemicalComposition' => 'The chemical composition describes the identity and relative ratio of the chemical elements that make up the substance.',
            'chemicalRole' => 'A role played by the BioChemEntity within a chemical context.',
            'description' => 'A description of the item.',
            'disambiguatingDescription' => 'A sub property of description. A short description of the item used to disambiguate from other, similar items. Information from other properties (in particular, name) may be necessary for the description to be useful for disambiguation.',
            'funding' => 'A [[Grant]] that directly or indirectly provide funding or sponsorship for this item. See also [[ownershipFundingInfo]].',
            'hasBioChemEntityPart' => 'Indicates a BioChemEntity that (in some sense) has this BioChemEntity as a part. ',
            'hasMolecularFunction' => 'Molecular function performed by this BioChemEntity; please use PropertyValue if you want to include any evidence.',
            'hasRepresentation' => 'A common representation such as a protein sequence or chemical structure for this entity. For images use schema.org/image.',
            'identifier' => 'The identifier property represents any kind of identifier for any kind of [[Thing]], such as ISBNs, GTIN codes, UUIDs etc. Schema.org provides dedicated properties for representing many of these, either as textual strings or as URL (URI) links. See [background notes](/docs/datamodel.html#identifierBg) for more details.         ',
            'image' => 'An image of the item. This can be a [[URL]] or a fully described [[ImageObject]].',
            'isEncodedByBioChemEntity' => 'Another BioChemEntity encoding by this one.',
            'isInvolvedInBiologicalProcess' => 'Biological process this BioChemEntity is involved in; please use PropertyValue if you want to include any evidence.',
            'isLocatedInSubcellularLocation' => 'Subcellular location where this BioChemEntity is located; please use PropertyValue if you want to include any evidence.',
            'isPartOfBioChemEntity' => 'Indicates a BioChemEntity that is (in some sense) a part of this BioChemEntity. ',
            'mainEntityOfPage' => 'Indicates a page (or other CreativeWork) for which this thing is the main entity being described. See [background notes](/docs/datamodel.html#mainEntityBackground) for details.',
            'name' => 'The name of the item.',
            'potentialAction' => 'Indicates a potential Action, which describes an idealized action in which this thing would play an \'object\' role.',
            'potentialUse' => 'Intended use of the BioChemEntity by humans.',
            'sameAs' => 'URL of a reference Web page that unambiguously indicates the item\'s identity. E.g. the URL of the item\'s Wikipedia page, Wikidata entry, or official website.',
            'subjectOf' => 'A CreativeWork or Event about this Thing.',
            'taxonomicRange' => 'The taxonomic grouping of the organism that expresses, encodes, or in some way related to the BioChemEntity.',
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
