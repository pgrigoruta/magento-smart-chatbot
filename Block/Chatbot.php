<?php

namespace Padaviva\Chatbot\Block;

use Magento\Framework\View\Element\Template;

class Chatbot extends Template {
    
    const XML_PATH_ENABLED = 'padavivachatbot/general/enable';
    
    
    public function isEnabled() {
        return $this->_scopeConfig->getValue(self::XML_PATH_ENABLED);    
    }
    
    public function getChatUrl() {
        return $this->_urlBuilder->getUrl('chat/index/index');    
    }
    
    public function getHistoryUrl() {
        return $this->_urlBuilder->getUrl('chat/index/history');
    }
    
    public function getClearHistoryUrl() {
        return $this->_urlBuilder->getUrl('chat/index/clearhistory');
    }
}