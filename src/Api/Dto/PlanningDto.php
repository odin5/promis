<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 27.08.2018 13:08
 */
namespace App\Api\Dto;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class PlanningDto
 * @package App\Api\Dto
 * @ApiResource(
 *     iri="/plans/planning",
 *     normalizationContext={
 *         "groups"={"Planning_read", "PlanSlot_read"},
 *         "swagger_definition_name"="Planning_read"
 *     },
 *     collectionOperations={},
 *     itemOperations={
 *         "get"={
 *             "method"="GET",
 *             "path"="/plans/{plan}/planning",
 *             "controller"="App\Api\Controller\PlanController::getPlanning",
 *             "swagger_context"= {
 *                 "parameters"={
 *                     { "name"="plan", "in"="path", "type"="integer", "required"=true }
 *                 }
 *             },
 *             "defaults"={"_api_receive"=false}
 *         }
 *     }
 * )
 */
class PlanningDto
{

    /**
     * @ApiProperty(swaggerContext={ "type"="array", "items"={ "$ref"="#/definitions/PlanSlot-PlanSlot_read" } })
     * @Groups({"PlanSlot_read"})
     */
    private $planSlots;
    /**
     * @ApiProperty(identifier=true, swaggerContext={ "$ref"="#/definitions/Plan-plan_read" })
     */
    private $plan;

    /**
     * @ApiProperty(swaggerContext={ "type"="array", "items"={ "$ref"="#/definitions/Turn-turn_read" } })
     */
    private $turns;

    /**
     * @ApiProperty(swaggerContext={ "type"="array", "items"={ "$ref"="#/definitions/Work-work_read" } })
     */
    private $works;

    /**
     * @ApiProperty(swaggerContext={ "type"="array", "items"={ "$ref"="#/definitions/Weather-weather_read" } })
     */
    private $weathers;

    /**
     * @ApiProperty(swaggerContext={ "type"="array", "items"={ "$ref"="#/definitions/Team-team_read" } })
     */
    private $teams;

    /**
     * @return mixed
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @param mixed $plan
     * @return PlanningDto
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTurns()
    {
        return $this->turns;
    }

    /**
     * @param mixed $turns
     * @return PlanningDto
     */
    public function setTurns($turns)
    {
        $this->turns = $turns;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorks()
    {
        return $this->works;
    }

    /**
     * @param mixed $works
     * @return PlanningDto
     */
    public function setWorks($works)
    {
        $this->works = $works;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWeathers()
    {
        return $this->weathers;
    }

    /**
     * @param mixed $weathers
     * @return PlanningDto
     */
    public function setWeathers($weathers)
    {
        $this->weathers = $weathers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param mixed $teams
     * @return PlanningDto
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlanSlots()
    {
        return $this->planSlots;
    }

    /**
     * @param mixed $planSlots
     * @return PlanningDto
     */
    public function setPlanSlots($planSlots)
    {
        $this->planSlots = $planSlots;
        return $this;
    }
}