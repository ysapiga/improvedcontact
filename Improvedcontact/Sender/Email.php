<?php
declare(strict_types=1);

namespace Sapiha\Improvedcontact\Sender;

use Magento\Framework\App\Area as Area;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Api\Data\StoreInterface as StoreInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class represent logic to send email to customer
 */
class Email
{
    private const XML_PATH_EMAIL_TEMPLATE_FIELD = 'improvedcontact/improvedcontact_email/email_template_field_id';
    private const XML_PATH_TO_SENDER = 'improvedcontact/improvedcontact_email/identity';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var StoreManagerInterface */
    private $storeManager;

    /** @var StateInterface */
    private $inlineTranslation;

    /** @var TransportBuilder */
    private $transportBuilder;

    /** @var string */
    private $temp_id;

    /** @var SenderResolverInterface */
    private $senderResolver;

    /**
     * Email constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param SenderResolverInterface $senderResolver
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        SenderResolverInterface $senderResolver
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->senderResolver = $senderResolver;
    }

    /** @var array */
    private $requiredParams = [
        'customer_email',
        'message_to_customer',
    ];

    /**
     * Send Email
     *
     * @param array $data
     * @return void
     */
    public function sendMail(array $data): void
    {
        $this->validateParams($data);

        $receiverInfo = ['name' => $data['customer_name'], 'email' => $data['customer_email']];
        $senderInfo = $this->getSender();
        $emailTempVariables['message'] = $data['message_to_customer'];
        $emailTempVariables['customer'] = $data['customer_name'];

        $this->send($emailTempVariables, $senderInfo, $receiverInfo);
    }

    /**
     * Validate parameters
     *
     * @param array $params
     * @throws \Exception if required parameter invalid
     */
    private function validateParams(array $params): void
    {
        foreach ($this->requiredParams as $param) {
            if (!array_key_exists($param, $params) || $params[$param] == '') {
                throw new \Exception('Required params misssed');
            }
        }
    }

    /**
     * Return store configuration value of your template field that which id you set for template
     *
     * @param string $path
     * @param int $storeId
     * @return mixed
     */
    private function getConfigValue(string $path, int $storeId)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Retreive sender information from config
     *
     * @return array
     */
    private function getSender(): array
    {
        return $this->senderResolver->resolve(
            $this->getConfigValue(self::XML_PATH_TO_SENDER, (int)$this->getStore()->getId())
        );
    }

    /**
     * Return store
     *
     * @return StoreInterface
     */
    private function getStore(): StoreInterface
    {
        return $this->storeManager->getStore();
    }

    /**
     * Return template id according to store
     *
     * @return string
     */
    private function getTemplateId(): string
    {
        return $this->getConfigValue(self::XML_PATH_EMAIL_TEMPLATE_FIELD, (int)$this->getStore()->getStoreId());
    }

    /**
     * Generate template
     *
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     * @return void
     */
    private function generateTemplate(array $emailTemplateVariables, array $senderInfo, array $receiverInfo): void
    {
        $this->transportBuilder->setTemplateIdentifier($this->getTemplateId())
            ->setTemplateOptions(
                [
                    'area' => Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId(),
                ]
            )
            ->setTemplateVars($emailTemplateVariables)
            ->setFrom($senderInfo)
            ->addTo($receiverInfo['email'], $receiverInfo['name']);
    }

    /**
     * Send message
     *
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     * @return void
     */
    private function send(array $emailTemplateVariables, array $senderInfo, array $receiverInfo): void
    {
        $this->inlineTranslation->suspend();

        try {
            $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();
        } finally {
            $this->inlineTranslation->resume();
        }
    }
}
