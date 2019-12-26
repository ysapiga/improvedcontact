<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Sapiha\Improvedcontact\Api\ContactRepositoryInterface;
use Sapiha\Improvedcontact\Api\Data\ContactInterface;
use Sapiha\Improvedcontact\Model\ResourceModel\Contact as ContactResource;
use Sapiha\Improvedcontact\Model\ResourceModel\ContactFactory as ContactResourceFactory;

/**
 * Repository class for contact entity
 */
class ContactRepository implements ContactRepositoryInterface
{
    /** @var ContactFactory */
    private $contactFactory;

    /** @var ContactResource */
    private $contactResourceFactory;

    /**
     * @param ContactResourceFactory $contactResourceFactory
     * @param ContactFactory $contactFactory
     */
    public function __construct(ContactResourceFactory $contactResourceFactory, ContactFactory $contactFactory)
    {
        $this->contactFactory = $contactFactory;
        $this->contactResourceFactory = $contactResourceFactory;
    }

    /**
     * @inheritdoc
     */
    public function getById(int $id): ContactInterface
    {
        /** @var ContactInterface $contact */
        $contact = $this->contactFactory->create();
        $contact->load($id);
        if (!$contact->getId()) {
            throw NoSuchEntityException::singleField('id', $id);
        }

        return $contact;
    }

    /**
     * @inheritdoc
     */
    public function save(ContactInterface $contact): ContactInterface
    {
        /** @var ContactResource $contactResource */
        $contactResource = $this->contactResourceFactory->create();

        try {
            $contactResource->save($contact);
        } catch (\Exception $e) {
            throw new CouldNotSaveException('The contact ca not be saved');
        }

        return $this->getById((int)$contact->getId());
    }

    /**
     * @inheritdoc
     */
    public function delete(ContactInterface $contact): void
    {
        /** @var ContactResource $contactResource */
        $contactResource = $this->contactResourceFactory->create();
        try {
            $contactResource->delete($contact);
        } catch (\Exception $e) {
            throw new StateException(__('Cannot delete category with id %1', $contact->getId()), $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function deleteById(int $id): void
    {
        $contact = $this->getById($id);
        $this->delete($contact);
    }

    /**
     * @inheritdoc
     */
    public function updateIsReplied(int $id, bool $isReplied): bool
    {
        $contact = $this->getById($id);
        $result = true;

        try {
            $contact->setIsReplied($isReplied);
            $this->save($contact);
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }
}
