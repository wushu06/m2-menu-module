<?php
namespace Tbb\Menu\Setup\InstallData;


use Magento\Eav\Model\Entity\Setup\Context;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class MenuSetup extends EavSetup
{


    /**
     * Init
     *
     * @param ModuleDataSetupInterface $setup
     * @param Context                  $context
     * @param CacheInterface           $cache
     * @param CollectionFactory        $attrGroupCollectionFactory
     */
    public function __construct(
        ModuleDataSetupInterface $setup,
        Context $context,
        CacheInterface $cache,
        CollectionFactory $attrGroupCollectionFactory
    ) {
        parent::__construct($setup, $context, $cache, $attrGroupCollectionFactory);
    }

    /**
     * Default entities and attributes
     *
     * @return array
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function getDefaultEntities()
    {
        return [
            'tbb_menu' => [
                'entity_model' => 'Tbb\Menu\Model\ResourceModel\Menu',
                'table'        => 'tbb_menu_entity',
                'attributes'   => [
                    'type'      => [
                        'type'   => 'static',
                        'label'  => 'Type',
                        'input'  => 'text',
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                    ],
                    'name'      => [
                        'type'   => 'varchar',
                        'label'  => 'Name',
                        'input'  => 'text',
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                    ],

                    'url_key' => [
                        'type'   => 'varchar',
                        'label'  => 'Url Key',
                        'input'  => 'text',
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                    ],
                    'status' => [
                        'type'   => 'int',
                        'label'  => 'Status',
                        'input'  => 'select',
                        'source' => 'Tbb\Menu\Model\Menu\Attribute\Source\Status',
                        'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                    ],
                ],
            ],
        ];
    }
}
