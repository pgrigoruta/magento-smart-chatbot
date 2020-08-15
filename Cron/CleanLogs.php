<?php

namespace Padaviva\Chatbot\Cron;

use Magento\Framework\App\Config\ScopeConfigInterface;

class CleanLogs {
    
    const XML_DELETE_NUM_HOURS = 'padavivachatbot/general/clean_logs_after_hours';
    
    protected $collectionFactory;
    
    protected $scopeConfig;
    
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Padaviva\Chatbot\Model\ResourceModel\Chatlog\CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute() {
        $numHours = $this->scopeConfig->getValue(self::XML_DELETE_NUM_HOURS);
        
        $date = gmdate('Y-m-d H:i:s', strtotime("-{$numHours} hour"));
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('created_at', array('lt'=>$date));
        
        foreach($collection as $item) {
            $item->delete();
        }
    }
}