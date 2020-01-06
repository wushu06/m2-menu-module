<?php
namespace Tbb\Menu\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Tbb\Menu\Setup\InstallData\MenuSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    public function __construct(menuSetupFactory $menuSetupFactory, EavSetupFactory $eavSetupFactory)
    {
        $this->menuSetupFactory = $menuSetupFactory;
        $this->eavSetupFactory  = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.6') < 0) {
            /** @var \Tbb\Menu\Setup\InstallData\MenuSetup $postSetup */
            $postSetup = $this->menuSetupFactory->create(['setup' => $setup]);
            foreach ($this->getAttributes() as $code => $data) {
                $postSetup->addAttribute('tbb_menu', $code, $data);
            }
        }

        $setup->endSetup();
    }

    /**
     * @return array
     */
    private function getAttributes()
    {
        return [
            'class_name' => [
                'type'   => 'varchar',
                'label'  => 'Class Name',
                'input'  => 'text',
                'global' => ScopedAttributeInterface::SCOPE_STORE,
            ],
            'visibility' => [
                'type'   => 'int',
                'label'  => 'Visibility',
                'input'  => 'select',
                'source' => 'Tbb\Menu\Model\Menu\Attribute\Source\Visibility',
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
            ],
        ];
    }
}
