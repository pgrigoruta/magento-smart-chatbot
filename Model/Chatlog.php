<?php

namespace Padaviva\Chatbot\Model;

class Chatlog extends \Magento\Framework\Model\AbstractModel
{
    protected $_eventPrefix = 'padaviva_chatlog';
    
    protected function _construct()
    {
        $this->_init('Padaviva\Chatbot\Model\ResourceModel\Chatlog');
    }
}