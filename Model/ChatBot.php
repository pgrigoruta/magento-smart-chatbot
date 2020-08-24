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
    
    protected $chatUtils;
    
    protected $debug = false;
    
    
    public function __construct( \Magento\Framework\Module\Dir\Reader $moduleReader,
                                 Utils $chatUtils,
                                 ChatlogFactory $chatlogFactory,
                                 \Magento\Customer\Model\Session $customerSession,
                                 \Magento\Framework\Session\SessionManager $sessionManager)
    {
        $this->moduleReader = $moduleReader;
        $this->chatlogFactory = $chatlogFactory;
        $this->chatUtils = $chatUtils;
        $this->sessionManager = $sessionManager;
        $this->customerSession = $customerSession;
    }

    

    public function getResponse($message) {
        $this->initialize();
        
        $message = $this->chatUtils->normalize($message);
        
        $response = AimlParser::Parse($message);
        
        $response = $this->chatUtils->parseTags($response);
        
        return $response;
    }
    
    public function getHistory() {
        $messages = $this->sessionManager->getChatMessages();
        if(!$messages) $messages = [];
        return $messages;
    }

    public function clearHistory() {
        $this->sessionManager->setChatMessages([]);
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
    
    public function setDebug($debug = true) {
        $this->debug = $debug;
    } 
    public function isDebug() {
        return $this->debug;
    }
    
    
}