<?php

namespace Tbb\Menu\Controller\Adminhtml\Item;

use Magento\Framework\Controller\Result\JsonFactory;
use Tbb\Menu\Api\Data\MenuInterface;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\App\Action
{

    /**
     * @var \Tbb\Menu\Model\MenuItemsFactory
     */
    protected $modelMenuFactory;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
    protected $request;
    protected $formKey;
    protected $menuRepository;
    protected $registry;
    /**
     * Edit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param JsonFactory $resultJsonFactory
     * @param \Tbb\Menu\Model\MenuItemsFactory $modelMenuFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\App\Request\Http $request,
        JsonFactory $resultJsonFactory,
        \Tbb\Menu\Api\Repository\MenuRepositoryInterface $menuRepository,
        Registry $registry,

        \Tbb\Menu\Model\MenuFactory $modelMenuFactory
        ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
        $this->formKey = $formKey;
        $this->request->setParam('form_key', $this->formKey->getFormKey());
        $this->modelMenuFactory = $modelMenuFactory;
        $this->menuRepository = $menuRepository;
        $this->registry = $registry;

    }

    public function initModel()
    {
        $model = $this->menuRepository->create();
        $id = $this->getRequest()->getParam(MenuInterface::ID);

        if ($id && !is_array($id)) {
            $model = $this->menuRepository->get($id);
        }

        $this->registry->register('current_model', $model);

        return $model;
    }
    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $resultEcho = $this->resultJsonFactory->create();
        $id = $this->getRequest()->getParam(MenuInterface::ID);
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();
        if( key_exists('custom_link', $data) && $data['custom_link'] != ''){
            $link = $data['custom_link'];
        }elseif(key_exists('category_link', $data)  && $data['category_link'] != ''){
            $link = $data['category_link'];
        }elseif(key_exists('cms_link', $data)  && $data['cms_link'] != ''){
            $link = $data['cms_link'];
        }else{
            $link = '';
        }
        $type = 'custom_link';
        if(key_exists('urlType', $data)){
            $type = $data['urlType'];
        }

        if( key_exists('delete', $data) &&  $data['delete'] && $data['delete'] != '' ) {
            $model = $this->menuRepository->get($data['delete']);

            if ($model->getId()) {
                $model->delete();

            }
            return $resultEcho->setData($data);
        }


        if($params['type'] == 'edit') {
            if ($params['item_id'] && $params['item_id'] != '') {
                $model = $this->menuRepository->get($params['item_id']);

                if ($model->getId()) {
                    $model->setName($data['name'])
                        ->setStatus($data['status'])
                        ->setClassName($data['class_name'])
                        ->setVisibility($data['visibility'])
                        ->setUrlKey($link)
                        ->setType($type)
                        ->save();

                }
                return $resultEcho->setData($link);
            }

        }
        if($params['type'] == 'load') {
            $blockInstance = $this->_objectManager->get('Tbb\Menu\Block\Adminhtml\Category\Tree');
            return  $resultEcho->setData($blockInstance->getMenuData(false));
        }

        if($params['type'] == 'save') {

            foreach ($params['st'] as $el){


                if(array_key_exists('children', $el)){
                  foreach ($el['children'] as $child){
                      //echo 'chi;d'.$child['id'];
                      $model = $this->menuRepository->get($child['id']);
                      if ($model->getId()) {
                          $model->setParentId($el['id'])->save();

                      }
                      if(array_key_exists('children', $child)){
                          foreach ($child['children'] as $g_child) {
                              $model = $this->menuRepository->get($g_child['id']);
                              if ($model->getId()) {
                                  $model->setParentId($child['id'])->save();

                              }
                          }
                      }

                  }
                }
                $model = $this->menuRepository->get($el['id']);

                if ($model->getId()) {
                    $model->setParentId($el['id'])->save();

                }

            }

            return  $resultEcho->setData($params['st']);


        }
        if ($data) {
            /** @var \Tbb\Menu\Model\Menu $model */
            $model = $this->initModel();



           // $model->addData($data);
            try {
               // $this->menuRepository->save($model);
                $model->setName($data['name'])
                    ->setStatus($data['status'])
                    ->setClassName($data['class_name'])
                    ->setVisibility($data['visibility'])
                    ->setUrlKey($link)
                    ->setType($type)
                    ->save();

                $data['id'] = $model->getId();
                return $resultEcho->setData($data);
            } catch (\Exception $e) {

            }
        } else {

        }


    }
}
