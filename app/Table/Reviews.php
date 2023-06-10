<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Reviews extends Table
{
    protected $table = "reviews";
    #[Properties(type: 'int', length: 11)]
    private $review_id;
    #[Properties(type: 'int', length: 11)]
    private $product_id;
    #[Properties(type: 'int', length: 11)]
    private $user_id;
    #[Properties(type: 'string', length: 5000)]
    private $review_description;
    #[Properties(type: 'int', length: 1)]
    private $grade;
    #[Properties(type: 'string', length: 5000)]
    private $review_date;

    /**
     * Get the value of product_id
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->review_description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($review_description)
    {
        $this->review_description = $review_description;

        return $this;
    }

    /**
     * Get the value of grade
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set the value of grade
     *
     * @return  self
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get the value of review_id
     */
    public function getReview_id()
    {
        return $this->review_id;
    }

    /**
     * Set the value of review_id
     *
     * @return  self
     */
    public function setReview_id($review_id)
    {
        $this->review_id = $review_id;

        return $this;
    }

    public function flush()
    {
        if (isset($this->review_id)) {
            parent::update(['user_id', 'product_id', 'review_description', 'grade', 'review_date'], "review_id", [$this->user_id, $this->product_id, $this->review_description, $this->grade, $this->review_date, $this->review_id]);
        } else {
            parent::insert(['user_id', 'product_id', 'review_description', 'grade', 'review_date'], [$this->user_id, $this->product_id, $this->review_description, $this->grade, $this->review_date]);
        }
    }

    /**
     * Get the value of review_date
     */
    public function getReview_date()
    {
        return $this->review_date;
    }

    /**
     * Set the value of review_date
     *
     * @return  self
     */
    public function setReview_date($review_date)
    {
        $this->review_date = $review_date;

        return $this;
    }
}
