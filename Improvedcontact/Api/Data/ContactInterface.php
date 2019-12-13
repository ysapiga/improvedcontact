<?php

namespace Sapiha\Improvedcontact\Api\Data;

/**
 * Interface ContactInterface
 * @package Sapiha\Improvedcontact\Api\Data
 */
interface ContactInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return void
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return void
     */
    public function setEmail(string $email);

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @param string $message
     * @return void
     */
    public function setMessage(string $message);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $phone
     * @return void
     */
    public  function setPhone(string $phone);

    /**
     * @return bool
     */
    public function getIsReplied();

    /**
     * @param bool $isReplied
     * @return void
     */
    public function setIsReplied(bool $isReplied);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name);
}
