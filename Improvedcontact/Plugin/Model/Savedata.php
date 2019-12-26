<?php

namespace Sapiha\Improvedcontact\Plugin\Model;

use Magento\Contact\Model\MailInterface;
use Psr\Log\LoggerInterface;
use Sapiha\Improvedcontact\Api\ContactRepositoryInterface;
use Sapiha\Improvedcontact\Model\ContactFactory;

/**
 * Plugin for Magento\Contact\Model\Mail
 */
class Savedata
{
    /** @var LoggerInterface  */
    private $logger;

    /** @var ContactFactory  */
    private $contactFactory;

    /** @var ContactRepositoryInterface  */
    private $contactRepository;

    /**
     * Savedata constructor.
     *
     * @param LoggerInterface $logger
     * @param ContactRepositoryInterface $contactRepository
     * @param ContactFactory $contactFactory
     */
    public function __construct(
        LoggerInterface $logger,
        ContactRepositoryInterface $contactRepository,
        ContactFactory $contactFactory
    ) {
        $this->logger = $logger;
        $this->contactFactory = $contactFactory;
        $this->contactRepository = $contactRepository;
    }

    /**
     * Save contact data to db
     *
     * @param $replyTo
     * @param array $variables
     * @return array
     */
    public function beforeSend(MailInterface $subject, $replyTo, array $variables)
    {
        $data = $variables['data'];
        $model = $this->contactFactory->create();
        $model->setEmail($data->getEmail());
        $model->setPhone($data->getTelephone());
        $model->setMessage($data->getComment());
        $model->setName($data->getName());
        try {
            $this->contactRepository->save($model);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
        }

        return [$replyTo, $variables];
    }
}
