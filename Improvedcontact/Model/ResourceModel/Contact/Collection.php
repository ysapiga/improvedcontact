<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Model\ResourceModel\Contact;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Sapiha\Improvedcontact\Model\Contact;
use Sapiha\Improvedcontact\Model\ResourceModel\Contact as ContactResource;

/**
 * Collection class for \Sapiha\Improvedcontact\Model\Contact entity
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
