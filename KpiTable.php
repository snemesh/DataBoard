<?php

class KpiTable
{
    private $totalEstimated;
    private $nonBillblEstimated;
    private $billblEstimated;
    private $totalSpentTime;
    private $nonBillblSpentTime;
    private $billblSpentTime;
    private $totalProjects;
    private $totalPM;

    public function getBillblEstimated()
    {
        return $this->billblEstimated;
    }
    public function getBillblSpentTime()
    {
        return $this->billblSpentTime;
    }
    public function getNonBillblEstimated()
    {
        return $this->nonBillblEstimated;
    }
    public function getNonBillblSpentTime()
    {
        return $this->nonBillblSpentTime;
    }
    public function getTotalEstimated()
    {
        return $this->totalEstimated;
    }
    public function getTotalSpentTime()
    {
        return $this->totalSpentTime;
    }


    public function setBillblEstimated($billblEstimated)
    {
        $this->billblEstimated = $billblEstimated;
    }
    public function setBillblSpentTime($billblSpentTime)
    {
        $this->billblSpentTime = $billblSpentTime;
    }
    public function setNonBillblEstimated($nonBillblEstimated)
    {
        $this->nonBillblEstimated = $nonBillblEstimated;
    }
    public function setNonBillblSpentTime($nonBillblSpentTime)
    {
        $this->nonBillblSpentTime = $nonBillblSpentTime;
    }
    public function setTotalEstimated($totalEstimated)
    {
        $this->totalEstimated = $totalEstimated;
    }
    public function setTotalSpentTime($totalSpentTime)
    {
        $this->totalSpentTime = $totalSpentTime;
    }


    public function setTotalPM($totalPM)
    {
        $this->totalPM = $totalPM;
    }

    public function setTotalProjects($totalProjects)
    {
        $this->totalProjects = $totalProjects;
    }

    /**
     * @return mixed
     */
    public function getTotalPM()
    {
        return $this->totalPM;
    }

    /**
     * @return mixed
     */
    public function getTotalProjects()
    {
        return $this->totalProjects;
    }
}