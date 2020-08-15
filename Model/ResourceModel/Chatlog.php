<?php

namespace Padaviva\Chatbot\Model\ResourceModel;

class Chatlog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('padaviva_chatlog', 'id');
    }
}