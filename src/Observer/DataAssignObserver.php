<?php 

declare(strict_types=1);

namespace Budpay\Payments\Observer;

use Magento\Framework\DataObject;
use Magento\Framework\DataObjectFactory;
use Magento\Framework\Event\Observer;
use Magento\Payment\Observer\AbstractDataAssignObserver;

class DataAssignObserver extends AbstractDataAssignObserver {
    private const CUSTOMER_EMAIL = 'customer_email';
    private const CUSTOMER_PHONE = 'phone';
    private const TRANSACTION_REFERENCE = 'txnref';
    private const FIRSTNAME = 'firstname';
    private const LASTNAME = 'lastname';
    private const KEY_ADDITIONAL_DETAILS = 'additional_details';

    public function __construct(
        private readonly DataObjectFactory $dataObjectFactory
    ) {}

    public function execute(Observer $observer) {
        $additionalData = $this->readAdditonalData($observer);
        $paymentInformation = $this->readPaymentModelArgument($observer);
        $paymentInformation->setData(self::CUSTOMER_EMAIL, 'olaobajua@gmail.com' );
    }

    public function readAdditonalData(Observer $observer): DataObject
    {
        $data = $this->readDataArgument($observer);
        $additionalData = $data->getData(self::KEY_ADDITIONAL_DETAILS);
        if(!$additionalData) {
            throw new LogicException("Wrong argument type provided. ");
        }

        return $this->dataObjectFactory->create(['data' => $additionalData ]);
    }
}