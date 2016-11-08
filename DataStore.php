<?php
class DataStore
{
    private $project;
    private $nonBil;
    private $assignee;
    private $estimated;
    private $spentTime;

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return mixed
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @return mixed
     */
    public function getEstimated()
    {
        return $this->estimated;
    }

    /**
     * @return mixed
     */
    public function getNonBil()
    {
        return $this->nonBil;
    }

    /**
     * @return mixed
     */
    public function getSpentTime()
    {
        return $this->spentTime;
    }

    /**
     * @param mixed $assignee
     */
    public function setAssignee($assignee)
    {
        $this->assignee = $assignee;
    }

    /**
     * @param mixed $estimated
     */
    public function setEstimated($estimated)
    {
        $this->estimated = $estimated;
    }

    /**
     * @param mixed $nonBil
     */
    public function setNonBil($nonBil)
    {
        $this->nonBil = $nonBil;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @param mixed $spentTime
     */
    public function setSpentTime($spentTime)
    {
        $this->spentTime = $spentTime;
    }
}