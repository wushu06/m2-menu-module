<?php

namespace Tbb\Menu\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Tbb\Menu\Setup\InstallData\MenuSetupFactory;
use Magento\Eav\Model\Config;

class InstallData implements InstallDataInterface
{
    /**
     * @var menuSetupFactory
     */
    protected $menuSetupFactory;


    /**
     * @var Config
     */
    protected $eavConfig;

    /**
     * @param menuSetupFactory     $menuSetupFactory
     * @param Config               $eavConfig
     */
    public function __construct(
        menuSetupFactory $menuSetupFactory,
        Config $eavConfig
    ) {
        $this->menuSetupFactory = $menuSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $postSetup = $this->menuSetupFactory->create(['setup' => $setup]);
        $postSetup->installEntities();
        $setup->endSetup();
        $this->eavConfig->clear();

    }
}