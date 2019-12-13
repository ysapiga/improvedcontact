<?php

namespace Sapiha\Improvedcontact\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Sapiha\Improvedcontact\Api\ContactRepositoryInterface;
use Sapiha\Improvedcontact\Api\Data\ContactInterface;

class ContactRepository implements ContactRepositoryInterface
{
    /** @var ContactFactory */
    private $contactFactory;

    /**
     * ContactRepository constructor.
     *
     * @param \Sapiha\Improvedcontact\Model\ContactFactory $contactFactory
     */
    public function __construct(
        ContactFactory $contactFactory
    ) {
        $this->contactFactory = $contactFactory;
    }

    /**
     * Load entity by id
     *
     * @param int $id
     * @return ContactInterface|Contact
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        /** @var Contact $contact */
        $contact = $this->contactFactory->create();
        $contact->load($id);
        if (!$contact->getId()) {
            throw NoSuchEntityException::singleField('id', $id);
        }

        return $contact;
    }

    /**
     * Save entity
     *
     * @param ContactInterface $contact
     * @return ContactRepositoryInterface|void
     */
    public function save(ContactInterface $contact)
    {
        /** @var Contact */
        $contact->save();
    }

    /**
     * Delete entity
     *
     * @param ContactInterface $contact
     */
    public function delete(ContactInterface $contact)
    {
        try {
            $contact->delete();
        } catch (\Exception $e) {
            throw new StateException(
                __('Cannot delete category with id %1', $contact->getId()), $e);
        }
    }
}
