<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MageStore\Marketplace\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Customer\Setup\CustomerSetupFactory;

/**
 * Class AddAttributeSets
 * @package MageStore\Marketplace\Setup\Patch\Data
 */
class AddCustomerVendorAttribute implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * InitializeAuthRoles constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param Config $eavConfig
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        Config $eavConfig
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $attributeDataArray = [
            [
                'attribute_code' => 'is_seller',
                'attribute_data' => [
                    'type' => 'int',
                    'label' => 'Is Seller',
                    'input' => 'select',
                    'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                    'default' => '0',
                    'required' => false,
                    'visible' => true,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => true,
                ]
            ],
            [
                'attribute_code' => 'shop_name',
                'attribute_data' => [
                    'type' => 'varchar',
                    'label' => 'Seller Shop Name',
                    'input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => true,
                ]
            ],
            [
                'attribute_code' => 'seller_picture',
                'attribute_data' => [
                    'type' => 'varchar',
                    'label' => 'Seller Profile Picture',
                    'input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => true,
                ]
            ],
            [
                'attribute_code' => 'seller_description',
                'attribute_data' => [
                    'type' => 'varchar',
                    'label' => 'Seller Profile Description',
                    'input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => true,
                ]
            ],
            [
                'attribute_code' => 'seller_address',
                'attribute_data' => [
                    'type' => 'varchar',
                    'label' => 'Seller Profile Address',
                    'input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => true,
                ]
            ]
        ];
        foreach ($attributeDataArray as $attributeArray) {
            $customerSetup->addAttribute(
                Customer::ENTITY,
                $attributeArray['attribute_code'],
                $attributeArray['attribute_data'],
            );
            $sellerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', $attributeArray['attribute_code']);
            $sellerAttribute->setData(
                'used_in_forms',
                ['adminhtml_customer', 'customer_account_create']
            );
            $sellerAttribute->save();
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
