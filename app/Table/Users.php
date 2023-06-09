<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Users extends Table
{
    protected $table = "users";
    #[Properties(type: 'int', length: 11)]
    private $id = null;
    #[Properties(type: 'string', length: 255)]
    private $first_name = "";
    #[Properties(type: 'string', length: 255)]
    private $last_name = "";
    #[Properties(type: 'string', length: 255)]
    private $email;
    #[Properties(type: 'string', length: 255)]
    private $password;
    #[Properties(type: 'string', length: 20)]
    private $num = "";
    #[Properties(type: 'string', length: 255)]
    private $adress = "";
    #[Properties(type: 'int', length: 1)]
    private $type = 0;
    #[Properties(type: 'string')]
    private $creation_date;

    /**
     * Get the value of first_name
     */
    public function getFirst_name()
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     *
     * @return  self
     */
    public function setFirst_name($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of last_name
     */
    public function getLast_name()
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */
    public function setLast_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of num
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set the value of num
     *
     * @return  self
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get the value of adress
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set the value of adress
     *
     * @return  self
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get the value of creation_date
     */
    public function getCreation_date()
    {
        return $this->creation_date;
    }

    /**
     * Set the value of creation_date
     *
     * @return  self
     */
    public function setCreation_date($creation_date)
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function flush()
    {
        if (isset($this->id)) {
            parent::update(['first_name', 'last_name', 'email', 'password', 'num', 'adress', 'type', 'creation_date'], "id", [$this->first_name, $this->last_name, $this->email, $this->password, $this->num, $this->adress, $this->type, $this->creation_date, $this->id]);
        } else {
            parent::insert(['first_name', 'last_name', 'email', 'password', 'num', 'adress', 'type'], [$this->first_name, $this->last_name, $this->email, $this->password, $this->num, $this->adress, $this->type]);
        }
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
