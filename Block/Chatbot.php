<?php

namespace Padaviva\Chatbot\Block;

use Magento\Framework\View\Element\Template;

class Chatbot extends Template {
    
    const XML_PATH_ENABLED = 'padavivachatbot/general/enable';
    
    public function isEnabled() {
        return $this->_scopeConfig->getValue(self::XML_PATH_ENABLED);    
    }
}