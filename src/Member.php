<?php
/**
 * Created by PhpStorm.
 * User: Yohan
 * Date: 14/03/2016
 * Time: 23:07
 */

namespace Yohan;

class Member
{
    private $name;

    private $old;

    public function __construct($name)
    {
        $this->name = $name;
        $this->old = false;
    }

    public function setOld($old)
    {
        $this->old = $old;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isOld()
    {
        return $this->old;
    }
}
