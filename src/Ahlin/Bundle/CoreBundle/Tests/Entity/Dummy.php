<?php

namespace Ahlin\Bundle\CoreBundle\Tests\Entity;

use UnexpectedValueException;

/**
 * Class Dummy is only a test class which is used when testing form and validation
 */
class Dummy
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var bool
     */
    private $check;

    /**
     * @var integer
     */
    private $countOne;

    /**
     * @var integer
     */
    private $countTwo;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Dummy
     * @throws UnexpectedValueException
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new UnexpectedValueException('Unexpected value. Expected a string.');
        }
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Dummy
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isCheck()
    {
        return $this->check;
    }

    /**
     * @param boolean $check
     * @return Dummy
     */
    public function setCheck($check)
    {
        $this->check = $check;
        return $this;
    }

    /**
     * @return int
     */
    public function getCountOne()
    {
        return $this->countOne;
    }

    /**
     * @param int $countOne
     * @return Dummy
     */
    public function setCountOne($countOne)
    {
        $this->countOne = $countOne;
        return $this;
    }

    /**
     * @return int
     */
    public function getCountTwo()
    {
        return $this->countTwo;
    }

    /**
     * @param int $countTwo
     * @return Dummy
     */
    public function setCountTwo($countTwo)
    {
        $this->countTwo = $countTwo;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCountTwoBigger() {
        if ($this->countOne === null || $this->countTwo === null) {
            return false;
        }
        return $this->countTwo > $this->countOne;
    }

    /**
     * @return bool
     */
    public function isNameBlank() {
        return empty($this->name);
    }

}
