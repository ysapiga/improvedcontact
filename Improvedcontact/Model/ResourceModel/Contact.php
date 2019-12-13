<?php

namespace Sapiha\Improvedcontact\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Contact
 * @package Sapiha\Improvedcontact\Model\ResourceModel
 */
class Contact extends AbstractDb
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('customer_feedback', 'id');
    }
}
