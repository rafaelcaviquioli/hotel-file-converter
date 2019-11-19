<?php

namespace App\Command;

use App\Domain\Service\HotelFileConvertService\HotelFileConvertService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function App\Domain\Service\HotelFileConvertService\Filters\filterHotelWithStarsBiggerOrEqualsThan;

class ConvertHotelsFileCommand extends Command
{
    protected static $defaultName = 'app:convert-hotels-file';
    private $hotelFileConvertService;
    private $logger;

    public function __construct(
        HotelFileConvertService $hotelFileConvertService,
        LoggerInterface $logger
    ) {
        $this->hotelFileConvertService = $hotelFileConvertService;
        $this->logger = $logger;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Convert data from xml,json or others formats into CSV')
            ->addArgument('sourceFilePath', InputArgument::REQUIRED, 'Input the source file path')
            ->addArgument('outputFilePath', InputArgument::REQUIRED, 'Input the target file path')
            ->addOption('filterStarsBiggerOrEqualsThan', null, InputOption::VALUE_OPTIONAL, 'Filter hotel stars bigger or equals than passed value');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $sourceFilePath = $input->getArgument('sourceFilePath');
            $outputFilePath = $input->getArgument('outputFilePath');
            $filterStarsValue = (int) $input->getOption('filterStarsBiggerOrEqualsThan');

            $this->hotelFileConvertService->openFile($sourceFilePath);
            $this->hotelFileConvertService->convert($outputFilePath, filterHotelWithStarsBiggerOrEqualsThan($filterStarsValue));

            $this->logger->notice('Conversion finished with successfully!');
        } catch (Exception $exeption) {
            $this->logger->error($exeption->getMessage());
        }
    }
}
