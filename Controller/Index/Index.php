<?php

namespace Padaviva\Chatbot\Controller\Index;

use Magento\Framework\App\Action\Context;
use Padaviva\Chatbot\Model\ChatBot;

class Index extends \Magento\Framework\App\Action\Action {


    protected $resultJsonFactory;
    
    protected $chatBot;
    
    public function __construct(\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
                                ChatBot $chatBot,
                                Context $context)
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->chatBot = $chatBot;
        
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        
        $message = $this->getRequest()->getParam('msg');
        
        $this->chatBot->logQuestion($message);
        $answer = $this->chatBot->getResponse($message);
        $this->chatBot->logAnswer($answer);
        
        $response = ['response' => $answer];
        $resultJson->setData($response);

        return $resultJson;
    }
}