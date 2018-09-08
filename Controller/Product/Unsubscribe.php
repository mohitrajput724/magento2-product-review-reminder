<?php
namespace Review\Reminder\Controller\Product;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory; 
use Magento\Customer\Api\CustomerRepositoryInterface;

class Unsubscribe extends \Magento\Framework\App\Action\Action
{
	
	protected $_storeManager;
	protected $_objectManager;	 
	protected $_messageManager;
	protected $_reviewFactory;
	protected $_ratingFactory;	
	protected $_customerFactory;
	protected $customerRepository;
protected $responseFactory;
 protected $_url;	
		
    public function __construct(
        \Magento\Framework\App\Action\Context $context,  
        \Magento\Store\Model\StoreManagerInterface $storeManager,  
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Framework\Message\ManagerInterface $messageManager,
		\Magento\Customer\Model\Customer $customerFactory,
		CustomerRepositoryInterface $customerRepository,
  \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\ResponseFactory $responseFactory,		
		array $data = []
        
    )
    {       
		parent::__construct($context, $data);
		$this->_storeManager = $storeManager; 
		$this->_objectManager = $objectManager;
		$this->_messageManager = $messageManager;
        $this->_customerFactory = $customerFactory;
		$this->customerRepository = $customerRepository;
$this->_url = $url;
        $this->responseFactory = $responseFactory;		
        
    }
	
	
	public function execute(){
		
		
		
		$customer_id = (int)$this->getRequest()->getParam('id');
		$customer = $this->customerRepository->getById($customer_id);
		try {
			//$customer->setReviewReminder(0);
			//$customer->setData('review_reminder',"0");
			 $customer->setCustomAttribute('review_reminder', "0");
			$this->customerRepository->save($customer);
			$this->_messageManager->addSuccess(__('You have been unsubscribe from review subscription.'));
			$customerBeforeAuthUrl = $this->_url->getUrl('/home/');
			
			
			$resultRedirect = $this->resultRedirectFactory->create();
				$resultRedirect->setPath('/home/');
				return $resultRedirect;
			
		}
		
		catch (\Exception $e) {
						
						
						$this->_messageManager->addError(__('We can\'t unsubscribe from review right now.'));
						$resultRedirect = $this->resultRedirectFactory->create();
						$resultRedirect->setPath('*/*/');
						return $resultRedirect;

                        

        } 
	}
}