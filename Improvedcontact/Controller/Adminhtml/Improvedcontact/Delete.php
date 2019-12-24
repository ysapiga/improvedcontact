<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Controller\Adminhtml\Improvedcontact;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Sapiha\Improvedcontact\Model\ContactRepository;

/**
 * Class represent delete contact action
 */
class Delete extends Action
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
        $contactId = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $this->contactRepository->deleteById($contactId);
            $this->messageManager->addSuccess(__('The contact message was successfully deleted.'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Cannot delete entity'));

            $resultRedirect->setPath('*/*/edit/', ['id' => $this->_getUrlRewrite()->getId()]);
        }

        $resultRedirect->setPath('adminhtml/*/');

        return $resultRedirect;
    }
}
