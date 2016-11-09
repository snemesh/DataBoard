<?php
/**
 * Created by PhpStorm.
 * User: snemesh
 * Date: 08.11.16
 * Time: 14:47
 */


class Assignee
{
    private $assignee_name;
    private $salary;
    private $hourlyRate;

    /**
     * @return mixed
     */
    public function getAssigneeName()
    {
        return $this->assignee_name;
    }

    /**
     * @return mixed
     */
    public function getHourlyRate()
    {
        return $this->hourlyRate;
    }

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param mixed $assignee_name
     */
    public function setAssigneeName($assignee_name)
    {
        $this->assignee_name = $assignee_name;
    }

    /**
     * @param mixed $hourlyRate
     */
    public function setHourlyRate($hourlyRate)
    {
        $this->hourlyRate = $hourlyRate;
    }

    /**
     * @param mixed $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }
}

