<?php

namespace Tbb\Menu\Controller\Adminhtml\Category;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Edit extends \Magento\Backend\App\Action
{

    /**
     * @var \Tbb\Menu\Model\MenuFactory
     */
    protected $modelMenuFactory;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    protected $config;

    /**
     * Edit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Tbb\Menu\Model\MenuFactory $modelMenuFactory
     * @param JsonFactory $resultJsonFactory
     * @param \Magento\Framework\App\Config\Storage\WriterInterface $config
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Tbb\Menu\Model\MenuFactory $modelMenuFactory,
        JsonFactory $resultJsonFactory,
        \Magento\Framework\App\Config\Storage\WriterInterface $config,
        \Magento\Store\Model\StoreManagerInterface $storeManager
        ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->storeManager = $storeManager;
        $this->modelMenuFactory = $modelMenuFactory;
        $this->config = $config;
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {


        $resultEcho = $this->resultJsonFactory->create();


        return $resultEcho->setData(['edit']);
    }
}
