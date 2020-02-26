<?php

namespace App\Model;

class CalculationDTO
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * @var array
     */
    private $operations;

    /**
     * @var string
     */
    private $result;

    /**
     * CalculationDTO constructor.
     *
     * @param array  $arguments
     * @param array  $operations
     * @param string $result
     */
    public function __construct(array $arguments, array $operations, string $result)
    {
        $this->arguments = $arguments;
        $this->operations = $operations;
        $this->result = $result;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return array
     */
    public function getOperations(): array
    {
        return $this->operations;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }
}
