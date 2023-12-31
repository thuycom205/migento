<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\CustomerGraphQl\Model\Customer;

use Magento\Customer\Api\MetadataInterface;
use Magento\EavGraphQl\Model\GetAttributesFormInterface;

/**
 * Attributes form provider for customer
 */
class GetAttributesForm implements GetAttributesFormInterface
{
    /**
     * @var MetadataInterface
     */
    private MetadataInterface $entity;

    /**
     * @var string
     */
    private string $type;

    /**
     * @param MetadataInterface $metadata
     * @param string $type
     */
    public function __construct(MetadataInterface $metadata, string $type)
    {
        $this->entity = $metadata;
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function execute(string $formCode): ?array
    {
        $attributes = [];
        foreach ($this->entity->getAttributes($formCode) as $attribute) {
            // region_id and country_id returns large datasets that is also not related between each other and
            // not filterable. DirectoryGraphQl contains queries that allow to retrieve this information in a
            // meaningful way
            if ($attribute->getAttributeCode() === 'region_id' || $attribute->getAttributeCode() === 'country_id') {
                continue;
            }
            $attributes[] = ['entity_type' => $this->type, 'attribute_code' => $attribute->getAttributeCode()];
        }
        return $attributes;
    }
}
