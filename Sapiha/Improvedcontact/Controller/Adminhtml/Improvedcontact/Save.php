<?php

namespace Sapiha\Improvedcontact\Controller\Adminhtml\Improvedcontact;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Sapiha\Improvedcontact\Model\ContactRepository;

/**
 * Class Save
 * @package Sapiha\Improvedcontact\Controller\Adminhtml\Improvedcontact
 */
class Save extends Action
{
    const ADMIN_RESOURCE = 'Sapiha_Improvedcontact::contact';

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param ContactRepository $contactRepository
     */
    public function __construct(
        Action\Context $context,
        ContactRepository $contactRepository
    ) {
        parent::__construct($context);

        $this->contactRepository = $contactRepository;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $contactId = $this->getRequest()->getParam('id');
        $isReplied = $this->getRequest()->getParam('is_replied');
        if ($contactId && $isReplied !== null) {

            try {
                $contact = $this->contactRepository->getById((int)$contactId);
                $contact->setIsReplied($isReplied);
                $this->contactRepository->save($contact);
                $this->messageManager->addSuccessMessage(__('The contact message was successfully updated.'));
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage(__('Cannot load entity'));
            }

            $this->_redirect('adminhtml/*/');
        } else {
            $this->messageManager->addErrorMessage(__('Something went wrong.'));
            $this->_redirect('adminhtml/*/');
        }
    }
}
