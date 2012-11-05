<?php

namespace Shop\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Payment\CoreBundle\Entity\PaymentInstruction;


/**
 * Shop\OrderBundle\Entity\Order
 *
 * @ORM\Table(name="order2")
 * @ORM\Entity(repositoryClass="Shop\OrderBundle\Entity\OrderRepository")
 */
class Order2 {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $orderNumber
     *
     * @ORM\Column(name="orderNumber", type="string", length=255)
     */
    private $orderNumber;
    
     /** @ORM\Column(type="decimal", precision = 2) */
    private $amount;
    
    
      /** @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction", cascade={"persist"}) */
    private $paymentInstruction;

     /**
     * @ORM\ManyToOne(targetEntity="Security\AuthenticateBundle\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function __construct() {
        
    }
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set orderNumber
     *
     * @param string $orderNumber
     * @return Order2
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    
        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return string 
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set paymentInstruction
     *
     * @param JMS\Payment\CoreBundle\Entity\PaymentInstruction $paymentInstruction
     * @return Order2
     */
    public function setPaymentInstruction(\JMS\Payment\CoreBundle\Entity\PaymentInstruction $paymentInstruction = null)
    {
        $this->paymentInstruction = $paymentInstruction;
    
        return $this;
    }

    /**
     * Get paymentInstruction
     *
     * @return JMS\Payment\CoreBundle\Entity\PaymentInstruction 
     */
    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Order2
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set user
     *
     * @param Security\AuthenticateBundle\Entity\User $user
     * @return Order2
     */
    public function setUser(\Security\AuthenticateBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Security\AuthenticateBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}