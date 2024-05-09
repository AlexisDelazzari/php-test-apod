<?php

namespace App\Command;

use App\Repository\PictureRepository;
use App\Services\PictureService;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'FetchNasaPictureCommand',
    description: 'Command to fetch a picture from the NASA API',
    aliases: ['app:fetch-nasa-picture'],

)]
class FetchNasaPictureCommand extends Command
{
    public function __construct(
        private readonly PictureService $PictureService,
        private readonly PictureRepository $PictureRepository
    ) {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $date = new \DateTime();
        $picture = $this->PictureRepository->findOneBy(['date' => new \DateTime ($date->format('Y-m-d'))]);

        if ($picture) {
            $io = new SymfonyStyle($input, $output);
            $io->error('A picture already exists for today');
            return Command::FAILURE;
        }

        $pictureData = $this->PictureService->getPictureOfTheDay();
        $this->PictureService->savePicture($pictureData);

        return Command::SUCCESS;
    }
}
