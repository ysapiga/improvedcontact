<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Controller\Adminhtml\Improvedcontact;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Sapiha\Improvedcontact\Model\ContactRepository;

/**
 * Class for edit entity action
 */
class Edit extends Action
{
    const ADMIN_RESOURCE = 'Sapiha_Improvedcontact::contact';

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
        $this->_view->loadLayout();
        $contactId = (int)$this->getRequest()->getParam('id');
        $this->_setActiveMenu('Sapiha_Improvedcontact::improvedcontact');

        if ($contactId !== 0) {
            $contact = null;
            try {
                $contact = $this->contactRepository->getById((int)$contactId);
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage(__('Cannot load entity'));
                $this->_redirect('adminhtml/*/');
                return;
            }

            $editBlock = $this->_view->getLayout()->createBlock(
                \Sapiha\Improvedcontact\Block\Edit::class,
                'edit.contact',
                ['data' => ['contact' => $contact ?: null]]
            );
            $this->_view->getLayout()->getBlock('adminhtml.block.improvedcontact.reply')
                ->setData('contact', $contact);
            $this->_addContent($editBlock);
            $this->_view->renderLayout();
        } else {
            $this->messageManager->addErrorMessage('Required id parameter missing');
            $this->_redirect('adminhtml/*/');
        }
    }
}
