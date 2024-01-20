<?php

namespace App\Command;

use App\Domain\Currency\Repository\CryptocurrencyRepositoryInterface;
use App\Entity\Asset;
use App\Repository\AssetRepository;
use Binance\Spot;
use Doctrine\ORM\EntityManagerInterface;
use Moody\ValueObject\Identity\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    public function __construct(
        protected AssetRepository $assetRepository,
        protected EntityManagerInterface $em,
        private CryptocurrencyRepositoryInterface $cryptocurrencyRepository
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $args = [
            'key' => 'Xu2C2xdAkrb4OeFzIhggSYjcE0PUNVihSGmqKCvJuD7lPwdb5Fa6nKbNVeBLZH20',
            'secret' => 'IslVAlgTqLlwf6ZkMuedQ5GlaHLKH84o3mm2vgiaApbYldY5i9wYQcdhIDcCZw75'
        ];
        $test = $this->assetRepository->findAll();
        $spot = new Spot($args);
        $coins = $spot->coinInfo();
        foreach($coins as $coin) {
            $asset = new Asset();
            $asset->setName(strtolower($coin['name']))->setSymbol(strtolower($coin['coin']));
            $this->em->persist($asset);
        }
        $this->em->flush();
        $start = microtime(true);
        //$coins = $this->cryptocurrencyRepository->findAll();
        $end = microtime(true);
        $total = $end - $start;
        $output->write("Temps de récupération de toutes les crypto depuis CoinCap : " . round($total, 3) . " s");
        return Command::SUCCESS;
    }

    protected function configure(): void
    {
    }
}