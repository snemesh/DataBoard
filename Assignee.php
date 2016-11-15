<?php
namespace backuse;
class Assignee
{
    private $assignee_name;
    private $salary;
    private $hourlyRate;


    public function getAssigneeName()
    {
        return $this->assignee_name;
    }
    public function getHourlyRate()
    {
        return $this->hourlyRate;
    }

    public function getSalary()
    {
        return $this->salary;
    }
    public function setAssigneeName($assignee_name)
    {
        $this->assignee_name = $assignee_name;
    }
    public function setHourlyRate($hourlyRate)
    {
        $this->hourlyRate = $hourlyRate;
    }
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }
}

