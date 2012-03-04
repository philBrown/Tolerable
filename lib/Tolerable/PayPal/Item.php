<?php
namespace Tolerable\PayPal;

class Item
{
    /**
     * Item field templates
     */
    const NAME        = 'L_PAYMENTREQUEST_0_NAME%d';
    const NUMBER      = 'L_PAYMENTREQUEST_0_NUMBER%d';
    const DESCRIPTION = 'L_PAYMENTREQUEST_0_DESC%d';
    const AMOUNT      = 'L_PAYMENTREQUEST_0_AMT%d';
    const QTY         = 'L_PAYMENTREQUEST_0_QTY%d';
    const TAX         = 'L_PAYMENTREQUEST_0_TAXAMT%d';

    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var double
     */
    protected $amount;
    
    /**
     * @var double
     */
    protected $tax;
    
    /**
     * @var string
     */
    protected $description;
    
    /**
     * @var int
     */
    protected $quantity = 1;
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     * @return Tolerable_PayPal_Item
     */
    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getAmount()
    {
        return sprintf('%0.2f', $this->amount);
    }
    
    public function getTotalAmount()
    {
        return $this->getAmount() * $this->getQuantity();
    }
    
    /**
     * @param double $amount
     * @return Tolerable_PayPal_Item
     */
    public function setAmount($amount)
    {
        $this->amount = (double) $amount;
        return $this;
    }
    
    public function getTax()
    {
        return sprintf('%0.2f', $this->tax);
    }
    
    public function getTotalTaxAmount()
    {
        return $this->getTax() * $this->getQuantity();
    }
    
    public function setTax($tax)
    {
        $this->tax = (double) $tax;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * @param string $description
     * @return Tolerable_PayPal_Item
     */
    public function setDescription($description)
    {
        $this->description = (string) $description;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     * @param int $quantity
     * @return Tolerable_PayPal_Item
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
        return $this;
    }
    
    public function toArray($index)
    {
        return array(
            sprintf(self::NAME, $index)        => $this->getName(),
            sprintf(self::DESCRIPTION, $index) => $this->getDescription(),
            sprintf(self::AMOUNT, $index)      => $this->getAmount(),
            sprintf(self::QTY, $index)         => $this->getQuantity(),
            sprintf(self::TAX, $index)         => $this->getTax()
        );
    }
}