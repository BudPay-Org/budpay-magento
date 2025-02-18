<?php
namespace Budpay\Payment\Controller\Redirect;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Budpay\Payment\Model\Payment;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $payment;
    protected $resultRedirectFactory;

    public function __construct(
        Context $context,
        Payment $payment,
        RedirectFactory $resultRedirectFactory
    ) {
        parent::__construct($context);
        $this->payment = $payment;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    public function execute()
    {
        $checkoutUrl = $this->payment->startTransaction();
        if ($checkoutUrl) {
            return $this->resultRedirectFactory->create()->setUrl($checkoutUrl);
        }
        $this->messageManager->addErrorMessage(__('Unable to initiate Budpay checkout.'));
        return $this->_redirect('checkout/cart');
    }
}
