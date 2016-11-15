<?php
/**
 * Created by PhpStorm.
 * User: snemesh
 * Date: 03.11.16
 * Time: 15:49
 */

namespace backuse;
class KpiData
{

    private $project;
    private $user;
    private $spentTime;

    public function __construct($myProject, $myUser, $mySpentTime)
    {
        $this->user = $myUser;
        $this->project = $myProject;
        $this->spentTime = $mySpentTime;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param mixed $spentTime
     */
    public function setSpentTime($spentTime)
    {
        $this->spentTime = $spentTime;
    }

    /**
     * @return mixed
     */
    public function getSpentTime()
    {
        return $this->spentTime;
    }

}
