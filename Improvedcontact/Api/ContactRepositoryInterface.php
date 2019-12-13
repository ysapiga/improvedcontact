<?php

namespace Sapiha\Improvedcontact\Api;

use Sapiha\Improvedcontact\Api\Data\ContactInterface;

/**
 * Interface ContactRepositoryInterface
 * @package Sapiha\Improvedcontact\Api
 */
interface ContactRepositoryInterface
{
    /**
     * @param int $id
     * @return \Sapiha\Improvedcontact\Api\Data\ContactInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param\Sapiha\Improvedcontact\Api\Data\ContactInterface $contact
     * @return \Sapiha\Improvedcontact\Api\ContactRepositoryInterface
     */
    public function save(ContactInterface $contact);

    /**
     * @param \Sapiha\Improvedcontact\Api\Data\ContactInterface $contact
     * @return void
     */
    public function delete(ContactInterface $contact);
}
