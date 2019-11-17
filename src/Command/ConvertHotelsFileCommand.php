<?php

namespace App\Command;

use App\Domain\Service\HotelFileConvertService\HotelFileConvertService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertHotelsFileCommand extends Command
{
    protected static $defaultName = 'app:convert-hotels-file';
    private $hotelFileConvertService;

    public function __construct(HotelFileConvertService $hotelFileConvertService)
    {
        $this->hotelFileConvertService = $hotelFileConvertService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Convert data from xml,json or others formats into CSV')
            ->addArgument('sourceFilePath', InputArgument::REQUIRED, 'Input the source file path')
            ->addArgument('outputFilePath', InputArgument::REQUIRED, 'Input the target file path');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourceFilePath = $input->getArgument('sourceFilePath');
        $outputFilePath = $input->getArgument('outputFilePath');

        $this->hotelFileConvertService->openFile($sourceFilePath);
        $this->hotelFileConvertService->convert($outputFilePath);

        $output->writeln('Conversion finished with successfully!');
    }
}
