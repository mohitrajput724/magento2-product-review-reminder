<?php
namespace Review\Reminder\Controller\Product;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory; 
use Magento\Review\Model\Review;

class Post extends \Magento\Framework\App\Action\Action
{
	
	protected $_storeManager;
	protected $_objectManager;	 
	protected $_productloader;
	protected $_messageManager;
	protected $_reviewFactory;
protected $_ratingFactory;	
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,  
        \Magento\Store\Model\StoreManagerInterface $storeManager,  
		\Magento\Catalog\Model\ProductFactory $_productloader,
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Framework\Message\ManagerInterface $messageManager,
		\Magento\Review\Model\ReviewFactory $reviewFactory,
\Magento\Review\Model\RatingFactory $ratingFactory,		
		array $data = []
        
    )
    {       
		parent::__construct($context, $data);
		$this->_storeManager = $storeManager; 
		$this->_productloader = $_productloader;
		$this->_objectManager = $objectManager;
		$this->_messageManager = $messageManager;
        $this->_reviewFactory = $reviewFactory;	
$this->_ratingFactory = $ratingFactory;		
        
    }
	
	
	public function execute(){
		
		$data = $this->getRequest()->getPostValue();
		$rating = $data['ratings'];
        $product_id = (int)$this->getRequest()->getParam('id');
        $customer_id = $data['customer_id'];
		$store_id = $this->_storeManager->getStore()->getStoreId();
		$product = $this->_productloader->create()->load($product_id);		
		if (!empty($data)) {
     
                $review = $this->_reviewFactory->create()
                            ->setData($data);
                $review->unsetData('review_id');

                $validate = $review->validate();
                if ($validate === true) {
                    try {
                        $review->setEntityId($review->getEntityIdByCode(Review::ENTITY_PRODUCT_CODE))
                            ->setEntityPkValue($product->getId())
                            ->setStatusId(Review::STATUS_PENDING)
                            ->setCustomerId($customer_id)
                            ->setStoreId($store_id)
                            ->setStores([$store_id])
                            ->save();

                        foreach ($rating as $ratingId => $optionId) {
                            $this->_ratingFactory->create()
                                ->setRatingId($ratingId)
                                ->setReviewId($review->getId())
                                ->setCustomerId($customer_id)
                                ->addOptionVote($optionId, $product->getId());
                        }

                        $review->aggregate();
						$this->_messageManager->addSuccess(__('You submitted your review for moderation.'));
						$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
						$resultRedirect->setUrl($this->_redirect->getRefererUrl());
						return $resultRedirect;
                       
                    } catch (\Exception $e) {
						//$this->reviewSession->setFormData($data);
						print_r( $e->getmessage());
						die();
						$this->_messageManager->addError(__('We can\'t post your review right now.'));
						$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
						$resultRedirect->setUrl($this->_redirect->getRefererUrl());
						return $resultRedirect;

                        

                    }
                } 
            }
	}
}