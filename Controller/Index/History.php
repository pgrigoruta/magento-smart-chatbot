<?php

namespace Padaviva\Chatbot\Controller\Index;

use Magento\Framework\App\Action\Context;
use Padaviva\Chatbot\Model\ChatBot;

class History extends \Magento\Framework\App\Action\Action
{
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
        
        $messages = $this->chatBot->getHistory();
        
        $resultJson->setData($messages);

        return $resultJson;
    }
}