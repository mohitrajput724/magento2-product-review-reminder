<?php
namespace Review\Reminder\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;

class InstallData implements InstallDataInterface
{
	private $eavSetupFactory;

	public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig)
	{
		$this->eavSetupFactory = $eavSetupFactory;
		$this->eavConfig = $eavConfig;
	}

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		$eavSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'review_reminder',
			[
				 'label'                => 'Enable Subscription',
                'input'                 => 'text',
                'required'              => false,
                'sort_order'            => 1000,
                'visible'               => true,
                'system'                => false,
                'is_used_in_grid'       => false,
                'is_visible_in_grid'    => false,
                'is_filterable_in_grid' => false,
                'is_searchable_in_grid' => false,
				
			]
		);
		$review_reminder = $this->eavConfig->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'review_reminder');
		$review_reminder->setData(
			'used_in_forms',
			['adminhtml_customer']
		);
		$review_reminder->save();
		
	}
}
