<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MageStore\Marketplace\Setup\Patch\Data;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Eav\Model\Config;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

/**
 * Class AddAttributeSets
 * @package MageStore\Marketplace\Setup\Patch\Data
 */
class AddAttributeSets implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * InitializeAuthRoles constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param AttributeSetFactory $attributeSetFactory
     * @param Config $eavConfig
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        AttributeSetFactory $attributeSetFactory,
        Config $eavConfig
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $productEntity = $this->eavConfig->getEntityType(ProductAttributeInterface::ENTITY_TYPE_CODE);
        $attributeSetId = $productEntity->getDefaultAttributeSetId();
        $data = [
            [
                'attribute_set_name' => 'Laptop/PC',
                'entity_type_id' => $productEntity->getId(),
                'sort_order' => 300
            ],
            [
                'attribute_set_name' => 'Phụ Kiện',
                'entity_type_id' => $productEntity->getId(),
                'sort_order' => 500
            ],
            [
                'attribute_set_name' => 'Điện Thoại',
                'entity_type_id' => $productEntity->getId(),
                'sort_order' => 400
            ]
        ];
        foreach ($data as $attributeSetData) {
            $attributeSet = $this->attributeSetFactory->create();
            $attributeSet->setData($attributeSetData);
            $attributeSet->validate();
            $attributeSet->initFromSkeleton($attributeSetId);
            $attributeSet->save();
        }
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getVersion()
    {
        return '2.0.0';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
