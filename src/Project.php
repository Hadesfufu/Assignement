<?php
/**
 * Created by PhpStorm.
 * User: Yohan
 * Date: 14/03/2016
 * Time: 23:20
 */

namespace Yohan;

class Project
{
    private $id;
    private $creatorId;
    private $members;
    private $students;
    private $description;
    private $old;

    /**
     * @return mixed
     */
    public function getCreatorId()
    {
        return $this->creatorId;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMembers()
    {
        return $this->members;
    }

    public function addMembers($input)
    {
        $this->members->push($input);
    }

    public function removeMembers($input)
    {
        if (is_numeric($input)) {
            unset($this->members[$input]);
        } else {
            $this->members->reject(function ($value, $key) {
                global $input;
                return $value == $input;
            });
        }
    }

    /**
     * @return mixed
     */
    public function getStudents()
    {
        return $this->students;
    }

    public function addStudents($input)
    {
        $this->members->push($input);
    }

    public function removeStudents($input)
    {
        if (is_numeric($input)) {
            unset($this->members[$input]);
        } else {
            $this->members->reject(function ($value, $key) {
                global $input;
                return $value == $input;
            });
        }
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getOld()
    {
        return $this->old;
    }

    /**
     * @param mixed $old
     */
    public function setOld($old)
    {
        $this->old = $old;
    }

    public function __construct($description)
    {
        $this->description = $description;
    }
}
