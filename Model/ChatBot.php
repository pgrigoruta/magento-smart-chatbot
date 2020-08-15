<?php

namespace Padaviva\Chatbot\Model;

use Padaviva\Chatbot\Model\ChatlogFactory;
use A2Design\AIML\AIML;

class ChatBot {
    
    /** @var AIML */
    protected $aimlClient = null;
    
    /** @var \Magento\Framework\Module\Dir\Reader  */
    protected $moduleReader;
    
    protected $sessionManager;
    
    protected $chatlogFactory;
    
    protected $customerSession;
    
    
    public function __construct( \Magento\Framework\Module\Dir\Reader $moduleReader,
                                 ChatlogFactory $chatlogFactory,
                                 \Magento\Customer\Model\Session $customerSession,
                                 \Magento\Framework\Session\SessionManager $sessionManager)
    {
        $this->moduleReader = $moduleReader;
        $this->chatlogFactory = $chatlogFactory;
        $this->sessionManager = $sessionManager;
        $this->customerSession = $customerSession;
    }

    protected function initialize() {
        if(is_null($this->aimlClient)) {
            $aimlFilePath = $this->moduleReader->getModuleDir(\Magento\Framework\Module\Dir::MODULE_ETC_DIR,'Padaviva_Chatbot');
            $aimlFilePath.='/aiml/basic.xml';
            
            $this->aimlClient = new AIML();
            $this->aimlClient->addDict($aimlFilePath);
            
        }
    }

    public function getResponse($message) {
        $this->initialize();
        
        $message = strtolower($message);
        
        return $this->aimlClient->getAnswer($message);
    }
    
    public function logQuestion($message) {
        $this->logMessage($message,'q');   
    }
    
    public function logAnswer($message) {
        $this->logMessage($message,'a');
    }
    
    private function logMessage($message, $type) {
        $sessionId = $this->sessionManager->getSessionId();

        $chatLog = $this->chatlogFactory->create();
        if($this->customerSession->isLoggedIn()) {
            $chatLog->setCustomerId($this->customerSession->getCustomer()->getId());
        }
        $chatLog->setSessionId($sessionId);
        $chatLog->setMessage($message);
        $chatLog->setCreatedAt(gmdate('Y-m-d H:i:s'));
        $chatLog->setUpdatedAt(gmdate('Y-m-d H:i:s'));
        $chatLog->setType($type);
        
        $chatLog->save();
    }
    
    
}