<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Api\Data;

/**
 * Service contract interface for Contact entity
 */
interface ContactInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return void
     */
    public function setId($id): void;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void;

    /**
     * @return string
     */
    public function getPhone(): string;

    /**
     * @param string $phone
     * @return void
     */
    public function setPhone(string $phone): void;

    /**
     * @return bool
     */
    public function getIsReplied(): bool;

    /**
     * @param bool $isReplied
     * @return void
     */
    public function setIsReplied(bool $isReplied): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;
}
