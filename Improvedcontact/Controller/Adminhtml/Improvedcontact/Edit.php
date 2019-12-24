<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Controller\Adminhtml\Improvedcontact;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Sapiha\Improvedcontact\Model\ContactRepository;

/**
 * Class for edit entity action
 */
class Edit extends Action
{
    const ADMIN_RESOURCE = 'Sapiha_Improvedcontact::contact';

    /** @var ContactRepository  */
    private $contactRepository;

    /** @var PageFactory  */
    private $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param ContactRepository $contactRepository
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        ContactRepository $contactRepository,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);

        $this->contactRepository = $contactRepository;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $contactId = (int)$this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($contactId !== 0) {
            $contact = null;
            try {
                $this->contactRepository->getById($contactId);
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage(__('Cannot load entity'));
                $resultRedirect->setPath('*/*/');
                return $resultRedirect;
            }
            $resultPage = $this->resultPageFactory->create();
            $resultPage->setActiveMenu('Sapiha_Improvedcontact::improvedcontact');

            return $resultPage;
        } else {
            $this->messageManager->addErrorMessage('Required id parameter missing');

            return $resultRedirect->setPath('*/*/');
        }
    }
}
