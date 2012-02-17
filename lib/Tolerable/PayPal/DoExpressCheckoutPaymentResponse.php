<?php
namespace Tolerable\PayPal;

class DoExpressCheckoutPaymentResponse extends Response
{
    const TRANSACTION_ID   = 'PAYMENTINFO_0_TRANSACTIONID';
    const TRANSACTION_TYPE = 'PAYMENTINFO_0_TRANSACTIONTYPE';
    const PAYMENT_TYPE     = 'PAYMENTINFO_0_PAYMENTTYPE';
    const ORDER_TIME       = 'PAYMENTINFO_0_ORDERTIME';
    const AMOUNT           = 'PAYMENTINFO_0_AMT';
    const CURRENCY         = 'PAYMENTINFO_0_CURRENCYCODE';
    const TAX_AMOUNT       = 'PAYMENTINFO_0_TAXAMT';
    const PAYMENT_STATUS   = 'PAYMENTINFO_0_PAYMENTSTATUS';
    const PENDING_REASON   = 'PAYMENTINFO_0_PENDINGREASON';
    const REASON_CODE      = 'PAYMENTINFO_0_REASONCODE';
    
    protected $transactionId;
    
    protected $transactionType;
    
    protected $paymentType;
    
    protected $orderTime;
    
    protected $amount;
    
    protected $currency;
    
    protected $taxAmount;
    
    protected $paymentStatus;
    
    protected $pendingReason;
    
    protected $reasonCode;
    
    protected function setData(array $data)
    {
        parent::setData($data);
        
        if (array_key_exists(self::TRANSACTION_ID, $data)) {
            $this->transactionId = $data[self::TRANSACTION_ID];
        }
        if (array_key_exists(self::TRANSACTION_TYPE, $data)) {
            $this->transactionType = $data[self::TRANSACTION_TYPE];
        }
        if (array_key_exists(self::PAYMENT_TYPE, $data)) {
            $this->paymentType = $data[self::PAYMENT_TYPE];
        }
        if (array_key_exists(self::ORDER_TIME, $data)) {
            $this->orderTime = $data[self::ORDER_TIME];
        }
        if (array_key_exists(self::AMOUNT, $data)) {
            $this->amount = $data[self::AMOUNT];
        }
        if (array_key_exists(self::CURRENCY, $data)) {
            $this->currency = $data[self::CURRENCY];
        }
        if (array_key_exists(self::TAX_AMOUNT, $data)) {
            $this->taxAmount = $data[self::TAX_AMOUNT];
        }
        if (array_key_exists(self::PAYMENT_STATUS, $data)) {
            $this->paymentStatus = $data[self::PAYMENT_STATUS];
        }
        if (array_key_exists(self::PENDING_REASON, $data)) {
            $this->pendingReason = $data[self::PENDING_REASON];
        }
        if (array_key_exists(self::REASON_CODE, $data)) {
            $this->reasonCode = $data[self::REASON_CODE];
        }
    }
    
    public function getTransactionId()
    {
        return $this->transactionId;
    }
    
    public function getTransactionType()
    {
        return $this->transactionType;
    }
    
    public function getPaymentType()
    {
        return $this->paymentType;
    }
    
    public function getOrderTime()
    {
        return $this->orderTime;
    }
    
    public function getAmount()
    {
        return $this->amount;
    }
    
    public function getCurrency()
    {
        return $this->currency;
    }
    
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }
    
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }
    
    public function getPendingReason()
    {
        return $this->pendingReason;
    }
    
    public function getReasonCode()
    {
        return $this->reasonCode;
    }
}
