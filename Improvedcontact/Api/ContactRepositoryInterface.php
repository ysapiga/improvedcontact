<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Sapiha\Improvedcontact\Api\Data\ContactInterface;

/**
 * Service contract interface for entity repository
 */
interface ContactRepositoryInterface
{
    /**
     * Get entity by id
     *
     * @param int $id
     * @return \Sapiha\Improvedcontact\Api\Data\ContactInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): ContactInterface;

    /**
     * Save entity
     *
     * @param \Sapiha\Improvedcontact\Api\Data\ContactInterface $contact
     * @return \Sapiha\Improvedcontact\Api\Data\ContactInterface
     */
    public function save(ContactInterface $contact): ContactInterface;

    /**
     * Delete entity
     *
     * @param \Sapiha\Improvedcontact\Api\Data\ContactInterface $contact
     * @return void
     */
    public function delete(ContactInterface $contact): void;

    /**
     * Delete entity by id
     *
     * @param int $id
     * @return void
     */
    public function deleteById(int $id): void;

    /**
     * @param int $id
     * @param bool $isReplied
     * @return bool
     */
    public function updateIsReplied(int $id, bool $isReplied): bool;
}
