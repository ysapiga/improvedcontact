<?php

namespace Sapiha\Improvedcontact\Controller\Adminhtml\Improvedcontact;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Sapiha\Improvedcontact\Helper\Email;

class Reply extends Action
{
    const ADMIN_RESOURCE = 'Sapiha_Improvedcontact::contact';

    /**
     * Reply constructor.
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param Email $sender
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        Email $sender
    ) {
        $this->sender = $sender;
        $this->resultJsonFactory = $resultJsonFactory;

        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $params = $this->getRequest()->getParams();

            try {
                $this->sender->sendMail($params);
            } catch (\Exception $e) {
                $result->setData([
                    'error' => 1,
                    'message' => $e->getMessage(),
                ]);
            }

        return $result;
    }
}
