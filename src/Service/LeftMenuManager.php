<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 22.08.2018 17:49
 */

namespace App\Service;


use App\Event\StateManagerChangedEvent;
use App\Menu\AbstractMenuItem;
use App\Menu\GroupItem;
use App\Menu\LinkItem;
use App\Entity;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class LeftMenuManager
{
    private $state;
    private $trans;
    private $router;
    private $requestStack;
    private $em;
    /* @var Entity\User */
    private $user;
    private $authChecker;

    private $menuChangedAfterInit = false;

    /**
     * @var array Menu items to be rendered in the menu
     */
    private $menu;

    public function __construct(StateManager $state, TranslatorInterface $translator, RouterInterface $router,
                                RequestStack $requestStack, ObjectManager $em, TokenStorageInterface $ts,
                                AuthorizationCheckerInterface $authChecker)
    {
        $this->state = $state;
        $this->trans = $translator;
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->em = $em;
        $this->authChecker = $authChecker;

        $state->addChangeListener([$this, 'onAppStateChange']);
        $this->initialize();
    }

    public function onAppStateChange(StateManagerChangedEvent $event)
    {
        if($this->menuChangedAfterInit) return;
        $reactOnKeys = ['currentProject', 'currentPlan'];
        if(in_array($event->getKey(), $reactOnKeys, true)) {
            $this->initialize();
        }
    }

    public function getMenu(): array
    {
        if(!$this->menuChangedAfterInit && is_null($this->menu)) $this->initialize();
        return $this->menu;
    }

    public function setMenu(array $menu): self
    {
        $this->menu = $menu;
        $this->menuChangedAfterInit = true;
        return $this;
    }

    public function findItem(string $menuItemId): ?AbstractMenuItem
    {
        return $this->findItemRecursiveHelper($this->menu, $menuItemId);
    }
    private function findItemRecursiveHelper($itemOrCollection, $menuItemId): ?AbstractMenuItem
    {
        if(is_object($itemOrCollection) && $itemOrCollection instanceof AbstractMenuItem) {
            if($itemOrCollection->getId() === $menuItemId) {
                return $itemOrCollection;
            }
        }
        if(is_iterable($itemOrCollection)) {
            foreach($itemOrCollection as $subItem) {
                $res = $this->findItemRecursiveHelper($subItem, $menuItemId);
                if(!is_null($res)) return $res;
            }
        }
        return null;
    }

    public function markActive(string $menuItemId): bool
    {
        $item = $this->findItem($menuItemId);
        if(!empty($item) && method_exists($item, 'setActive')) {
            $item->setActive(true);
            return true;
        }
        return false;
    }

    public function initialize()
    {
        if($this->menuChangedAfterInit) return;
        $this->menu = [];
        $masterRequest = $this->requestStack->getMasterRequest();
        /* @var $currentProject Entity\Project */
        $currentProject = $this->state->get('currentProject');
        /* @var $currentPlan Entity\Plan */
        $currentPlan = $this->state->get('currentPlan');
        $isAdmin = $this->state->get('isAdministration', false);

        if(!$isAdmin) {
            if(!empty($currentProject)) {
                $groupProject = new GroupItem('groupProject', $this->trans->trans('Projekt'));
                $this->menu[] = $groupProject;

//                if(empty($currentPlan)) $routesParams = ['project' => $currentProject->getId()];
//                else $routesParams = ['project' => $currentProject->getId(), 'plan' => $currentPlan->getId()];
                $routesParams = ['project' => $currentProject->getId()];


                $url = $this->router->generate('app_project_selectplan', ['project' => $currentProject->getId()]);
                $item = new LinkItem('selectPlan', $this->trans->trans('Výběr plánu'));
                $item->setIcon('assignment')->setLink($url);
                $groupProject->addItem($item);

//                $route = empty($currentPlan) ? 'app_project_description' : 'app_project_description2';
                $item = new LinkItem('projectDescription', $this->trans->trans('Popis'));
                $item->setIcon('format_align_left')->setLink($this->router->generate('app_project_description', $routesParams));
                $groupProject->addItem($item);

//                $route = empty($currentPlan) ? 'app_project_technologies' : 'app_project_technologies2';
                $item = new LinkItem('projectTechnologies', $this->trans->trans('Technologie'));
                $item->setIcon('build')->setLink($this->router->generate('app_project_technologies', $routesParams));
                $groupProject->addItem($item);

//                $route = empty($currentPlan) ? 'app_project_teams' : 'app_project_teams2';
                $item = new LinkItem('projectTeams', $this->trans->trans('Čety'));
                $item->setIcon('people')->setLink($this->router->generate('app_project_teams', $routesParams));
                $groupProject->addItem($item);

//                $route = empty($currentPlan) ? 'app_project_comments' : 'app_project_comments2';
                $item = new LinkItem('projectComments', $this->trans->trans('Diskuze'));
                $item->setIcon('comment')->setLink($this->router->generate('app_project_comments', $routesParams));
                $groupProject->addItem($item);

                $url = $this->router->generate('app_project_compareplans', ['project' => $currentProject->getId()]);
                $item = new LinkItem('comparePlans', $this->trans->trans('Srovnání plánů'));
                $item->setIcon('compare_arrows')->setLink($url);
                $groupProject->addItem($item);

                $url = $this->router->generate('app_project_selectgame', ['project' => $currentProject->getId()]);
                $item = new LinkItem('selectGame', $this->trans->trans('Realizace - druhá fáze'));
                $item->setIcon('play_arrow')->setLink($url);
                $groupProject->addItem($item);
            }


            if(!empty($currentPlan) && !$currentPlan->getIsInGame()) {
                $label = $this->trans->trans('Plán') .": {$currentPlan->getName()} ({$currentPlan->getId()})";
                $groupPlanning = new GroupItem('groupPlanning', $label);
                $this->menu[] = $groupPlanning;

                $url = $this->router->generate('app_plan_planning', ['plan' => $currentPlan->getId()]);
                $item = new LinkItem('planPlanning', $this->trans->trans('Plánování čet'));
                $item->setIcon('timeline')->setLink($url);
                $groupPlanning->addItem($item);

                $url = $this->router->generate('app_plan_gantt', ['plan' => $currentPlan->getId()]);
                $item = new LinkItem('planGantt', $this->trans->trans('Gantt'));
                $item->setIcon('clear_all')->setLink($url);
                $groupPlanning->addItem($item);

                $url = $this->router->generate('app_plan_cashflow', ['plan' => $currentPlan->getId()]);
                $item = new LinkItem('planCashflow', $this->trans->trans('Cash-flow'));
                $item->setIcon('bar_chart')->setLink($url);
                $groupPlanning->addItem($item);

                $url = $this->router->generate('app_plan_expenses', ['plan' => $currentPlan->getId()]);
                $item = new LinkItem('planExpenses', $this->trans->trans('Náklady'));
                $item->setIcon('account_balance_wallet')->setLink($url);
                $groupPlanning->addItem($item);

                $url = $this->router->generate('app_plan_validation', ['plan' => $currentPlan->getId()]);
                $item = new LinkItem('planValidation', $this->trans->trans('Validace'));
                $item->setIcon('done_all')->setLink($url);
                $groupPlanning->addItem($item);
            }


            if(!empty($currentPlan) && $currentPlan->getIsInGame()) {
                $label = $this->trans->trans('Realizace') .": {$currentPlan->getName()} ({$currentPlan->getId()})";
                $groupRealization = new GroupItem('groupRealization', $label);
                $this->menu[] = $groupRealization;

                $url = $this->router->generate('app_game_overview', ['plan' => $currentPlan->getId()]);
                $item = new LinkItem('gameOverview', $this->trans->trans('Přehled'));
                $item->setIcon('dashboard')->setLink($url);
                $groupRealization->addItem($item);

                $url = $this->router->generate('app_game_expenses', ['plan' => $currentPlan->getId()]);
                $item = new LinkItem('gameExpenses', $this->trans->trans('Náklady'));
                $item->setIcon('account_balance_wallet')->setLink($url);
                $groupRealization->addItem($item);

                $url = $this->router->generate('app_game_planning', ['plan' => $currentPlan->getId()]);
                $item = new LinkItem('gamePlanning', $this->trans->trans('Plánování čet'));
                $item->setIcon('timeline')->setLink($url);
                $groupRealization->addItem($item);

                $url = $this->router->generate('app_game_gantt', ['plan' => $currentPlan->getId()]);
                $item = new LinkItem('gameGantt', $this->trans->trans('Gantt'));
                $item->setIcon('clear_all')->setLink($url);
                $groupRealization->addItem($item);

                $url = $this->router->generate('app_game_cashflow', ['plan' => $currentPlan->getId()]);
                $item = new LinkItem('gameCashflow', $this->trans->trans('Cash-flow'));
                $item->setIcon('bar_chart')->setLink($url);
                $groupRealization->addItem($item);

                if($currentProject->getUseInterrogate()) {
                    $url = $this->router->generate('app_game_interrogate', ['plan' => $currentPlan->getId()]);
                    $item = new LinkItem('gameInterrogate', $this->trans->trans('Vyjednávat'));
                    $item->setIcon('call')->setLink($url);
                    $groupRealization->addItem($item);
                }
            }


            $groupGeneral = new GroupItem('groupGeneral', $this->trans->trans('Obecné'));
            $groupGeneral->setNotShowLabelIfFirstItem(true);
            $this->menu[] = $groupGeneral;

            $lecturePage = $this->em->getRepository(Entity\Page::class)->findOneForAppPage(
                'lecture'
            );
            if ($lecturePage) {
                $url = $this->router->generate('app_page_show', ['path' => $lecturePage->getPath()]);
                $item = new LinkItem('lecture', $this->trans->trans('Skripta'));
                $item->setIcon('school')->setLink($url);
                if ($masterRequest->attributes->get('_controller') === 'App\Controller\PageController::show') {
                    $quotedPath = preg_quote($lecturePage->getPath(), '#');
                    if (preg_match('#^' . $quotedPath . '/?#', $masterRequest->attributes->get('path'))) {
                        $item->setActive(true);
                    }
                }
                $groupGeneral->addItem($item);
            }

            $item = new LinkItem('selectProject', $this->trans->trans('Výběr projektu'));
            $item->setIcon('account_balance')->setLink($this->router->generate('app_user_profile'));
            $groupGeneral->addItem($item);


            if($this->authChecker->isGranted('ROLE_ADMIN') || !$this->user->getAllowedProjectEdits()->isEmpty()) {
                $groupForAdmin = new GroupItem('groupForAdmin', $this->trans->trans('Administrace'));
                $this->menu[] = $groupForAdmin;

                $item = new LinkItem('admin', $this->trans->trans('Editace projektů'));
                $item->setIcon('settings')->setLink('#!');
                $groupForAdmin->addItem($item);

                $item = new LinkItem('translationUi', $this->trans->trans('Editace překladů textů'));
                $item->setIcon('translate')->setLink($this->router->generate('jms_translation_index'));
                $groupForAdmin->addItem($item);
            }
        }
    }

}