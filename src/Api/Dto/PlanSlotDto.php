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
 * Class PlanSlotDto
 * @package App\Api\Dto
 * @ApiResource(
 *     iri="/plans/slots",
 *     normalizationContext={"groups"={"PlanSlot_read"}, "swagger_definition_name"="PlanSlot_read"},
 *     denormalizationContext={"groups"={"PlanSlot_write"}, "swagger_definition_name"="PlanSlot_write"},
 *     collectionOperations={
 *         "in-plan"={
 *             "method"="GET",
 *             "path"="/plans/{plan}/slots/",
 *             "controller"="App\Api\Controller\PlanController::getSlots",
 *             "defaults"={"_api_receive"=false},
 *             "swagger_context"= { "parameters"={
 *                     { "name"="plan", "in"="path", "type"="string", "required"=true }
 *                 } }
 *         }
 *     },
 *     itemOperations={
 *         "get"={
 *             "path"="/plans/{plan}/slots/{work}/{turn}",
 *             "controller"="App\Api\Controller\PlanController::getSlot",
 *             "defaults"={"_api_receive"=false},
 *             "swagger_context"= { "parameters"={
 *                     { "name"="plan", "in"="path", "type"="string", "required"=true },
 *                     { "name"="work", "in"="path", "type"="string", "required"=true },
 *                     { "name"="turn", "in"="path", "type"="string", "required"=true }
 *                 } }
 *         },
 *         "put"={
 *             "path"="/plans/{plan}/slots/{work}/{turn}",
 *             "controller"="App\Api\Controller\PlanController::putSlot",
 *             "defaults"={"_api_receive"=false},
 *             "swagger_context"= { "parameters"={
 *                     { "name"="plan", "in"="path", "type"="string", "required"=true },
 *                     { "name"="work", "in"="path", "type"="string", "required"=true },
 *                     { "name"="turn", "in"="path", "type"="string", "required"=true }
 *                 } }
 *         },
 *         "move-team"={
 *             "method"="POST",
 *             "path"="/plans/{plan}/slots/{work}/{turn}/move-team/work",
 *             "controller"="App\Api\Controller\PlanController::getSlots",
 *             "defaults"={"_api_receive"=false}
 *         }
 *     }
 * )
 */
class PlanSlotDto
{
    /**
     * @ApiProperty(identifier=true, swaggerContext={ "type"="string" })
     * @Groups({"PlanSlot_read", "PlanSlot_write"})
     */
    private $plan;

    /**
     * @ApiProperty(identifier=true, swaggerContext={ "type"="string" })
     * @Groups({"PlanSlot_read", "PlanSlot_write"})
     */
    private $turn;

    /**
     * @ApiProperty(identifier=true, swaggerContext={ "type"="string" })
     * @Groups({"PlanSlot_read", "PlanSlot_write"})
     */
    private $work;

    /**
     * @ApiProperty(
     *     swaggerContext= {
     *         "type"="array",
     *         "items"={
     *             "type"="object",
     *             "properties"={ "team"={ "type"="integer" }, "count"={"type"="integer"}}
     *         }
     *     }
     * )
     * @Groups({"PlanSlot_read", "PlanSlot_write"})
     */
    private $teamCounts = [];

    public function getPlan(): string
    {
        return $this->plan;
    }

    public function setPlan(string $plan): PlanSlotDto
    {
        $this->plan = $plan;
        return $this;
    }

    public function getTurn(): string
    {
        return $this->turn;
    }

    public function setTurn(string $turn): PlanSlotDto
    {
        $this->turn = $turn;
        return $this;
    }

    public function getWork(): string
    {
        return $this->work;
    }

    public function setWork(string $work): PlanSlotDto
    {
        $this->work = $work;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getTeamCounts(): array
    {
        return $this->teamCounts;
    }

    public function addTeamCount(array $team): PlanSlotDto
    {
        $this->teamCounts[] = $team;
        return $this;
    }

    /**
     * @param string[] $teamCounts
     * @return PlanSlotDto
     */
    public function setTeamCounts(array $teamCounts): PlanSlotDto
    {
        $this->teamCounts = $teamCounts;
        return $this;
    }

}