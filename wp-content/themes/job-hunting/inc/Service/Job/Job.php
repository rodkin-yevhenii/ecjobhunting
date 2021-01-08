<?php


namespace EcJobHunting\Service\Job;


use EcJobHunting\Entity\Vacancy;

class Job
{
    private Vacancy $vacancy;

    public function __construct(Vacancy $vacancy)
    {
        $this->vacancy = $vacancy;
    }

    public function update(){

    }

    public function create(){

    }

    public function close(){

    }

    public function remove(){

    }

}