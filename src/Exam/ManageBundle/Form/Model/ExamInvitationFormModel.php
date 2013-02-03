<?php

namespace Exam\ManageBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ExamInvitationFormModel {
    
    /**
     * @Assert\NotBlank()
     * @Assert\Email();
     *
     * @var string
     */
    private $email;
    
    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $first_name;
    
    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $last_name;
    
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="int")
     * @var integer
     */
    private $exam_id;
    
    /**
     * Get email 
     */
    public function getEmail(){
        return $this->email;
    }
    
    /**
     * Set email 
     */
    public function setEmail($email){
        $this->email = $email;
    }
    
    /**
     * Get the first name.
     *
     * @return string
     */
    public function getFirstName(){
        return $this->first_name;
    }
    
    /**
     * Set first name 
     */
    public function setFirstName($first_name){
        $this->first_name = $first_name;
    }
    
    /**
     * Get the last name.
     *
     * @return string
     */
    public function getLastName(){
        return $this->last_name;
    }
    
    /**
     * Set last name 
     */
    public function setLastName($last_name){
        $this->last_name = $last_name;
    }
    
    /**
     * Get the exam id.
     *
     * @return integer
     */
    public function getExamId(){
        return $this->exam_id;
    }
    
    /**
     * Set exam id 
     */
    public function setExamId($exam_id){
        $this->exam_id = (int)$exam_id;
    }
    
}
