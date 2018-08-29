<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 27.08.2018 13:08
 */
namespace App\Api\Dto;

use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Class PlanSlotDto
 * @package App\Api\Dto
 * @ApiResource(
 *     iri="/plans/slots/teams/moves",
 *     denormalizationContext={"groups"={"any", "any:write"}},
 *     collectionOperations={},
 *     itemOperations={
 *         "post"={
 *             "method"="POST",
 *             "path"="/plans/{plan}/slots/{work}/{turn}/teams/{team}/move",
 *             "controller"="App\Api\Controller\PlanController::getSlots",
 *             "parameters"={
 *                 "a"={ "name"="plan", "in"="path" },
 *                 "b"={ "name"="work", "in"="path" }
 *             }
 *         }
 *     }
 * )
 */
class PlanSlotMoveTeamsDto
{
    public $content = [
        'work'
    ];
}