<?php

namespace Padaviva\Chatbot\Controller\Index;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action {


    protected $resultJsonFactory;
    
    public function __construct(\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
                                Context $context)
    {
        $this->resultJsonFactory = $resultJsonFactory;
        
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        
        $response = ['success' => 'true'];
        $resultJson->setData($response);

        return $resultJson;
    }
}