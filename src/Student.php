<?php
/**
 * Created by PhpStorm.
 * User: Yohan
 * Date: 14/03/2016
 * Time: 23:18
 */

namespace Yohan;

class Student extends Member
{
    private $id;
    private $supervisor;
    private $projectId;
    private $photo;
    private $email;
    private $supervisorId;

    /**
     * @return mixed
     */
    public function getSupervisorId()
    {
        return $this->supervisorId;
    }

    /**
     * @param mixed $supervisorId
     */
    public function setSupervisorId($supervisorId)
    {
        $this->supervisorId = $supervisorId;
    }

    /**
     * @return mixed
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param mixed $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getSupervisor()
    {
        return $this->supervisor;
    }

    /**
     * @param mixed $supervisor
     */
    public function setSupervisor($supervisor)
    {
        $this->supervisor = $supervisor;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct($name)
    {
        parent::__construct($name);
    }
}
