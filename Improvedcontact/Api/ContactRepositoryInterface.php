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
     * @return ContactInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): ContactInterface;

    /**
     * Save entity
     *
     * @param ContactInterface $contact
     * @return ContactInterface
     */
    public function save(ContactInterface $contact): ContactInterface;

    /**
     * Delete entity
     *
     * @param ContactInterface $contact
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
}
