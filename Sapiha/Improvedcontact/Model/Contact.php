<?php

namespace Sapiha\Improvedcontact\Model;

use Magento\Framework\Model\AbstractModel;
use Sapiha\Improvedcontact\Api\Data\ContactInterface;
use Sapiha\Improvedcontact\Model\ResourceModel\Contact as ContactResource;

class Contact extends AbstractModel implements ContactInterface
{
    private const EMAIL = 'email';
    private const MESSAGE = 'message';
    private const PHONE = 'phone';
    private const IS_REPLIED = 'is_replied';
    private const NAME = 'name';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ContactResource::class);
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_getData(self::EMAIL);
    }

    /**
     * Set email
     *
     * @param string $email
     * @return void
     */
    public function setEmail(string $email)
    {
        $this->setData(self::EMAIL, $email);
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->_getData(self::MESSAGE);
    }

    /**
     * Set message
     *
     * @param string $message
     * @return void
     */
    public function setMessage(string $message)
    {
        $this->setData(self::MESSAGE, $message);
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->_getData(self::PHONE);
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return void
     */
    public function setPhone(string $phone)
    {
        $this->setData(self::PHONE, $phone);
    }

    /**
     * Set id
     *
     * @return int
     */
    public function getId()
    {
        return $this->_getData('id');
    }

    /**
     * Get id
     *
     * @param int $id
     * @return AbstractModel|void
     */
    public function setId($id)
    {
        $this->setData('id', $id);
    }

    public function getIsReplied()
    {
        return $this->_getData(self::IS_REPLIED);
    }

    /**
     * Set is replied
     *
     * @param bool $isReplied
     */
    public function setIsReplied(bool $isReplied)
    {
        $this->setData(self::IS_REPLIED, $isReplied);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    /**
     * Set name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->setData(self::NAME, $name);
    }
}
