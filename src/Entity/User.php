<?php
/**
 * Created by PhpStorm.
 * User: Kshama
 * Date: 4/6/19
 * Time: 3:36 PM
 */

namespace App\Entity;


class User
{
    protected $userName;
    protected $password;


    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

}