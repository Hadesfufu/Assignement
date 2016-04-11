<?php
/**
 * Created by PhpStorm.
 * User: Yohan
 * Date: 14/03/2016
 * Time: 23:14
 */

namespace Yohan;

use Illuminate\Support\Collection;

class Group
{
    private $id;

    private $description;

    private $members;

    private $projects;

    private $publications;

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
    public function getProjects()
    {
        return $this->projects;
    }


    public function addProjects($input)
    {
        $this->projects->push($input);
    }

    public function removeProjects($input)
    {
        if (is_numeric($input)) {
            unset($this->projects[$input]);
        } else {
            $this->projects->reject(function ($value, $key) {
                global $input;
                return $value == $input;
            });
        }
    }

    /**
     * @return mixed
     */
    public function getPublications()
    {
        return $this->publications;
    }

    public function addPublications($input)
    {
        $this->publications->push($input);
    }

    public function removePublications($input)
    {
        if (is_numeric($input)) {
            unset($this->publications[$input]);
        } else {
            $this->publications->reject(function ($value, $key) {
                global $input;
                return $value == $input;
            });
        }
    }

    public function __construct()
    {
        $this->members = collect([]);
        $this->projects = collect([]);
        $this->publications = collect([]);
    }
}
