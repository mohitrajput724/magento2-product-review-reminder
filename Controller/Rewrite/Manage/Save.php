<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Review\Reminder\Controller\Rewrite\Manage;

use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;

class Save extends \Magento\Newsletter\Controller\Manage\Save
{
   
    public function execute()
    {
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->_redirect('customer/account/');
        }

        $customerId = $this->_customerSession->getCustomerId();
        if ($customerId === null) {
            $this->messageManager->addError(__('Something went wrong while saving your subscription.'));
        } else {
            try {
                $customer = $this->customerRepository->getById($customerId);
                $storeId = $this->storeManager->getStore()->getId();
                $customer->setStoreId($storeId);
                
				if($this->getRequest()->getParam('review_subscribed') == 1){
					$customer->setCustomAttribute('review_reminder', "1");
				}else{
				
					$customer->setCustomAttribute('review_reminder', "0");
				}
				
				$this->customerRepository->save($customer);
				
                if ((boolean)$this->getRequest()->getParam('is_subscribed', false)) {
                    $this->subscriberFactory->create()->subscribeCustomerById($customerId);
                    $this->messageManager->addSuccess(__('We saved the subscription.'));
                } else {
                    $this->subscriberFactory->create()->unsubscribeCustomerById($customerId);
                    $this->messageManager->addSuccess(__('We saved the subscription.'));
                }
				
				
				
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Something went wrong while saving your subscription.'));
            }
        }
        $this->_redirect('customer/account/');
    }
}
