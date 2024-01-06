<?php

namespace App\Command;

use App\Domain\Currency\Repository\CryptocurrencyRepositoryInterface;
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
    public function __construct(private CryptocurrencyRepositoryInterface $cryptocurrencyRepository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = microtime(true);
        $coins = $this->cryptocurrencyRepository->findAll();
        $end = microtime(true);
        $total = $end - $start;
        $output->write("Temps de récupération de toutes les crypto depuis CoinCap : " . round($total, 3) . " s");
        return Command::SUCCESS;
    }

    protected function configure(): void
    {
    }
}