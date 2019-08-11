<?php

namespace Sapiha\Improvedcontact\Controller\Adminhtml\Improvedcontact;

use Magento\Backend\App\Action;
use Sapiha\Improvedcontact\Model\ContactRepository;

/**
 * Class Delete
 * @package Sapiha\Improvedcontact\Controller\Adminhtml\Improvedcontact
 */
class Delete extends Action
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
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $contactId = $this->getRequest()->getParam('id');

        try {
            $contact = $this->contactRepository->getById((int)$contactId);
            $this->contactRepository->delete($contact);
            $this->messageManager->addSuccess(__('The contact message was successfully deleted.'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Cannot delete entity'));
            $this->_redirect('adminhtml/*/edit/', ['id' => $this->_getUrlRewrite()->getId()]);
            return;
        }

        $this->_redirect('adminhtml/*/');
    }
}
