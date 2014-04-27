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
    const CATEGORY    = 'L_PAYMENTREQUEST_0_ITEMCATEGORY%d';
    const WEIGHT      = 'L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE%d';
    const WEIGHT_UNIT = 'L_PAYMENTREQUEST_0_ITEMWEIGHTUNIT%d';
    const LENGTH      = 'L_PAYMENTREQUEST_0_ITEMLENGTHVALUE%d';
    const LENGTH_UNIT = 'L_PAYMENTREQUEST_0_ITEMLENGTHUNIT%d';
    const WIDTH       = 'L_PAYMENTREQUEST_0_ITEMWIDTHVALUE%d';
    const WIDTH_UNIT  = 'L_PAYMENTREQUEST_0_ITEMWIDTHUNIT%d';
    const HEIGHT      = 'L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE%d';
    const HEIGHT_UNIT = 'L_PAYMENTREQUEST_0_ITEMHEIGHTUNIT%d';
    
    const DIGITAL =  'Digital';
    const PHYSICAL = 'Physical';
    
    const CM = 'cm';
    const KG = 'kg';

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
     * @var string
     */
    protected $category = self::PHYSICAL;
    
    /**
     * @var double
     */
    protected $width;
    
    /**
     * @var string
     */
    protected $widthUnit = self::CM;
    
    /**
     * @var double
     */
    protected $height;
    
    /**
     * @var string
     */
    protected $heightUnit = self::CM;
    
    /**
     * @var double
     */
    protected $length;
    
    /**
     * @var string
     */
    protected $lengthUnit = self::CM;
    
    /**
     * @var double
     */
    protected $weight;
    
    /**
     * @var string
     */
    protected $weightUnit = self::KG;
    
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
    
    public function getCategory()
    {
        return $this->category;
    }
    
    public function setCategory($category)
    {
        switch ($category) {
            case self::DIGITAL :
            case self::PHYSICAL :
                $this->category = (string) $category;
                break;
            default :
                throw new \Exception(sprintf('Invalid category "%s"', $category));
        }
        return $this;
    }
    
    public function getWidth()
    {
        return $this->width;
    }
    
    public function setWidth($width)
    {
        $this->width = (double) $width;
        return $this;
    }
    
    public function getHeight()
    {
        return $this->height;
    }
    
    public function setHeight($height)
    {
        $this->height = (double) $height;
        return $this;
    }
    
    public function getLength()
    {
        return $this->length;
    }
    
    public function setLength($length)
    {
        $this->length = (double) $length;
        return $this;
    }
    
    public function getWeight()
    {
        return $this->weight;
    }
    
    public function setWeight($weight)
    {
        $this->weight = (double) $weight;
        return $this;
    }
    
    public function toArray($index)
    {
        return array(
            sprintf(self::NAME, $index)        => $this->getName(),
            sprintf(self::DESCRIPTION, $index) => $this->getDescription(),
            sprintf(self::AMOUNT, $index)      => $this->getAmount(),
            sprintf(self::QTY, $index)         => $this->getQuantity(),
            sprintf(self::TAX, $index)         => $this->getTax(),
            sprintf(self::CATEGORY, $index)    => $this->getCategory()
        ) + $this->getPhysicalProductArray($index);
    }
    
    protected function getPhysicalProductArray($index)
    {
        if ($this->getCategory() == self::DIGITAL) {
            return array();
        }
        return array(
            sprintf(self::WIDTH, $index)       => $this->getWidth(),
            sprintf(self::WIDTH_UNIT, $index)  => $this->widthUnit,
            sprintf(self::HEIGHT, $index)      => $this->getHeight(),
            sprintf(self::HEIGHT_UNIT, $index) => $this->heightUnit,
            sprintf(self::LENGTH, $index)      => $this->getLength(),
            sprintf(self::LENGTH_UNIT, $index) => $this->lengthUnit,
            sprintf(self::WEIGHT, $index)      => $this->getWeight(),
            sprintf(self::WEIGHT_UNIT, $index) => $this->weightUnit
        );
    }
}