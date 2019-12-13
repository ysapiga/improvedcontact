<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Resource modelr for \Sapiha\Improvedcontact\Model\Contact entity
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
