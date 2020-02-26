<?php

namespace App\Command;

use App\Service\CalculationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RpnCalculatorCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:rpn-calculator';

    /**
     * @var CalculationService
     */
    private $calculationService;

    /**
     * RpnCalculatorCommand constructor.
     *
     * @param CalculationService $calculationService
     */
    public function __construct(CalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Reverse Polish Notation (RPN) calculator');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Reverse Polish Notation (RPN) calculator');
        $io->text('You can input arguments to command line and operations to get result of calculation');

        $arguments = [];
        $operations = [];
        do {
            /* replace ',' to '.' for support any delimiter  */
            $inputLine = str_replace(',', '.', readline());

            /* Create array of input values and separate it to $arguments and $operations */
            $inputArray = explode(' ', $inputLine);

            /* separate $values to $arguments and $operations */
            foreach ($inputArray as $inputValue) {
                switch (true) {
                    case preg_match('/[-+]?([0-9]*\.[0-9]+|[0-9]+)/', $inputValue, $pregResult) && $inputValue == $pregResult[0]:
                        $arguments[] = $inputValue;
                        break;
                    case preg_match('/[-+\*\/]/', $inputValue, $pregResult) && $inputValue == $pregResult[0]:
                        $operations[] = $inputValue;
                        break;
                    case $inputValue == 'q':
                    case $inputValue == '':
                        break;
                    default:
                        $io->warning("Value $inputValue is not valid");
                }
            }

            if (!empty($arguments) && !empty($operations)) {
                try {
                    $calculationResult = $this->calculationService->rpnCalculate($arguments, $operations);

                    $io->text($calculationResult->getResult());

                    $arguments = $calculationResult->getArguments();
                    $calculationResult->getOperations() && $io->warning("Few operations was not completed. Not enough arguments.");
                    $operations = [];

                    /* Add result as last $argument */
                    $arguments[] = $calculationResult->getResult();
                } catch (\Exception $exception) {
                    $io->error(sprintf("Error in calculation: %s", $exception->getMessage()));
                }
            }

        } while (trim($inputLine) != 'q');

        $io->success('Quit OK.');
        return 0;
    }
}
