<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Review\Reminder\Block\Rewrite;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

/**
 * Customer front  newsletter manage block
 *
 * @api
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 * @since 100.0.2
 */
class Newsletter extends \Magento\Customer\Block\Newsletter
{
    /**
     * @var string
     */
    protected $_template = 'Review_Reminder::form/newsletter.phtml';

  
}
