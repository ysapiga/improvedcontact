<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Controller\Adminhtml\Improvedcontact;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Sapiha\Improvedcontact\Model\ContactRepository;

/**
 * Class represent save entity action
 */
class Save extends Action
{
    const ADMIN_RESOURCE = 'Sapiha_Improvedcontact::contact';

    /** @var ContactRepository  */
    private $contactRepository;

    /**
     * @param Action\Context $context
     * @param ContactRepository $contactRepository
     */
    public function __construct(Action\Context $context, ContactRepository $contactRepository)
    {
        parent::__construct($context);

        $this->contactRepository = $contactRepository;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $contactId = (int)$this->getRequest()->getParam('id');
        $isReplied = $this->getRequest()->getParam('is_replied');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($contactId !== 0 && $isReplied !== null) {

            try {
                $contact = $this->contactRepository->getById((int)$contactId);
                $contact->setIsReplied((bool)$isReplied);
                $this->contactRepository->save($contact);
                $this->messageManager->addSuccessMessage(__('The feedback info was successfully updated.'));
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage(__('Cannot load entity'));
            }

            return $resultRedirect->setPath('*/*/edit', ['id' => $contactId]);
        } else {
            $this->messageManager->addErrorMessage(__('Something went wrong.'));
            return $resultRedirect->setPath('*/*/edit', ['id' => $contactId]);
        }
    }
}
