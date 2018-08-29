<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 11.07.2018
 * Time: 17:37
 */

namespace App\DataFixtures;

use App\Config;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity;


class ExampleProjectFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct()
    {

    }

    public function load(ObjectManager $manager)
    {

        $project = new Entity\Project();
        $project->setTimeLimit(52)->setPrice(0)->setUseAdvances(true)->setTimePremium(50000)->setTimePenalty(30000)
            ->setPenaltyGrowth(10)->setProfitPremium(25)->setProfitPenalty(10)->setImage(0)->setImageNeeded(0)
            ->setImagePenalty(150000)->setUseTeamSize(false)->setUseTeamType(true)->setUseTeamReliability(true)
            ->setLoanRate(1500)->setLoanRateDiff(520000)->setMaxTeams(2)->setLastPayment(1750000)
            ->setUseInterrogate(true)->setInterrogatePercentage(100)->setInterrogateImageCost(0)
            ->setForeplan(6)->setForeplanMax(25)->setAllowMultiplePlan(true)->setMultipleGamePlan(1)
            ->setUsePlanning(true)->setDefaultPlan(null)->setSchool($this->getReference('school'));
        $project->translate('cs')->setName('Ekodům')->setPerex('<p>Projekt Banka</p>')->setDescription('<h2>Základní informace</h2><p>Cílem tohoto výukového projektu je postavit pasivní dům. Jste v roli manažera projektu, který je zodpovědný za to, aby byl tento dům postaven a to ideálně v termínu za co nejnižších možných nákladů. Hned na úvod je dobré připomenout, že toto je výukový projekt. Tedy v mnoha ohledech bylo použito zjednodušení, aby projekt nebyl příliš komplikovaný.Na jiných místech byl zase reálný stavební postup upraven a přizpůsoben potřebám výuky, tak aby vyvstaly určité zajímavé problémy a situace. Není snahou tohoto projektu vás naučit stavění domu (se vší související technickou stránkou), ale řízení projektu. I proto tu nejsou žádné konkrétní nákresy a obrázky domu, který stavíte.<br /><br />Doporučujeme projít si zde uvedené odkazy, pročíst související věci, tak abyste získali představu o projektu, který zde máte realizovat. A o tom, jak tyto věci vypadají v současné době v realitě, což pro vás může být později výhodou v praxi. Z toho si sami můžete udělat vlastní názor na tuto oblast.<br /><br />Dům, který stavíte, přijde zákazníka (z pohledu firmy, pro kterou projekt realizujete) na smluvených 3,5 milionu Kč. Jde o dům, který má přízemí a jedno nadzemní patro. Celková velikost podlahové plochy by měla být kolem 150 m2. Dům má přibližně obdélníkový a ucelený tvar, delší stranu s obytnými místnostmi směrem na jih, což je podstatné z hlediska tepelného. Tedy ideální podmínky pro splnění standardů pasivního domu. Je dobré se podívat zde na hlavní charakteristiky pasivního domu: <a target="_blank" href="http://www.pasivnidomy.cz/pasivni-dum/co-je-pasivni-dum.html"> <u>co-je-pasivní-dům</u> </a> Tato stavba bude mít spotřebu tepla přibližně na výrazně nizší úrovni než běžné stavby. Oproti třeba nezateplenému staršímu panelovému domu může být spotřeba víc jak 10&times; nizší na stejnou plochu bytu.<br /><br />Samozřejmě dosáhnutí takového izolačně-tepelného stavu znamená určité vícenáklady. Ty tvoří v Německu a Rakousku, kde je trh s tímto bydlením rozvinutější, kolem 5-10% ceny bytu či domu. U nás se zatím hovoří spíše o 10-15%, s ohledem na menší počet projektů a firem zabývajících se touto oblastí. V poslední době však dochází k výraznému nárůstu (efekty projektu Zelená úsporám, posun technických požadavků a standardů v rámci EU i ČR a další příčiny). Je nyní hodně firem, které nabízí stavby tohoto typu. Je však třeba si pohlídat zda mají kvalitní zkušenosti a odborné znalosti pro práci na takovýchto projektech. Problémy s kvalitou provedení těchto staveb mohou vést v výraznému poklesu výsledné energetické efektivity. Takže praktická realizace staveb, reference od zákazníků a uživatelů jsou a zůstanou jako vždy v oboru stavebnictví velmi zásadní záležitostí. Toto v nepřímé podobě zahrnuje projekt v podobě počítání &quot;image&quot;, jako třetího parametru vámi řízeného projektu, vedle &quot;nákladů&quot; a &quot;času&quot;. Detaily k tomuto jsou popsány až v oddílu věnujícím se realizaci herního projektu.<br /><br />Vámi stavěný dům nemá žádné klasické topení, to je nahrazeno vzduchotechnikou, která se stará jak o výměnu vzduchu, tak v případě potřeby o vytápění. Díky rekuperaci tepla, kvalitnímu zateplení a izolacím, lze dosáhnout měrné potřeby tepla kolem 15 kW na 1 m2 za rok. V rámci projektu domu, který stavíte, se tyto specifika objevují především v nadstandardní ceně položky &quot;Zateplení&quot; a pak zejména v položce &quot;Podhledy a vzduchotechnika&quot;. Podobně i cena &quot;Oken&quot; je vyšší než běžný průměr, jelikož musí jít o velmi kvalitní okna a navíc velice dobře utěsněná kolem rámu, což je často slabé místo, na které se příliš nedbá při výměně starších oken. <a target="_blank" href="http://www.pasivnidomy.cz/tepelna-ochrana/okna-a-dvere-pro-pasivni-domy.html"> </a>Při výstavbě musíte hlídat kvalitu zateplení a průvzdušnosti, protože zákazník si ve smlouvě vymínil po dokončení stavby provedení Blower Door testu. Toto je u staveb tohoto typu běžné, protože lze zkontrolovat skutečné parametry stavby. V rámci hry je kontrola kvality již zahrnuta rovnou do nákladů na jednotlivé práce, takže tyto práce stojí o něco více, jelikož se počítá s dlouhodobou účastí osoby, která se tomuto bude věnovat. Naštěstí pro vás toto je jeden z bodů, kterému se přímo aktivně v rámci hry věnovat nemusíte. Nebojte, i tak bude projekt pro vás pravděpodobně ne zcela jednoduchou výzvou .-)<br /><br />Pro doplnění zde popíšeme, co je a k čemu slouží zemní výměník, který máte v jedné z prací také zahrnut. Pro větrání je třeba někde mimo dům nasávat vzduch. Zemní výměník je vedení této nasávací trubky delší vzdálenost pod zemí. To má výhodu zejména v létě a z části i v zimě. V dostatečné hloubce pod zemí se udržuje stabilní teplota (podobně jako třeba v jeskyních), a může se tak zejména v létě využít přirozené ochlazování přiváděného vzduchu.<br /><br />K samotným zdrojům tepla lze říci toto. Jako zdroj tepla na vytápění nelze použít solární panely. Ty lze využívat po většinu roku jako pomocný zdroj třeba pro ohřev teplé vody a lze takto vykrýt nemalou část potřeby energie pro tento účel. Ale v zimním období výkon solárních panelů výrazně klesá. A tedy v období, kdy je třeba nejvíce energie pro vytápění, jí tento zdroj dodává minimum. Zdrojem by mohlo být tepelné čerpadlo, se kterým pak ale samozřejmě souvisí potřeba vyvrtání potřebných hloubkových sond. Další nejčastější možností je klasický kotel na elektřinu či plyn (dle dostupnosti), který se také často využívá kombinovaně jak na ohřev teplé vody, tak na teplovzdušné vytápění.<br />&nbsp;</p><h3>Parametry projektu</h3><p>Nyní ke konkrétnějším parametrům projektu, který máte řídit. Máte vytvořit plán stavby pasivního domu. A následně vámi vytvořený a validní plán realizovat. Tedy odehrát stavbu týden po týdnu až do jejího dokončení. Obě složky, jak plánování, tak realizace mají své výukové opodstatnění a obě vám toho mohou dost přinést. Velmi pravděpodobně mnohem časově náročnější část bude tvorba plánu, než samotná realizace.<br /><br />Stavbu domu máte zvládnout za 52 týdnů, tedy jeden rok. V rámci hry je jedno kolo počítáno jako jeden týden (kdekoliv se mluví o kolech, tak se myslí týdny). Samozřejmě během roku není počasí konstantní. Tedy jeho vliv bude vstupovat i do vašich plánů. Začínáte se stavbou na podzim a další podzim máte končit. Stavba se počítá a probíhá po týdnech. Jednotlivé dny se neřeší. Z pohledu počasí to znamená, že nějaký jednotlivý den se špatným počasím se zanedbává. A to, že ve hře nastane na týden třeba deštivé počasí, znamená, že je opravdu několik dní natolik špatné počasí, že to může zcela zablokovat některé práce.<br /><br />K počasí lze říci toto. Mezi 3. až 10. týdnem je období, kdy bývá (ale nemusí být) obvykle špatné deštivé počasí. Tedy každý z těchto týdnů je 10% šance, že bude deštivé počasí omezující některé práce. Čemu se nelze vyhnout vůbec je zima, která probíhá mezi 17. až 22. týdnem. Jde zde jak o venkovní teploty, tak především o určitá legislativní nařízení a omezení. Firmy využívají tyto vynucenou pauzu k plošným dovoleným pro zaměstnance. Pozor na to, že zima může přijít s 50% šancí o týden dřív a se stejnou šancí trvat o týden déle. 27. až 30. týden je měsícem, kdy bývá hodně větrno. Každý z těchto čtyř týdnů je 50% šance, že bude počasí tohoto typu. Mezi 38. až 40. týdnem je podobné období, ale šance na celotýdenní silně větrné počasí je vždy jen 25%. Mezi 45. až 48 týdnem pak je období, kdy z 33% hrozí silné deště. Mezi 55. až 62. týdnem se opakuje po roce opět období s 10% šancí na deště. Jednotlivá počasí se zobrazují i v Ganttově diagramu, a to jak to pevně dané období zimy, tak i odlišnou barvou se zobrazují období s potenciálem na nějaké špatné počasí (byť s ohledem na výše popsané pravděpodobnosti nakonec nastat nemusí). Poslední možný týden projektu je 66. týden. Tedy pokud nedokážete dokončit projekt při realizaci ani do tohoto týdne, tak jste jako projektový vedoucí kompletně selhali a byli odvoláni. Pokud si přečtete pořádně pravidla a další informace a rady ke hře, nemělo by vám takto výrazné přesáhnutí času projektu hrozit.<br /><br />Stavba domu je tvořena 18 pracemi, které je potřeba ve správném pořadí za sebou zrealizovat. Návaznosti prací jsou popsány v sekci &quot;Technologie&quot;. Jsou tam uvedené i omezení vyplývající z počasí. Práce se realizují pomocí tzv. &quot;čet&quot;. Četa popisuje jednoho zaměstnance a současně vybavení a materiál, který potřebuje vždy k dané práci. Je to tedy pro vás výrazné zjednodušení. Pokud chcete řešit stavbu stropu, použijete čety patřící k této práci. V sekci &quot;Plánování čet&quot; je budete přidávat do týdnů, které si vyberete. Každá četa vám z dané práce udělá nějaká % a až dosáhnete (či přesáhnete tam, kde to přesně nevychází) 100% dokončenosti, tak se tato práce dodělá. Toto vše vám zobrazuje jak sekce &quot;Plánování čet&quot; tak v určité jiné podobě i sekce &quot;Gannt&quot;.<br /><br />Čety mají dvě základní charakteristiky. Buď jde o vlastní čety, tedy o zaměstnance podniku, ve kterém pracujete i vy jako vedoucí projektu. Anebo jde o čety cizí. Tedy třeba o subdodavatele specifických prací a technologií, které neděláte pomocí svých lidí, případně slouží cizí čety k řešení paralelních prací, kde vám nestačí vlastní zaměstnanci. Vlastní čety jsou vždy spolehlivé. U cizích čet jsou některé označené jako nespolehlivé. V sekci &quot;Čety&quot; se můžete podívat na jejich charakteristiky. Spolehlivost je popsaná v % a tedy četa spolehlivá z 90% má jednoduše 10% šanci, že se na vámi naplánovanou práci během realizace nedostaví (z jakýchkoliv důvodů, ať už si třeba nasmlouvali práci i jinde apod.) V rámci realizace s tímto rizikem musíte počítat. Když nastane, tak to znamená, že se daná četa nedostavila a neodvedla naplánovanou práci. Toto již nejde nijak v daném proběhlém týdnu zachránit. Jediné co můžete a měli byste je zkontrolovat, zda je práce stále naplánovaná celá. Mnohdy po odpadnutí některých čet jednoduše přestane být práce naplánována ze 100% a je třeba doplnit během realizace k práci další čety, aby se práce někdy dodělala. SAMO OD SEBE se vám nic ve hře doplánovávat nebude!<br /><br />Vlastní čety máte vždy k dispozici 4. Jde o to, že máte na stavbě 4 dělníky, kteří jsou k ní přiřazení a které využíváte. Z vlastních zdrojů jich více mít nemůžete. Navíc a co je podstatné, všechny vlastní čety (pro různé práce) tvoří ti stejní dělníci. Tedy nikdy nemůžete v jednom týdnu využívat více než 4 vlastní čety celkově na všech pracích dohromady. Pomocí vám mohou být cizí čety. Ty se takto nekumulují, jelikož jde o různé dodavatele. Nevýhodou cizích čet je horší poměr mezi náklady a vytvořeným výkonem (dodavatel si ke svým nákladům dodá svou ziskovou marži, takže stejnou práci dělá z vašeho pohledu dráže než za kolik by ji vykonávali vaši vlastní lidi). A druhou nevýhodou některých cizích čet je jejich nespolehlivost, byť tyto nespolehlivé čety jsou naopak často docela levné (jde totiž často přímo o řemeslníky či živnostníky, které můžete využít jednorázově přímo za nasmlouvanou odměnu).<br /><br />Cílem fáze &quot;Plánování&quot; je vytvořit validní plán projektu. Tedy takový plán, který splní:<br />a) dokončenost všech prací (všechny práce naplánované alespoň na 100%)<br />b) technologickou návaznost prací (při zohlednění sekce &quot;Technologie&quot; - to, že práce na sebe navazují znamená, že v jednom týdnu dokončím předcházející práci a až v dalším následujícím týdnu můžu začít dělat tu navazující)<br />c) omezení čet (dostupných zdrojů, které máte - tedy neplánovat více než 4 vlastní čety do jednoho týdne apod. což se program snaží hlídat za vás a rovnou takové plánování ani neumožnit, ovšem pokud byste se snažili nějak tyto kontroly obejít, tak si nepomůžete)<br />d) vyřešení toků peněz (tedy nesmíte v žádném týdnu mít záporný stav konta, dorovnání peněž můžete samozřejmě vyřešit využitím nasmlouvaných půjček, vše v sekci &quot;Cash-flow&quot;, roční úroková míra je 15% ovšem úroky vám to zobrazuje rozpočítané a přiřazené na jednotlivé týdny). Zadávání splátek je lepší řešit až v realizaci, jelikož byť jediný přesun čety změní toky peněz. Při realizaci vám hra hlídá, abyste se nedostali do záporu a kdyžtak při řešení týdne dopůjčí potřebné peníze.<br /><br />Pokud jde o dodržení času projektu, tak to je na vás. Nemá moc smysl naplánovat projekt tak, že rovnou už dle plánu nesplníte datum dokončení. S takovým plánem při realizaci asi přílis dobře nedopadnete. Můžete vytvořit i více plánů. Často se to hodí, navíc je můžete porovnávat a pokoušet se najít nějaké z vašeho pohledu optimální řešení. Na tomto místě bychom chtěli zdůraznit potřebu REZERV. V rámci realizace se kromě špatného počasí mohou objevit další události, které svými důsledky mohou prodloužit realizaci některých prací. A pokud váš projekt (zejména práce na kritické cestě) nebude mít žádné vbudované doplněné rezervy, pak se vám rozsype nemalá část vašeho plánu. Rezervy mohou být buď v podobě volných týdnů mezi pracemi, nebo v podobě pomalejší realizace práce (než by byla při maximálním možném nasazení čet). Doporučená velikost rezerv pro tento typ výukového projektu, který máte realizovat, je kolem 10% celkového času projektu. Samozřejmě nejde jen o velikost rezerv ale i jejich rozvrstvení. Rovnou lze říci, že je velmi malá šance dokončit za 52 týdnů při realizaci projekt, který je naplánován na ten jeden rok a současně v podstatě bez rezerv. V realitě velikost rezerv závisí na oboru, typu projektu a mnoha dalších okolnostech.<br /><br />Při plánování je dobré si přečíst tutoriály k jednotlivým sekcím hry. Ke každé zobrazené straně je vpravo nahoře možné vyvolat nápovědu pod takto pojmenovaným odkazem. V ní jsou popsány většinou technické záležitosti vztahující se k dané stránce. Jedno upozornění: některé práce se navzájem vylučují. Takové práce nejen že nelze dělat současně v jednom týdnu, ale ani nelze takovou práci přerušit a snažit se mezitím dělat tu druhou. Tedy například ze sekce &quot;technologie&quot; jakmile jednou začnete dělat podlahy, tak dokud je zcela nedokončíte, nemůžete dělat omítky.<br />&nbsp;</p><h3>Realizace</h3><p>Pouze validní plán projektu lze následně převést do fáze &quot;Realizace&quot;. Velká část výsledku realizační části závisí na kvalitě použitého plánu, který jste k realizaci vybrali. Během realizace postupně v sekci &quot;Přehled&quot; posunujete čas, tedy odehráváte jednotlivé týdny. Hra vám vypisuje jaké je počasí a co se podstatného stalo:<br />- že byla nějaká práce z nějaké (pro návaznost prací) podstatné části či zcela dokončena<br />- že nenastoupily do práce nespolehlivé čety<br />- že nelze provádět nějaké práce (tedy že se ruší naplánované čety a jejich výkon), protože něco omezuje realizaci dané práci (většinou počasí, nějaká událost nebo nedokončení předchozí práce, bez které nemůže daná práce začít)<br />- že se stala nějaká nečekaná událost, kterou musíte řešit (během řešení události není možné upravovat čety, to lze řešit až poté, co události dořešíte a ukončíte tak provádění daného týdne)<br />Samozřejmě téměř na všechny výše popsané situace je třeba nějak reagovat. Zejména na ty negativní kontrolou a úpravou plánu čet, protože většina negativních událostí vede k neudělání nějakého kusu práce, co byl naplánován. Bez vašich zásahů a úprav se SAMO OD SEBE NIC NESPRAVÍ. A klikat rychle za sebou další týdny bez řešení nastalých problémů je pouze cesta k pozdnímu či absolutnímu nedokončení projektu! Úpravy čet během realizace jsou ovšem složitější, než během plánu. Nemůžete jen tak nasmlouvané cizí firmě říci, ať dorazí jindy. Ve hře jsou dopady těchto úprav vyjádřeny zjednodušeně dodatečnými náklady. Pokud zrušíte nějakou naplánovanou četu (nebo se vám zruší sama kvůli nějaké události, počasí apod. která nastala když měla četa nastoupit do práce), tak platíte jakési odškodné. To je různé podle toho o jakou četu jde, vesměs u cizích čet jsou tyto náklady odstoupení od smlouvy větší než u vlastních čet. Lepší a levnější možností (pokud o problému víte s předstihem a můžete tak reagovat) je četu přesunout do jiného týdne. Při přesunu zaplatíte menší sankci za zrušení původně plánovaného termínu práce (než při úplném zrušení čety). K této základní pokutě se přičte navíc určitá částka, podle toho jak moc dopředu o přesunu vyjednáváte. Základní částka za přesun se navyšuje, pokud přesouváte četu do některého z nejbližších 5 týdnů. Čím blíže aktuálnímu týdnu, tím je to dražší a roste to od 5% až po 25% nákladové ceny čety. Pokud dáváte dodavatelům málo času na reakci a úpravy, tak vás to stojí víc, protože je i pro ně problematické se vám přizpůsobit. Za přesun vlastních čet neplatíte nic, protože těm je jedno, kdy a na jakou práci je využíváte. Jejich úkolem je totiž podílet se na stavbě tohoto domu v podstatě po celou dobu projektu. Podobně jako se platí za přesun a zrušení čety, tak se platí i za doplnění nové čety během realizace. Podobně jako u přesunu čet platíte až 25% nákladů na četu, pokud narychlo přidáváte četu do nejbližšího týdne (klesá to až k 5% při přidávání na pět týdnů dopředu). Ve hře se toto označuje za náklady náboru. Za přidávání vlastních čet opět nic neplatíte. Za rušení vlastních čet ale ano. Takže pokud potřebujete doplnit k nějaké práci vlastní čety, většinou protože část výkonu nějak vypadla, pak je dobré prvně popřesouvat čety u navazujících prací dozadu (pokud si potřebujete uvolnit vlastní dělníky pro jinou práci) a teprve poté přidávat.<br />Technická poznámka: přesun čet oproti oddělání a přidání čety jsou dvě zásadně odlišné funkce. Přesun čet lze dělat jen v rámci jedné práce, jde o posouvání čet mezi týdny. Musíte přetáhnout daný týden myší (toto lze jen do týdne, který je zcela volný). Případně přetáhnout ikonku určitého typu čety, pak se přesune tolik čet toho typu, kolik lze. Pozor na maximum 4 vlastních čet v jednom týdnu na všechny práce, to vás bude nejčastěji omezovat. Tedy úprava plánu přes přesouvání znamená řešit to odzadu od poslední zasažené práce (většinou okolo nějaké umístěné rezervy) a postupné přesouvání čet z počátku prací na jejich konce, tak aby vznikaly volné týdny pro ty přesuny. Zrušení čety pomocí klinutí myší znamená u vlastních čet náklady.<br /><br />K událostem je dobré říci to, že když událost nastane, tak vám dá většinou na výběr z více variant řešení. U každého řešení jsou popsány OKAMŽITÉ dopady na projekt a jeho realizaci. Mohou to být různé dodatečné náklady, blokování nějaké práce, změna image projektu apod. Před výběrem řešení je dobré se zamyslet i nad možnými POZDĚJŠÍMI dopady tohoto řešení. Tedy zvážit opožděné následky a konsekvence, které nemusí být přímo u daných variant popsané, ale které si lze zdravým rozumem odvodit a jejich rizika domyslet. Během realizace projektu mohou některá vaše dřívější rozhodnutí omezit pozdější varianty nebo rovnou k nějaké směřovat.<br /><br />Podstatné je dokončení projektu a váš výsledek hry. Ten se počítá jako vaše dodatečná odměna za podmínky dokončení projektu. Projekt skončí ve chvíli, kdy se dodělá poslední práce. Pokud projekt dokončíte včas, pak získáte odměnu 50 000 Kč. A dále získáte 25% ze zisku projektu, tedy z rozdílu mezi 3,5 miliony Kč a celkovými náklady projektu při realizaci (v případě ztráty, což byste ale za žádnou cenu neměli dopustit, se započítá 10%). Pokud projekt nedokončíte za 52 týdnů, pak se vůči vám uplatní pokuta 30 000 Kč za každý týden překročení projektu + 10% základu navýšení oproti předchozímu týdnu. Tedy za první týden překročení se vám odečte celkově 33 000 Kč, za dva týdny překročení celkově 69 000 Kč, za čtyři týdny 150 000 Kč a za osm týdnů už to dělá celkově 348 000 Kč. Toto zohledňuje přímý dopad na vás za pokuty a penále, které vaši firmu postihnou za nedodržení smlouvy vůči zákazníkovi. Dále se vám odečte 150 000 Kč (za každý záporný bod), pokud koncová image projektu bude pod startovní hodnotou (což je 0). Výsledná záporná image říká, že jste poškodili pověst firmy, což může vést k problémům se získáváním budoucích zakázek v důsledku špatných referencí. Image se v průběhu realizace mění pouze v důsledku událostí, které nastávají, a to dle variant řešení, které si vyberete.<br />&nbsp;</p><p></p>

<p>&nbsp;&nbsp;&nbsp; LINK[prednaska1|Blok 1] - obsah prvního bloku<br />&nbsp;&nbsp;&nbsp; LINK[prikladgantt|Příklad gantt] - příklad ke ganttovu diagramu<br />&nbsp;&nbsp;&nbsp; LINK[ganttexcel|Ganttův diagram] - zde naleznete prázdný ganttův diagram<br/> </p>
<!--
&nbsp;&nbsp;&nbsp; LINK[prednaska2|Blok 2] - obsah druhého bloku<br />&nbsp;&nbsp;&nbsp; LINK[priklady2|Příklady k bloku 2] - příklady využité během bloku 2<br />&nbsp;&nbsp;&nbsp; LINK[prednaska3|Blok 3] - obsah třetího bloku</p><p>
-->');
        $project->mergeNewTranslations();
        $this->setReference('project', $project);
        $manager->persist($project);

        $playersProject = new Entity\PlayersProject($project, $this->getReference('admin'));
        $manager->persist($playersProject);

        $plan = new Entity\Plan(); //useful 1574
        $plan->setPlayersProject($playersProject)->translate('cs')->setName('Plán');
        $plan->mergeNewTranslations();
        $manager->persist($plan);

        $weathers = []; /* @var $weathers Entity\Weather[] */
        $ids = range(8,15);
        foreach($ids as $id) $weathers[$id] = new Entity\Weather();
        $weathers[8]->setColor('#ffffff')->translate('cs')->setName('příznivé počasí')->setDescription('');
        $weathers[9]->setColor('#008000')->translate('cs')->setName('deštivé počasí')->setDescription('Blokuje některé práce.');
        $weathers[10]->setColor('#f0e68c')->translate('cs')->setName('větrné počasí')->setDescription('Nelze provádět zejména zastřešování.');
        $weathers[11]->setColor('#0066FF')->translate('cs')->setName('zima')->setDescription('Nelze vůbec provádět venkovní práce. ');
        $weathers[12]->setColor('#adff2f')->translate('cs')->setName('může pršet')->setDescription('Mělo by být hezky, ale hrozí špatné počasí.');
        $weathers[13]->setColor('#00ff00')->translate('cs')->setName('hrozí deště')->setDescription('Mohlo by být hezky, ale dost hrozí špatné počasí.');
        $weathers[14]->setColor('#FFFF00')->translate('cs')->setName('hrozí větrno')->setDescription('Mělo by být hezky, ale hrozí větrné počasí.');
        $weathers[15]->setColor('#00ffff')->translate('cs')->setName('hrozí zima')->setDescription('Může přijít nebo ještě trvat zima.');
        foreach($weathers as $item) {
            $item->setProject($project)->mergeNewTranslations();
            $manager->persist($item);
        }

        $turns = []; /* @var $turns Entity\Turn[] */
        $ids = range(4101,4166);
        foreach($ids as $id) {
            $turns[$id] = new Entity\Turn();
            if($id >= 4103 && $id <= 4110) $turns[$id]->setWeather($weathers[12])->setChance(8)->setToWeather($weathers[9]);
            elseif($id == 4116) $turns[$id]->setWeather($weathers[15])->setChance(50)->setToWeather($weathers[11])->setIsPermanent(true);
            elseif($id >= 4117 && $id <= 4122) $turns[$id]->setWeather($weathers[11])->setToWeather($weathers[11]);
            elseif($id == 4123) $turns[$id]->setWeather($weathers[15])->setChance(50)->setToWeather($weathers[11]);
            elseif($id >= 4127 && $id <= 4130) $turns[$id]->setWeather($weathers[14])->setChance(50)->setToWeather($weathers[10]);
            elseif($id >= 4138 && $id <= 4140) $turns[$id]->setWeather($weathers[14])->setChance(23)->setToWeather($weathers[10]);
            elseif($id >= 4145 && $id <= 4148) $turns[$id]->setWeather($weathers[13])->setChance(27)->setToWeather($weathers[9]);
            elseif($id >= 4145 && $id <= 4148) $turns[$id]->setWeather($weathers[12])->setChance(10)->setToWeather($weathers[9]);
            else $turns[$id]->setWeather($weathers[8])->setToWeather($weathers[8]);
        }
        $turns[4101]->translate('cs')->setName('1');
        $num = 1;
        foreach($turns as $key => $item) {
            $item->setProject($project)->setNumber($num)->mergeNewTranslations();
            $manager->persist($item);
            $num++;
        }

        $works = []; /* @var $works Entity\Work[] */
        $ids = array_merge(range(821,829), range(832,839), range(842,845));
        foreach($ids as $id) $works[$id] = new Entity\Work();
        $works[845]->setPosition(21)->setCosts(100000)->setMaxTeams(3)->translate('cs')->setName('Rozvody 2');
        $works[844]->setPosition(15)->setCosts(100000)->setMaxTeams(3)->setColor('#9932cc')->setCumulative($works[845])->setPercents(50)
            ->translate('cs')->setAbbrev('Roz')->setName('Rozvody')->setDescription('Rozvody vody a celá elektroinstalace. Část se zabudovává do podlah a část do stěn. Lze provádět až po dokončení vnitřních zdí a také oken a krytiny (kvůli uzavření vnějším vlivům počasí)');
        $works[843]->setPosition(20)->setCosts(37500)->setMaxTeams(3)->translate('cs')->setName('Okna 2');
        $works[842]->setPosition(19)->setCosts(125000)->setMaxTeams(4)->translate('cs')->setName('Strop 2');
        $works[839]->setPosition(14)->setCosts(200000)->setMaxTeams(4)->setColor('#99FF00')
            ->translate('cs')->setAbbrev('Om')->setName('Omítky')->setDescription('Zarovnání a omítnutí všech vnitřních i vnějších stěn, tak aby bylo možno následně vymalovat. Lze provádět až po dokončení rozvodů, podhledů a po zateplení. Nelze současně provádět omítky a podlahy. ');
        $works[838]->setPosition(13)->setCosts(400000)->setMaxTeams(4)->setColor('#bdb76b')
            ->translate('cs')->setAbbrev('Zat')->setName('Zateplení')->setDescription('Kompletní zateplení a utěsnění (pro minimalizaci úniku vzduchu) obvodových zdí. Lze začít až po osazení 75% oken a dokončení krovu. A také musí již být dokončena kanalizace a zemní výměník, jelikož se kompletně dodělává a uzavírá vnější plášť.');
        $works[837]->setPosition(10)->setCosts(220000)->setMaxTeams(4)->setColor('#ffff00')
            ->translate('cs')->setAbbrev('PaV')->setName('Podhledy a vzduchotechnika')->setDescription('Podhledy v přízemí i pod střechou, do kterých se zabudovávají celé rozvody vzduchotechniky. Lze provádět až po dokončení krytiny, vnitřních zdí a oken. ');
        $works[836]->setPosition(11)->setCosts(75000)->setMaxTeams(3)->setColor('#ff6347')
            ->translate('cs')->setAbbrev('Pod')->setName('Podlahy')->setDescription('Dokončení podlah v celém domě, zarovnání a příprava na dlažbu. Lze provádět až po dokončení krytiny, vnitřních zdí a polovině rozvodů (zabudovávaných do podlah). Nelze současně provádět omítky a podlahy. ');
        $works[835]->setPosition(8)->setCosts(275000)->setMaxTeams(5)->setColor('#3399FF')
            ->translate('cs')->setAbbrev('Kro')->setName('Krov')->setDescription('Nosná konstrukce, na kterou lze následně položit krytinu a izolace. Lze stavět po dokončení stropu. ');
        $works[834]->setPosition(7)->setCosts(125000)->setMaxTeams(4)->setColor('#66CCFF')->setCumulative($works[842])->setPercents(50)
            ->translate('cs')->setAbbrev('Str')->setName('Strop')->setDescription('Lze stavět po dokončení nosných zdí. Vytváří strop nad přízemním patrem, na kterém lze následně budovat střechu. ');
        $works[833]->setPosition(6)->setCosts(130000)->setMaxTeams(4)->setColor('#9966FF')
            ->translate('cs')->setAbbrev('ZV')->setName('Zdi vnitřní')->setDescription('Zbylé zdi uvnitř domu. Lze stavět až po dokončení vnějších zdí a krovu. ');
        $works[832]->setPosition(2)->setCosts(130000)->setMaxTeams(2)->setColor('#F08080')
            ->translate('cs')->setAbbrev('KaV')->setName('Kanalizace a výměník')->setDescription('Realizace propojky kanalizace a také zemního výměníku pro vzduchotechniku. Lze začít až po dokončení výkopu základů. ');
        $works[829]->setPosition(18)->setCosts(15000)->setMaxTeams(4)->setColor('#FFFFCC')
            ->translate('cs')->setAbbrev('Úkl')->setName('Úklid')->setDescription('Finální uklizení staveniště a celého bytu. Lze provádět až po dokončení všech ostatních prací. ');
        $works[828]->setPosition(16)->setCosts(250000)->setMaxTeams(5)->setColor('#a0522d')
            ->translate('cs')->setAbbrev('Dla')->setName('Dlažba')->setDescription('Osazení plovoucích podlah v místnostech, pokrytí schodů a dlažeb (WC, koupelna, kolem kuchyňské linky apod.) Součástí je i vbudované vybavení WC a koupelny. Lze provádět až po dokončení podlah a omítek. Nelze provádět současně s malováním.');
        $works[827]->setPosition(17)->setCosts(30000)->setMaxTeams(3)->setColor('#99CCCC')
            ->translate('cs')->setAbbrev('Mal')->setName('Malování')->setDescription('Vymalování celého bytu. Lze provádět až po dokončení omítek. Nelze provádět současně s dlažbou. ');
        $works[826]->setPosition(12)->setCosts(112500)->setMaxTeams(3)->setColor('#b8860b')->setCumulative($works[843])->setPercents(75)
            ->translate('cs')->setAbbrev('Okn')->setName('Okna')->setDescription('Osazení oken do obvodové zdi a střechy. Většinu (75%) oken lze zasadit po dokončení obvodových zdí. Zbytek až po dokončení krovu. ');
        $works[825]->setPosition(9)->setCosts(300000)->setMaxTeams(4)->setColor('#00FFFF')
            ->translate('cs')->setAbbrev('KaI')->setName('Krytina a izolace')->setDescription('Pokládání krytiny na krov a také různé vrstvy a typy izolace. Lze provádět až po dokončení krovu. ');
        $works[824]->setPosition(5)->setCosts(130000)->setMaxTeams(4)->setColor('#CC99FF')
            ->translate('cs')->setAbbrev('ZO')->setName('Zdi obvodové')->setDescription('Doplnění vnějších zdí, tak aby bylo možno následně zasadit okna a stavbu uzavřít vůči vnějším vlivům. Lze stavět až po dokončení nosných zdí a hotové polovině stropu (kvůli nosným konstrukcím). ');
        $works[823]->setPosition(4)->setCosts(260000)->setMaxTeams(4)->setColor('#C71585')
            ->translate('cs')->setAbbrev('ZN')->setName('Zdi nosné')->setDescription('Základní zdi, bez nichž nelze řešit strop ani ostatní části zdí. Lze začít až po dokončení základů domu. ');
        $works[822]->setPosition(3)->setCosts(350000)->setMaxTeams(4)->setColor('#FF8C00')
            ->translate('cs')->setAbbrev('ZD')->setName('Základy domu')->setDescription('Základová deska a potřebné izolace. Lze provádět až po dokončení výkopu základů. ');
        $works[821]->setPosition(1)->setCosts(150000)->setMaxTeams(4)->setColor('#808000')
            ->translate('cs')->setAbbrev('KZ')->setName('Kopání základů')->setDescription('Počátek celé stavby. Je třeba vykopat základy domu a upravit celou stavební plochu. ');
        foreach($works as $item) {
            $item->setProject($project)->mergeNewTranslations();
            $manager->persist($item);
        }

        $arrWorkDependencies = [
            [821, 822, 0], [822, 823, 0], [823, 824, 0], [827, 828, 1], [834, 824, 0], [824, 833, 0], [835, 825, 0],
            [825, 837, 0], [835, 833, 0], [833, 836, 0], [825, 836, 0], [826, 838, 0], [835, 838, 0], [824, 826, 0],
            [821, 832, 0], [832, 838, 0], [823, 834, 0], [833, 837, 0], [838, 839, 0], [837, 839, 0], [836, 828, 0],
            [839, 827, 0], [827, 829, 0], [828, 829, 0], [839, 828, 0], [839, 828, 1], [839, 836, 1], [843, 844, 0],
            [833, 844, 0], [825, 844, 0], [845, 839, 0], [844, 836, 0], [843, 837, 0], [842, 835, 0], [835, 843, 0],
        ];
        foreach($arrWorkDependencies as $dep) {
            $item = new Entity\WorkDependency();
            $item->setPrevious($works[$dep[0]])->setNext($works[$dep[1]])->setIsMutual($dep[2]);
            $manager->persist($item);
        }

        $arrWorkWeather = [];
        $arrWorkWeather[9] = [821, 822, 823, 824, 825, 826, 832, 834, 835, 838];
        $arrWorkWeather[11] = [821, 822, 823, 824, 832, 834];
        $arrWorkWeather[10] = [825, 835];
        foreach($arrWorkWeather as $we => $arr) {
            foreach($arr as $wo) {
                $item = new Entity\WorkWeather();
                $item->setWork($works[$wo])->setWeather($weathers[$we]);
                $manager->persist($item);
            }
        }

        $icons = [];
        foreach(range(1, 3) as $id) {
            if(!file_exists(Config::getUploadPath('icon'))) mkdir(Config::getUploadPath('icon'), 0777, true);
            copy(__DIR__ .'/assets/man0'. $id .'.gif', Config::getUploadPath('icon') .'/man0'.$id.'.gif');
            $icons[$id] = new Entity\Icon();
            $icons[$id]->setProject($project)->setFilename('/man0'.$id.'.gif')->translate('cs')->setName('man0'.$id);
            $icons[$id]->mergeNewTranslations();
            $manager->persist($icons[$id]);
        }

        $teamCumulatives = [ 5 => new Entity\TeamCummulation() ]; /* @var $teamCumulatives Entity\TeamCummulation[] */
        $teamCumulatives[5]->setProject($project)->setMaxCount(4)->translate('cs')->setName('námezdní dělníci');
        $teamCumulatives[5]->mergeNewTranslations();
        $manager->persist($teamCumulatives[5]);

        $teams = []; /* @var $teams Entity\Team[] */
        $ids = array_merge([337, 338], [340], [342, 343], range(345,366));
        foreach($ids as $id) $teams[$id] = new Entity\Team();
        $teams[337]->setPosition(28)->setProductivity(4000)->setCosts(3000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[829])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[338]->setPosition(20)->setProductivity(6500)->setCosts(4500)->setReliability(100)->setMaxCount(3)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[836])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[340]->setPosition(26)->setProductivity(10000)->setCosts(7500)->setReliability(100)->setMaxCount(3)
            ->setPenaltyOff(4000)->setPenaltyMove(2000)->setCumulative(null)->setIcon($icons[1])->setWork($works[827])
            ->translate('cs')->setName('cizí')->setStyle('17')->setType('16')->setSize('9');
        $teams[342]->setPosition(21)->setProductivity(37500)->setCosts(30000)->setReliability(100)->setMaxCount(3)
            ->setPenaltyOff(5000)->setPenaltyMove(2500)->setCumulative(null)->setIcon($icons[1])->setWork($works[826])
            ->translate('cs')->setName('cizí')->setStyle('17')->setType('16')->setSize('9');
        $teams[343]->setPosition(17)->setProductivity(30000)->setCosts(22500)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[825])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[345]->setPosition(1)->setProductivity(10000)->setCosts(7500)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(1000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[821])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[346]->setPosition(6)->setProductivity(12500)->setCosts(9000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[822])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[347]->setPosition(7)->setProductivity(9500)->setCosts(7000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[823])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[348]->setPosition(9)->setProductivity(8250)->setCosts(6000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[824])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[349]->setPosition(11)->setProductivity(8250)->setCosts(6000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[833])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[350]->setPosition(3)->setProductivity(15000)->setCosts(11000)->setReliability(100)->setMaxCount(2)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[832])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[351]->setPosition(4)->setProductivity(15000)->setCosts(8000)->setReliability(90)->setMaxCount(2)
            ->setPenaltyOff(2000)->setPenaltyMove(1000)->setCumulative(null)->setIcon($icons[2])->setWork($works[832])
            ->translate('cs')->setName('cizí nesp.')->setStyle('17')->setType('17')->setSize('9');
        $teams[352]->setPosition(2)->setProductivity(10000)->setCosts(6000)->setReliability(90)->setMaxCount(4)
            ->setPenaltyOff(2000)->setPenaltyMove(1000)->setCumulative(null)->setIcon($icons[2])->setWork($works[821])
            ->translate('cs')->setName('cizí nesp.')->setStyle('17')->setType('17')->setSize('9');
        $teams[353]->setPosition(13)->setProductivity(12500)->setCosts(9000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[834])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[354]->setPosition(15)->setProductivity(11000)->setCosts(8250)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[835])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[355]->setPosition(18)->setProductivity(15000)->setCosts(11000)->setReliability(100)->setMaxCount(2)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[837])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[356]->setPosition(19)->setProductivity(45000)->setCosts(35000)->setReliability(100)->setMaxCount(2)
            ->setPenaltyOff(6000)->setPenaltyMove(3000)->setCumulative(null)->setIcon($icons[1])->setWork($works[837])
            ->translate('cs')->setName('cizí')->setStyle('17')->setType('16')->setSize('9');
        $teams[357]->setPosition(22)->setProductivity(35000)->setCosts(25000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[838])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[358]->setPosition(23)->setProductivity(50000)->setCosts(35000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(0)->setCumulative($teamCumulatives[5])->setIcon($icons[3])->setWork($works[839])
            ->translate('cs')->setName('vlastní')->setStyle('16')->setType('16')->setSize('9');
        $teams[359]->setPosition(25)->setProductivity(50000)->setCosts(40000)->setReliability(100)->setMaxCount(5)
            ->setPenaltyOff(4000)->setPenaltyMove(2000)->setCumulative(null)->setIcon($icons[1])->setWork($works[828])
            ->translate('cs')->setName('cizí')->setStyle('17')->setType('16')->setSize('9');
        $teams[360]->setPosition(27)->setProductivity(10000)->setCosts(5000)->setReliability(75)->setMaxCount(3)
            ->setPenaltyOff(2000)->setPenaltyMove(1000)->setCumulative(null)->setIcon($icons[2])->setWork($works[827])
            ->translate('cs')->setName('cizí nesp.')->setStyle('17')->setType('17')->setSize('9');
        $teams[361]->setPosition(8)->setProductivity(9500)->setCosts(8000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(2000)->setCumulative(null)->setIcon($icons[1])->setWork($works[823])
            ->translate('cs')->setName('cizí')->setStyle('17')->setType('16')->setSize('9');
        $teams[362]->setPosition(10)->setProductivity(8250)->setCosts(7000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(2000)->setCumulative(null)->setIcon($icons[1])->setWork($works[824])
            ->translate('cs')->setName('cizí ')->setStyle('17')->setType('16')->setSize('9');
        $teams[363]->setPosition(12)->setProductivity(8250)->setCosts(7000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(2000)->setCumulative(null)->setIcon($icons[1])->setWork($works[833])
            ->translate('cs')->setName('cizí')->setStyle('17')->setType('16')->setSize('9');
        $teams[364]->setPosition(14)->setProductivity(12500)->setCosts(11000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(2000)->setCumulative(null)->setIcon($icons[1])->setWork($works[834])
            ->translate('cs')->setName('cizí')->setStyle('17')->setType('16')->setSize('9');
        $teams[365]->setPosition(16)->setProductivity(11000)->setCosts(10000)->setReliability(100)->setMaxCount(4)
            ->setPenaltyOff(3000)->setPenaltyMove(2000)->setCumulative(null)->setIcon($icons[1])->setWork($works[835])
            ->translate('cs')->setName('cizí')->setStyle('17')->setType('16')->setSize('9');
        $teams[366]->setPosition(24)->setProductivity(35000)->setCosts(25000)->setReliability(100)->setMaxCount(3)
            ->setPenaltyOff(5000)->setPenaltyMove(2500)->setCumulative(null)->setIcon($icons[1])->setWork($works[844])
            ->translate('cs')->setName('cizí')->setStyle('17')->setType('16')->setSize('9');
        foreach($teams as $item) {
            $item->setProject($project)->mergeNewTranslations();
            $manager->persist($item);
        }

        $events = []; /* @var $events Entity\Event[] */
        $ids = array_merge(range(68,76), range(78,82));
        foreach($ids as $id) $events[$id] = new Entity\Event();
        $events[68]->setChance(100)->translate('cs')->setName('Úvodní varování')->setDescription('Ještě jednou připomínáme, že hra za vás nic sama nevyřeší. Pokud dojde během provádění nějakého týdne projektu k zablokování práce (kvůli počasí, nějaké události, nedokončené předchozí práci apod.), tak se vám automaticky zruší čety přiřazené k takovéto blokované práci. Tím se zruší část výkonu, který jste plánovali a většinou to vede k tomu, že daná práce již není naplánovaná ze 100% a tedy nemá žádný očekávaný termín dokončení. To je vidět dobře v Ganttově diagramu. Bez toho, že dořešíte tyto následky (většinou to znamená doplánovat či přeplánovat čety), včetně důsledků pro navazující práce, tak se vám může časová realizace projektu rozpadnout nebo zcela zhroutit. ');
        $events[69]->setChance(100)->translate('cs')->setName('Přívalový déšť')->setDescription('<p>Bohužel vás počasí poprvé pořádně zazlobilo. Vlivem velmi silného deště došlo k menším sesuvům zeminy ve výkopu základů.</p>');
        $events[70]->setChance(100)->translate('cs')->setName('Stížnosti sousedů')->setDescription('Sousedé si stěžují, že bláto ze stavebních strojů pracujících na základech domu příliš znečišťuje okolní cesty a vozovky. Žádají nápravu.');
        $events[71]->setChance(50)->translate('cs')->setName('Pozdní dodávka')->setDescription('Dodavatel atypických těžko sehnatelných nosných konstrukcí pro strop má zpoždění. Nosníky, které měly dorazit na stavbu a jsou zrovna akutně potřeba, budou dodány až o týden později. ');
        $events[72]->setChance(100)->translate('cs')->setName('Stížnosti dělníků')->setDescription('Dělníci si stěžují na bezpečnost práce. Zejména jde o stavbu krovu, tedy o práce prováděné ve větší výšce za současného ne zcela pěkného počasí. Žádají dodatečné jistící vybavení. ');
        $events[73]->setChance(100)->translate('cs')->setName('Vlhká podlaha')->setDescription('Firma pokládající podlahy dorazila na stavbu. Provedli kontrolní měření vlhkosti podkladových podlah. Naměřené hodnoty jsou vysoké. ');
        $events[74]->setChance(100)->translate('cs')->setName('Vysoušení')->setDescription('Vysoušení podlah v důsledku výrazných posunů vlhkosti, pohybu vzduchu i samotných vysoušecích strojů, znemožnuje i malování. ');
        $events[75]->setChance(50)->translate('cs')->setName('Úraz dělníka')->setDescription('Při stavbě krovu došlo k úrazu dělníka. Zranění sice není vážné, ale ani zcela bezvýznamné. Navíc se nám na stavbě objevila inspekce (kontrola BOZP = bezpečnost a ochrana zdraví při práci) a vyšetřuje okolnosti tohoto případu. ');
        $events[76]->setChance(50)->translate('cs')->setName('Zranění dělníka')->setDescription('Došlo k drobnému úrazu při stavbě krovu. Naštěstí (i díky pořízeným pomůckám) nešlo o nic vážného a dělník mohl hned další den přijít do práce. ');
        $events[78]->setChance(100)->translate('cs')->setName('Krádež na stavbě')->setDescription('Někdo se vloupal na staveniště a odcizil střešní krytinu. Sousedé se s vámi moc nechtějí bavit (od událostí okolo špinavách silnic vás nemají moc v lásce). Nikdo prý nic neviděl. Policie nic nevypátrala. ');
        $events[79]->setChance(100)->translate('cs')->setName('Drobná krádeže na stavbě')->setDescription('Někdo odcizil část nachystaných střešních krytin. Naštěstí jeden ze sousedů (se kterým jsme projednávali na počátku stavby čištění silnic od bláta) si všiml něčeho podezřelého, šel se podívat a zloděje vystrašil, takže ukradli jen třetinu nachystané krytiny. Sice se jim podařilo zmizet, aniž je pořádně viděl, ale každopádně se už podle všeho nevrátí. ');
        $events[80]->setChance(100)->translate('cs')->setName('Pokus o krádež na stavbě')->setDescription('<p>Dva zloději se pokusili ukrást střešní krytinu nachystanou k pokládání. Naštěstí díky všímavosti sousedů, se kterými máme od vyřešení zablácených silnic dobré vztahy, dorazila na místo policie a podařilo se zloděje chytit. Žádná škoda na naší stavbě tak nenastala.</p>');
        $events[81]->setChance(100)->translate('cs')->setName('Úklid staveniště')->setDescription('V rámci úklidu staveniště můžeme projevit i dobrou vůli vůči sousedům (když jsme se k nim nechovali na počátku stavby moc dobře). ');
        $events[82]->setChance(100)->translate('cs')->setName('Zkroucená podlaha')->setDescription('V důsledku postupného vysychání došlo pár týdnů po dokončení k drobným zkroucením podlahových krytin. Zákazníci chtějí opravu. ');
        foreach($events as $item) {
            $item->setProject($project)->mergeNewTranslations();
            $manager->persist($item);
        }

        $eventVariants = []; /* @var $eventVariants Entity\EventVariant[] */
        $ids = array_merge(range(90,103), range(105,110));
        foreach($ids as $id) $eventVariants[$id] = new Entity\EventVariant();
        $eventVariants[90]->setEvent($events[69])->setNext(NULL)->setWork($works[821])->setProductivity(20000)
            ->setCosts(0)->setImage(0)->setTurns(0)->translate('cs')->setName('Sesuvy půdy do výkopu')->setDescription('Část udělané práce ja znehodnocena a bude ji třeba opravit. Část práce kopání základů v hodnotě výkonu 20 000 Kč je znehodnocena (klesne vám % dokončennosti) a je třeba ji udělat znova. ');
        $eventVariants[91]->setEvent($events[68])->setNext(NULL)->setWork($works[821])->setProductivity(0)
            ->setCosts(0)->setImage(0)->setTurns(0)->translate('cs')->setName('Beru na vědomí')->setDescription('');
        $eventVariants[92]->setEvent($events[70])->setNext(NULL)->setWork($works[821])->setProductivity(0)
            ->setCosts(0)->setImage(-1)->setTurns(0)->translate('cs')->setName('Ignorace')->setDescription('Sousedé si stěžují neoprávněně. Když sami stavěli svůj dům, tak nebyli o nic lepší. Když dva či tři týdny počkají, až budou výkopy hotové, tak bláto ze silnic zmizí samo a bude po problému. ');
        $eventVariants[93]->setEvent($events[70])->setNext(NULL)->setWork($works[821])->setProductivity(0)
            ->setCosts(5000)->setImage(0)->setTurns(0)->translate('cs')->setName('Částečné akceptace')->setDescription('Kvůli občasným přeháňkám a rozměklé půdě je bláta po okolí opravdu hodně. Zajistíme částečný úklid toho nejhoršího, tak aby stížnosti přestaly. Bude nás to stát 5 000 Kč. ');
        $eventVariants[94]->setEvent($events[70])->setNext(NULL)->setWork($works[821])->setProductivity(0)
            ->setCosts(10000)->setImage(1)->setTurns(0)->translate('cs')->setName('Snaha vyhovět')->setDescription('Pokusíme se sousedům plně vyhovět a budeme se snažit udržovat čistotu okolí stavby na co nejlepší úrovni. Bude nás to stát 10 000 Kč.');
        $eventVariants[95]->setEvent($events[71])->setNext(NULL)->setWork($works[834])->setProductivity(0)
            ->setCosts(-25000)->setImage(0)->setTurns(1)->translate('cs')->setName('Posun práce')->setDescription('Bez těchto prvků nelze tento týden pokračovat v budování stropu. Jediné pozitivum je, že dodavatel musí uhradit smluvní pokutu ve výši 25 000 Kč, která nám vynahradí část škod. Se zpožděním práce si ale musíme poradit sami. ');
        $eventVariants[96]->setEvent($events[72])->setNext(NULL)->setWork($works[835])->setProductivity(0)
            ->setCosts(0)->setImage(0)->setTurns(0)->translate('cs')->setName('Není potřeba')->setDescription('Dělníci už mají dostatečné vybavení pro práci. Navíc nepracují v žádné závratné výšce, ale nad stropem přízemí tedy sotva kousek nad zemí. ');
        $eventVariants[97]->setEvent($events[72])->setNext(NULL)->setWork($works[835])->setProductivity(0)
            ->setCosts(12000)->setImage(0)->setTurns(0)->translate('cs')->setName('Pořídíme')->setDescription('Dělníci sice mají postarší vybavení, ale projevíme dobrou vůli a pořídíme nějaké dodatečné nové (byť ne zcela levné) jistící prostředky. Bude nás to stát 12 000 Kč.');
        $eventVariants[98]->setEvent($events[73])->setNext(NULL)->setWork($works[828])->setProductivity(0)
            ->setCosts(0)->setImage(0)->setTurns(0)->translate('cs')->setName('Necháme udělat podlahu')->setDescription('Dodavatel je ochoten práci udělat, ovšem s tím, že neponese riziko následků vlhkosti. V důsledku vlhkosti by mohlo dojít později k vydutí a pokroucení hotových podlah.');
        $eventVariants[99]->setEvent($events[73])->setNext($events[74])->setWork($works[828])->setProductivity(0)
            ->setCosts(12500)->setImage(0)->setTurns(1)->translate('cs')->setName('Zaplatíme vysoušení')->setDescription('Necháme dodat a zaplatíme speciální vysoušeče. Po týdnu v provozu by mělo být vše kolem vlhkosti v pořádku. Nevýhodou je, že během vysoušení nelze provádět nejen dlažbu, ale ani malování. Bude nás to stát 12 500 Kč.');
        $eventVariants[100]->setEvent($events[73])->setNext(NULL)->setWork($works[828])->setProductivity(0)
            ->setCosts(0)->setImage(0)->setTurns(2)->translate('cs')->setName('Počkáme')->setDescription('Vlhkost z čerstvých podlah zmizí i sama, je jen třeba počkat dva týdny, než se to samo přirozeně spraví. Tedy nejbližší dva týdny nemůžeme provádět pokládání podlah. ');
        $eventVariants[101]->setEvent($events[74])->setNext(NULL)->setWork($works[827])->setProductivity(0)
            ->setCosts(0)->setImage(0)->setTurns(1)->translate('cs')->setName('Vysoušíme')->setDescription('Do jedné varianty nelze dát více blokací prací. V důsledku vysoušení tedy nelze ani provádět v nejbližším týdnu malování. ');
        $eventVariants[102]->setEvent($events[75])->setNext(NULL)->setWork($works[835])->setProductivity(20000)
            ->setCosts(5000)->setImage(0)->setTurns(0)->translate('cs')->setName('Inspekce')->setDescription('Prošetřování události a kontrola podmínek BOZP nám částečně omezovali provádění prací na krovu. Prováděný výstup je o 20 000 Kč nižší, než měl být. Kromě toho jsme za drobné nedostatky dostali od inspekce pokutu 5 000 Kč. ');
        $eventVariants[103]->setEvent($events[76])->setNext(NULL)->setWork($works[835])->setProductivity(1500)
            ->setCosts(0)->setImage(0)->setTurns(0)->translate('cs')->setName('Drobné omezení')->setDescription('V důsledku události nemohl daný dělník provést část denní práce. Tedy neprovedl naplánovaný výkon na práci "krov" v objemu 1500 Kč. ');
        $eventVariants[105]->setEvent($events[78])->setNext(NULL)->setWork($works[825])->setProductivity(0)
            ->setCosts(25000)->setImage(0)->setTurns(0)->translate('cs')->setName('Dokoupíme')->setDescription('Naštěstí nějaká krytina zůstala a práce může pokračovat. Musíme však dokoupit odcizenou krytinu, což nám zvedne náklady o 25 000 Kč. ');
        $eventVariants[106]->setEvent($events[79])->setNext(NULL)->setWork($works[825])->setProductivity(0)
            ->setCosts(10000)->setImage(0)->setTurns(0)->translate('cs')->setName('Nakoupíme')->setDescription('Naštěstí se díky všímavosti sousedů ztratila jen část materiálu. Práci na pokládání střechy to neomezuje, budeme muset akorát dokoupit část krytiny znova, což nás bude stát dodatečných 10 000 Kč. ');
        $eventVariants[107]->setEvent($events[80])->setNext(NULL)->setWork($works[825])->setProductivity(0)
            ->setCosts(0)->setImage(0)->setTurns(0)->translate('cs')->setName('Vše v pohodě')->setDescription('Naštěstí se nám vstřícné jednání a dobré vztahy se sousedy vyplatily. ');
        $eventVariants[108]->setEvent($events[81])->setNext(NULL)->setWork($works[829])->setProductivity(0)
            ->setCosts(10000)->setImage(1)->setTurns(0)->translate('cs')->setName('Dodatečný úklid')->setDescription('Můžeme nabídnout sousedům okolo staveniště nadstandardní úklid zahrnující i částečně jejich přilehlé pozemky. Ziskem pro nás bude zlepšení pověsti firmy. Dodatečné náklady budou činit 10 000 Kč. ');
        $eventVariants[109]->setEvent($events[81])->setNext(NULL)->setWork($works[829])->setProductivity(0)
            ->setCosts(0)->setImage(0)->setTurns(0)->translate('cs')->setName('Nepotřebujeme')->setDescription('Nemáme zájem o něco takového. Sousedi jsou nám jedno a alespoň ušetříme náklady. ');
        $eventVariants[110]->setEvent($events[82])->setNext(NULL)->setWork($works[829])->setProductivity(0)
            ->setCosts(20000)->setImage(-2)->setTurns(0)->translate('cs')->setName('Dodatečné náklady')->setDescription('Jelikož projekt (a hra) končí úklidem, který v tomto týdnu provádíte, je třeba takovýto budoucí dopad navázat k poslední práci. V rámci oprav podlahových krytin se náklady projektu zvýší o 20 000 Kč. Navíc se zákazníci dozvěděli od člověka provádějícího opravu o skutečné příčině (pokládání na vlhkou podlahu) a berou takové jednání jako nesolidní, což má dopad na pověst  firmy, kterou o ní budou šířit. ');

        foreach($eventVariants as $item) {
            $item->mergeNewTranslations();
            $manager->persist($item);
        }

        $arrEventPrevious = [ [92, 78], [92, 81], [93, 79], [94, 80], [96, 75], [97, 76], [98, 82], [99, 74] ];
        foreach($arrEventPrevious as $dep) {
            $item = new Entity\EventPrevious();
            $item->setPrevious($eventVariants[$dep[0]])->setCurrent($events[$dep[1]])->setIsNeeded(1);
            $manager->persist($item);
        }

        $arrEventWorkDependency = [
            [69, 821, 0, 25], [70, 821, 0, 60], [71, 834, 0, 20], [72, 835, 1, 0], [73, 828, 1, 0],
            [74, 827, 0, 0],  [75, 835, 0, 25], [76, 835, 0, 25], [78, 825, 1, 0], [79, 825, 1, 0],
            [80, 825, 1, 0],  [81, 829, 1, 0], [82, 829, 1, 0],
        ];
        foreach($arrEventWorkDependency as $dep) {
            $item = new Entity\EventWorkDependency();
            $item->setEvent($events[$dep[0]])->setWork($works[$dep[1]])->setIsRunning($dep[2])->setState($dep[3]);
            $manager->persist($item);
        }

        $arrAdvances = [
            ['3. část hypotéky', 4140, 750000], ['2. část hypotéky', 4120, 500000], ['1. část hypotéky', 4101, 250000]
        ];
        foreach($arrAdvances as $ad) {
            $item = new Entity\Advance();
            $item->setProject($project)->setTurn($turns[$ad[1]])->setAmount($ad[2])->translate('cs')->setName($ad[0]);
            $item->mergeNewTranslations();
            $manager->persist($item);
        }

        $slot = new Entity\PlanSlotTeam();
        $slot->setPlan($plan)->setTurn($turns[4102])->setTeam($teams[345])->setWork($works[821])->setCount(3);
        $slot = new Entity\PlanSlotTeam();
        $manager->persist($slot);
        $slot->setPlan($plan)->setTurn($turns[4102])->setTeam($teams[352])->setWork($works[821])->setCount(1);
        $manager->persist($slot);

        $this->getReference('admin')->addAllowedProject($project);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
