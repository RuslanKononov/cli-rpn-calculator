<?php

namespace App\Service;

use App\Model\CalculationDTO;
use App\Util\Math;
use Symfony\Component\Config\Definition\Exception\Exception;

class CalculationService
{
    /**
     * @param array $arguments
     * @param array $operations
     *
     * @throws \Exception
     *
     * @return CalculationDTO       where arguments is array of not calculated arguments to calculate it in future
     *                              and where operations is array of not used operations to use it in future or show error
     */
    public function rpnCalculate(array $arguments, array $operations)
    {
        $rpnArguments = array_reverse($arguments);

        return $this->calculate($rpnArguments, $operations);
    }

    /**
     * @param array $arguments
     * @param array $operations
     *
     * @throws \Exception
     *
     * @return CalculationDTO       where arguments is array of not calculated arguments to calculate it in future
     *                              and where operations is array of not used operations to use it in future or show error
     */
    private function calculate(array $arguments, array $operations): CalculationDTO
    {
        /* first argument is result on start of calculation */
        $result = strval(array_shift($arguments));

        foreach ($operations as $key => $operation) {
            $calculationArgument = array_shift($arguments);
            /* When all arguments are calculated but we have few not calculated operations operations */
            if (!$calculationArgument) {
                break;
            }
            /* When we use rpnCalculate we should use $result as $rightOperand */
            $result = $this->runOperation(strval($calculationArgument), $result, $operation);
            /* unset current operation from list of operations */
            unset($operations[$key]);
        }

        return new CalculationDTO(array_reverse($arguments), $operations, $result);
    }

    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $operation
     *
     * @throws \Exception
     *
     * @return string
     */
    private function runOperation(string $leftOperand, string $rightOperand, string $operation): string
    {
        switch ($operation) {
            case '+':
                $result = Math::add($leftOperand, $rightOperand);
                break;
            case '-':
                $result = Math::sub($leftOperand, $rightOperand);
                break;
            case '*':
                $result = Math::mul($leftOperand, $rightOperand);
                break;
            case '/':
                $result = Math::div($leftOperand, $rightOperand);
                break;
            default:
                throw new \Exception('Not accepted Math operation. Please reenter operands and operations.');
        }

        return Math::format($result);
    }
}
