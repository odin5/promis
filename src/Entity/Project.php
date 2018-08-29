<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 10.07.2018 16:40
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ClassTrait\TranslatableCustomizationTrait;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Projekt - Popis projektu
 * @ApiResource(
 *     normalizationContext={"groups"={"Project_read"}, "swagger_definition_name"="Project_read"},
 *     denormalizationContext={"groups"={"Project_write"}, "swagger_definition_name"="Project_write"},
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('ROLE_STUDENT')"},
 *         "post"={"access_control"="is_granted('ROLE_SUPER_ADMIN') or object in user.allowedProjectEdits)"}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="is_granted('play', object) or is_granted('ROLE_ADMIN')"},
 *         "put"={"access_control"="is_granted('edit', object) or is_granted('ROLE_ADMIN')"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    use Translatable, TranslatableCustomizationTrait;

    /**
     * @Assert\Valid;
     * @Groups("Project_read")
     */
    protected $translations;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups("Project_read")
     */
    private $id;

    /**
     * (In form as 'Časový limit investora')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $timeLimit = 100;

    /**
     * (In form as 'Cena projektu' - help: 'Cena projektu zaplacená investorem.')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $price = 0;

    /**
     * (In form as 'Zálohy')
     * @ORM\Column(type="boolean")
     * @Groups("Project_read")
     */
    private $useAdvances = false;

    /**
     * (In form as 'Prémie za dodržení času')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $timePremium = 0;

    /**
     * (In form as 'Pokuta za překročení času')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $timePenalty = 0;

    /**
     * (In form as 'Růst pokuty (% jednotkového růstu)')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $penaltyGrowth = 0;

    /**
     * (In form as 'Procentní prémie ze zisku')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $profitPremium = 0;

    /**
     * % pokuta za ztratu z projektu
     * (In form as 'Procentní pokuta ze ztráty')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $profitPenalty = 0;

    // Image a pozadovana image podniku
    /**
     * (In form as 'Výchozí image podniku')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $image = 0;

    /**
     * (In form as 'Cílová image')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $imageNeeded = 0;

    /**
     * (In form as 'Pokuta za nedodržení image')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $imagePenalty = 0;

    /**
     * (In form as 'Řešit velikost čety')
     * @ORM\Column(type="boolean")
     * @Groups("Project_read")
     */
    private $useTeamSize = true;

    /**
     * (In form as 'Řešit typ čety')
     * @ORM\Column(type="boolean")
     * @Groups("Project_read")
     */
    private $useTeamType = true;

    /**
     * (In form as 'Řešit spolehlivost čety')
     * @ORM\Column(type="boolean")
     * @Groups("Project_read")
     */
    private $useTeamReliability = true;

    /**
     * urokova mira (rocni) 100 * x (pro tydenni = x / 52) (In form as 'Úroková míra')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $loanRate = 1000;

    /**
     * casove deleni uroku (52 tydnu) (In form as 'Časové dělení úroků')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $loanRateDiff = 10000;

    /**
     * (In form as 'Max. počet čet')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $maxTeams = 0;

    /**
     * (In form as 'Poslední platba')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $lastPayment = 0;

    /**
     * (In form as 'Vyjednávat')
     * @ORM\Column(type="boolean")
     * @Groups("Project_read")
     */
    private $useInterrogate = false;

    /**
     * (In form as 'Procentní uznání ztrát času')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $interrogatePercentage = 0;

    /**
     * (In form as 'Image placená za vyjednávání')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $interrogateImageCost = 0;

    /**
     * (In form as 'Hranice plánování')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $foreplan = 9;

    /**
     * (In form as 'Max. náborový příplatek (%)')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $foreplanMax = 100;

    /**
     * (In form as 'Vícenásobné plánování')
     * @ORM\Column(type="boolean")
     * @Groups("Project_read")
     */
    private $allowMultiplePlan = true;

    /**
     * (In form as '(opakování realizace)')
     * @ORM\Column(type="integer")
     * @Groups("Project_read")
     */
    private $multipleGamePlan = 1;

    /**
     * (In form as 'Realizace s plánováním')
     * @ORM\Column(type="boolean")
     * @Groups("Project_read")
     */
    private $usePlanning = true;

    /**
     * (In form as 'Vzorový plán')
     * @ORM\ManyToOne(targetEntity="Plan")
     * @ORM\JoinColumn(name="default_plan_id", referencedColumnName="id", nullable=true)
     * @Groups("Project_read")
     */
    private $defaultPlan;

    /**
     * (In form as 'Realizace s plánováním')
     * @ORM\Column(type="boolean")
     * @Groups("Project_read")
     */
    private $showEvents = true;

    /**
     * (In form as 'Škola' - help = _(u'Neměnit!'))
     * @ORM\ManyToOne(targetEntity="School")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id", nullable=true)
     * @Groups("Project_read")
     */
    private $school = null;



    public function __toString()
    {
        return (string)$this->getName();
    }

    public function getName(): string
    {
        return $this->proxyCurrentLocaleTranslation('getName');
    }

    public function getPerex(): string
    {
        return $this->proxyCurrentLocaleTranslation('getPerex');
    }

    public function getDescription(): string
    {
        return $this->proxyCurrentLocaleTranslation('getDescription');
    }

    public function getFormattedDescription(): string
    {
        return $this->proxyCurrentLocaleTranslation('getFormattedDescription');
    }

    public function translate($locale = null, $fallbackToDefault = true): ProjectTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeLimit(): ?int
    {
        return $this->timeLimit;
    }

    public function setTimeLimit(int $timeLimit): self
    {
        $this->timeLimit = $timeLimit;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUseAdvances(): ?bool
    {
        return $this->useAdvances;
    }

    public function setUseAdvances(bool $useAdvances): self
    {
        $this->useAdvances = $useAdvances;

        return $this;
    }

    public function getTimePremium(): ?int
    {
        return $this->timePremium;
    }

    public function setTimePremium(int $timePremium): self
    {
        $this->timePremium = $timePremium;

        return $this;
    }

    public function getTimePenalty(): ?int
    {
        return $this->timePenalty;
    }

    public function setTimePenalty(int $timePenalty): self
    {
        $this->timePenalty = $timePenalty;

        return $this;
    }

    public function getPenaltyGrowth(): ?int
    {
        return $this->penaltyGrowth;
    }

    public function setPenaltyGrowth(int $penaltyGrowth): self
    {
        $this->penaltyGrowth = $penaltyGrowth;

        return $this;
    }

    public function getProfitPremium(): ?int
    {
        return $this->profitPremium;
    }

    public function setProfitPremium(int $profitPremium): self
    {
        $this->profitPremium = $profitPremium;

        return $this;
    }

    public function getProfitPenalty(): ?int
    {
        return $this->profitPenalty;
    }

    public function setProfitPenalty(int $profitPenalty): self
    {
        $this->profitPenalty = $profitPenalty;

        return $this;
    }

    public function getImage(): ?int
    {
        return $this->image;
    }

    public function setImage(int $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageNeeded(): ?int
    {
        return $this->imageNeeded;
    }

    public function setImageNeeded(int $imageNeeded): self
    {
        $this->imageNeeded = $imageNeeded;

        return $this;
    }

    public function getImagePenalty(): ?int
    {
        return $this->imagePenalty;
    }

    public function setImagePenalty(int $imagePenalty): self
    {
        $this->imagePenalty = $imagePenalty;

        return $this;
    }

    public function getUseTeamSize(): ?bool
    {
        return $this->useTeamSize;
    }

    public function setUseTeamSize(bool $useTeamSize): self
    {
        $this->useTeamSize = $useTeamSize;

        return $this;
    }

    public function getUseTeamType(): ?bool
    {
        return $this->useTeamType;
    }

    public function setUseTeamType(bool $useTeamType): self
    {
        $this->useTeamType = $useTeamType;

        return $this;
    }

    public function getUseTeamReliability(): ?bool
    {
        return $this->useTeamReliability;
    }

    public function setUseTeamReliability(bool $useTeamReliability): self
    {
        $this->useTeamReliability = $useTeamReliability;

        return $this;
    }

    public function getLoanRate(): ?int
    {
        return $this->loanRate;
    }

    public function setLoanRate(int $loanRate): self
    {
        $this->loanRate = $loanRate;

        return $this;
    }

    public function getLoanRateDiff(): ?int
    {
        return $this->loanRateDiff;
    }

    public function setLoanRateDiff(int $loanRateDiff): self
    {
        $this->loanRateDiff = $loanRateDiff;

        return $this;
    }

    public function getMaxTeams(): ?int
    {
        return $this->maxTeams;
    }

    public function setMaxTeams(int $maxTeams): self
    {
        $this->maxTeams = $maxTeams;

        return $this;
    }

    public function getLastPayment(): ?int
    {
        return $this->lastPayment;
    }

    public function setLastPayment(int $lastPayment): self
    {
        $this->lastPayment = $lastPayment;

        return $this;
    }

    public function getUseInterrogate(): ?bool
    {
        return $this->useInterrogate;
    }

    public function setUseInterrogate(bool $useInterrogate): self
    {
        $this->useInterrogate = $useInterrogate;

        return $this;
    }

    public function getInterrogatePercentage(): ?int
    {
        return $this->interrogatePercentage;
    }

    public function setInterrogatePercentage(int $interrogatePercentage): self
    {
        $this->interrogatePercentage = $interrogatePercentage;

        return $this;
    }

    public function getInterrogateImageCost(): ?int
    {
        return $this->interrogateImageCost;
    }

    public function setInterrogateImageCost(int $interrogateImageCost): self
    {
        $this->interrogateImageCost = $interrogateImageCost;

        return $this;
    }

    public function getForeplan(): ?int
    {
        return $this->foreplan;
    }

    public function setForeplan(int $foreplan): self
    {
        $this->foreplan = $foreplan;

        return $this;
    }

    public function getForeplanMax(): ?int
    {
        return $this->foreplanMax;
    }

    public function setForeplanMax(int $foreplanMax): self
    {
        $this->foreplanMax = $foreplanMax;

        return $this;
    }

    public function getAllowMultiplePlan(): ?bool
    {
        return $this->allowMultiplePlan;
    }

    public function setAllowMultiplePlan(bool $allowMultiplePlan): self
    {
        $this->allowMultiplePlan = $allowMultiplePlan;

        return $this;
    }

    public function getMultipleGamePlan(): ?int
    {
        return $this->multipleGamePlan;
    }

    public function setMultipleGamePlan(int $multipleGamePlan): self
    {
        $this->multipleGamePlan = $multipleGamePlan;

        return $this;
    }

    public function getUsePlanning(): ?bool
    {
        return $this->usePlanning;
    }

    public function setUsePlanning(bool $usePlanning): self
    {
        $this->usePlanning = $usePlanning;

        return $this;
    }

    public function getShowEvents(): ?bool
    {
        return $this->showEvents;
    }

    public function setShowEvents(bool $showEvents): self
    {
        $this->showEvents = $showEvents;

        return $this;
    }

    public function getDefaultPlan(): ?Plan
    {
        return $this->defaultPlan;
    }

    public function setDefaultPlan(?Plan $defaultPlan): self
    {
        $this->defaultPlan = $defaultPlan;

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }

}