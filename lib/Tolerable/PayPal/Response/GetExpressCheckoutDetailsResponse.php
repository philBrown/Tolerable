<?php
namespace Tolerable\PayPal\Response;

class GetExpressCheckoutDetailsResponse extends Response
{
    const TOKEN                  = 'TOKEN';
    const CUSTOM                 = 'CUSTOM';
    const INVNUM                 = 'INVNUM';
    const PHONENUM               = 'PHONENUM';
    const PAYPAL_ADJUSTMENT      = 'PAYPALADJUSTMENT';
    const NOTE                   = 'NOTE';
    const CHECKOUT_STATUS        = 'CHECKOUTSTATUS';
    const GIFT_MESSAGE           = 'GIFTMESSAGE';
    const GIFT_RECEIPT_ENABLE    = 'GIFTRECEIPTENABLE';
    const GIFT_WRAP_NAME         = 'GIFTWRAPNAME';
    const GIFT_WRAP_AMOUNT       = 'GIFTWRAPAMOUNT';
    const BUYER_MARKETING_EMAIL  = 'BUYERMARKETINGEMAIL';
    const SURVEY_QUESTION        = 'SURVEYQUESTION';
    const SURVEY_CHOICE_SELECTED = 'SURVEYCHOICESELECTED';
    
    /* Payer information fields */
    const EMAIL         = 'EMAIL';
    const PAYER_ID      = 'PAYERID';
    const PAYER_STATUS  = 'PAYERSTATUS';
    const COUNTRY_CODE  = 'COUNTRYCODE';
    const BUSINESS_NAME = 'BUSINESS';
    
    /* Payer name fields */
    const SALUTATION  = 'SALUTATION';
    const FIRST_NAME  = 'FIRSTNAME';
    const MIDDLE_NAME = 'MIDDLENAME';
    const LAST_NAME   = 'LASTNAME';
    const SUFFIX      = 'SUFFIX';
    
    /* Address Type Fields */
    const SHIP_TO_NAME         = 'PAYMENTREQUEST_0_SHIPTONAME';
    const SHIP_TO_STREET       = 'PAYMENTREQUEST_0_SHIPTOSTREET';
    const SHIP_TO_STREET2      = 'PAYMENTREQUEST_0_SHIPTOSTREET2';
    const SHIP_TO_CITY         = 'PAYMENTREQUEST_0_SHIPTOCITY';
    const SHIP_TO_STATE        = 'PAYMENTREQUEST_0_SHIPTOSTATE';
    const SHIP_TO_ZIP          = 'PAYMENTREQUEST_0_SHIPTOZIP';
    const SHIP_TO_COUNTRY_CODE = 'PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE';
    const SHIP_TO_PHONE        = 'PAYMENTREQUEST_0_SHIPTOPHONENUM';
    const ADDRESS_STATUS       = 'PAYMENTREQUEST_0_ADDRESSSTATUS';
    
    /* Checkout status values */
    const PAYMENT_ACTION_NOT_INITIATED = 'PaymentActionNotInitiated';
    const PAYMENT_ACTION_FAILED        = 'PaymentActionFailed';
    const PAYMENT_ACTION_IN_PROGRESS   = 'PaymentActionInProgress';
    const PAYMENT_COMPLETE             = 'PaymentCompleted';
    
    /* Payer status values */
    const VERIFIED   = 'verified';
    const UNVERIFIED = 'unverified';
    
    /* Address status values */
    const NONE        = 'none';
    const CONFIRMED   = 'Confirmed';
    const UNCONFIRMED = 'Unconfirmed';
    
    /**
     * @var string
     */
    protected $payerId;
    
    /**
     * @var string
     */
    protected $email;
    
    /**
     * @var string
     */
    protected $salutation;
    
    /**
     * @var string
     */
    protected $firstName;
    
    /**
     * @var string
     */
    protected $middleName;
    
    /**
     * @var string
     */
    protected $lastName;
    
    /**
     * @var string
     */
    protected $suffix;
    
    /**
     * @var string
     */
    protected $shipToName;
    
    /**
     * @var string
     */
    protected $shipToStreet;
    
    /**
     * @var string
     */
    protected $shipToStreet2;
    
    /**
     * @var string
     */
    protected $shipToCity;
    
    /**
     * @var string
     */
    protected $shipToState;
    
    /**
     * @var string
     */
    protected $shipToZip;
    
    /**
     * @var string
     */
    protected $shipToCountry;
    
    /**
     * @var string
     */
    protected $shipToPhone;
    
    protected function setData(array $data)
    {
        parent::setData($data);
        
        if (array_key_exists(self::PAYER_ID, $data)) {
            $this->payerId = $data[self::PAYER_ID];
        }
        if (array_key_exists(self::EMAIL, $data)) {
            $this->email = $data[self::EMAIL];
        }
        if (array_key_exists(self::SALUTATION, $data)) {
            $this->salutation = $data[self::SALUTATION];
        }
        if (array_key_exists(self::FIRST_NAME, $data)) {
            $this->firstName = $data[self::FIRST_NAME];
        }
        if (array_key_exists(self::MIDDLE_NAME, $data)) {
            $this->middleName = $data[self::MIDDLE_NAME];
        }
        if (array_key_exists(self::LAST_NAME, $data)) {
            $this->lastName = $data[self::LAST_NAME];
        }
        if (array_key_exists(self::SUFFIX, $data)) {
            $this->suffix = $data[self::SUFFIX];
        }
    }
    
    public function getPayerId() {
        return $this->payerId;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getFullName() {
        return sprintf('%s%s %s',
                $this->salutation ? $this->salutation . ' ' : '',
                $this->firstName,
                $this->lastName);
    }
}
