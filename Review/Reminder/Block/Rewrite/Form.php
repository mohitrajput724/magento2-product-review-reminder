<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Review\Reminder\Block\Rewrite;

use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Context;
use Magento\Customer\Model\Url;
use Magento\Review\Model\ResourceModel\Rating\Collection as RatingCollection;

/**
 * Review form block
 *
 * @api
 * @author      Magento Core Team <core@magentocommerce.com>
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 100.0.2
 */
class Form extends \Magento\Review\Block\Form
{
    

   protected function _construct()
    {
		 parent::_construct();

        $this->setAllowWriteReviewFlag(
            $this->httpContext->getValue(Context::CONTEXT_AUTH)
            || $this->_reviewData->getIsGuestAllowToWrite()
        );
        if (!$this->getAllowWriteReviewFlag()) {
            $queryParam = $this->urlEncoder->encode(
                $this->getUrl('*/*/*', ['_current' => true]) . '#review-form'
            );
            $this->setLoginLink(
                $this->getUrl(
                    'customer/account/login/',
                    [Url::REFERER_QUERY_PARAM_NAME => $queryParam]
                )
            );
        }

        $this->setTemplate('Review_Reminder::review/form.phtml');
	}
	
	public function checkCustomerEmail($customer_email){
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerModel = $objectManager->create('Magento\Customer\Model\Customer');
		$customerModel->setWebsiteId(1); 
		$customerModel->loadByEmail($customer_email);
		$userId = $customerModel->getId();
		if($userId){
			return $userId;
		}else{
			return 0;
		}
		
	}
	
	public function getCustomAction(){
		
		return $this->getUrl(
            'reminder/product/post',
            [
                '_secure' => $this->getRequest()->isSecure(),
                'id' => $this->getProductId(),
            ]
        );
	}

    
}
