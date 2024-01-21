<?php

namespace App\Command;

use App\Entity\Asset;
use App\Repository\AssetRepository;
use CoinMarketCap\Api;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

// the "name" and "description" arguments of AsCommand replace the
// static $defaultName and $defaultDescription properties
#[AsCommand(
    name: 'app:update-coin-list',
    description: 'Update the entire cryptocurrency list in database.',
    aliases: ['app:update-coin-list'],
    hidden: false
)]
class UpdateCoinList extends Command
{
    /**
     * @param AssetRepository        $assetRepository
     * @param EntityManagerInterface $em
     * @param string                 $coinMarketCapApiKey
     */
    public function __construct(
        protected AssetRepository $assetRepository,
        protected EntityManagerInterface $em,
        #[Autowire(param: 'coinmarketcap_api_key')]
        protected string $coinMarketCapApiKey
    ) {
        parent::__construct();
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $output->writeLn(
                "[" .
                (new DateTime())->format(DateTimeInterface::RFC3339) .
                "] Début de l'exécution du script de mise à jour de la liste des coins"
            );

            // Récupération de toutes les cryptos depuis l'API CoinMarketCap
            $api = new Api($this->coinMarketCapApiKey);
            $coinList = $api->cryptocurrency()->map(['sort' => 'cmc_rank']);
            $output->writeln("Utilisation de l'api " . get_class($api));
            $output->writeln(count($coinList->data) . " actifs récupérés.");

            // enregistrement des id coinmarketcap pour récupérer par lot les infos des actifs dont les logo
            // On le fait par lot pour optimiser la requête et récupérer les infos par lot de 100 actifs.
            $idsLists = [];
            $ids = [];
            // pour éviter les doublons, on ne traite qu'une seule fois un symbole par ordre de rang
            $alreadyDone = [];
            foreach ($coinList->data as $coin) {
                $name = $coin->name;
                $symbol = strtolower($coin->symbol);
                if (!isset($alreadyDone[$symbol])) {
                    $alreadyDone[$symbol] = true;
                    $asset = $this->assetRepository->findOneBySymbol($symbol);
                    $persist = false;
                    if (null === $asset) {
                        $asset = new Asset();
                        $asset->setSymbol(strtolower($symbol));
                        $persist = true;
                    }
                    if ($asset->getName() !== strtolower($name)) {
                        $asset->setName(strtolower($name));
                        $persist = true;
                    }
                    if ($persist) {
                        $this->em->persist($asset);
                    }

                    if (null === $asset->getLogo()) {
                        $ids[] = $coin->id;
                        // on limite les lots à 100
                        if (count($ids) === 100) {
                            $idsLists[] = implode(',', $ids);
                            $ids = [];
                        }
                    }
                }
            }

            // on ajoute le dernier lot
            if (count($ids) > 0) {
                $idsLists[] = implode(',', $ids);
            }

            $output->writeln(count($alreadyDone) . " actifs traités.");

            // enregistrement des noms et symboles
            $this->em->flush();
            $output->writeLn(
                "[" .
                (new DateTime())->format(DateTimeInterface::RFC3339) .
                "] Enregistrement des noms et symboles réussi."
            );
            // récupération des infos des cryptos par lot pour enregistrer les logos
            foreach ($idsLists as $ids) {
                try {
                    $coinsInfo = $api->cryptocurrency()->info(['id' => $ids]);
                    foreach ($coinsInfo->data as $info) {
                        $asset = $this->assetRepository->findOneBySymbol(strtolower($info->symbol));
                        if (null !== $asset && null === $asset->getLogo()) {
                            $asset->setLogo($info->logo);
                            $this->em->persist($asset);
                        }
                    }
                    sleep(5);
                } catch (Exception $e) {
                    $output->writeln("An exception occured : {$e->getMessage()}");
                }
            }
            $this->em->flush();

            $output->writeln(
                "[" .
                (new DateTime())->format(DateTimeInterface::RFC3339) .
                "] Fin de la mise à jour de la liste des coins"
            );
            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln("An exception occured : {$e->getMessage()}");
            return Command::FAILURE;
        }
    }

    protected function configure(): void
    {
    }
}