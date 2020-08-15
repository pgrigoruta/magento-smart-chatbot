<?php

namespace Padaviva\Chatbot\Model\ResourceModel\Chatlog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    protected $_idFieldName = 'id';


    protected function _construct()
    {
        $this->_init('Padaviva\Chatbot\Model\Chatlog', 'Padaviva\Chatbot\Model\ResourceModel\Chatlog');
    }
}