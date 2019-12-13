<?php

namespace Sapiha\Improvedcontact\Model\ResourceModel\Contact;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Sapiha\Improvedcontact\Model\Contact;
use Sapiha\Improvedcontact\Model\ResourceModel\Contact as ContactResource;

/**
 * Class Collection
 * @package Sapiha\Improvedcontact\Model\ResourceModel\Contact
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Contact::class, ContactResource::class);
    }
}
