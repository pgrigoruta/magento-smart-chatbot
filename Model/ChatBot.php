<?php

namespace Padaviva\Chatbot\Model;

use Padaviva\Chatbot\Model\ChatlogFactory;

class ChatBot {
    
    /** @var AIML */
    protected $aimlClient = null;
    
    /** @var \Magento\Framework\Module\Dir\Reader  */
    protected $moduleReader;
    
    protected $sessionManager;
    
    
    protected $customerSession;
    
    protected $chatLogCollectionFactory;
    
    
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

    

    public function getResponse($message) {
        $this->initialize();
        
        $message = strtolower($message);
        
        return AimlParser::Parse($message);
    }
    
    public function getHistory() {
        $messages = $this->sessionManager->getChatMessages();
        if(!$messages) $messages = [];
        return $messages;
    }

    protected function initialize() 
    {
        if(is_null($this->aimlClient)) {
            
            $aimlFilePath = $this->moduleReader->getModuleDir(\Magento\Framework\Module\Dir::MODULE_ETC_DIR,'Padaviva_Chatbot');
            $aimlFilePath.='/aiml/basic.xml';

            AimlParser::setAimlPath($aimlFilePath);

        }
    }
    
    public function logQuestion($message) {
        $this->logMessage($message,'q');   
    }
    
    public function logAnswer($message) {
        $this->logMessage($message,'a');
    }
    
    private function logMessage($message, $type) {
        
        $messages = $this->sessionManager->getChatMessages();
        if(!is_array($messages)) {
            $messages = [];
        }
        $messages[]=['message'=>$message,'type'=>$type];
        
        $this->sessionManager->setChatMessages($messages);
    }
    
    
}