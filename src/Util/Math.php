<?php

namespace App\Util;

class Math
{
    const SCALE = 16;

    /**
     * $leftOperand + $rightOperand
     *
     * @param string $leftOperand
     * @param string $rightOperand
     * @param int    $scale
     *
     * @return string
     */
    public static function add(string $leftOperand, string $rightOperand, int $scale = self::SCALE): string
    {
        return bcadd($leftOperand, $rightOperand, $scale);
    }

    /**
     * $leftOperand - $rightOperand
     *
     * @param string $leftOperand
     * @param string $rightOperand
     * @param int    $scale
     *
     * @return string
     */
    public static function sub(string $leftOperand, string $rightOperand, int $scale = self::SCALE): string
    {
        return bcsub($leftOperand, $rightOperand, $scale);
    }

    /**
     * $dividend / $divisor
     *
     * @param string $dividend
     * @param string $divisor
     * @param int    $scale
     *
     * @return string
     */
    public static function div(string $dividend, string $divisor, int $scale = self::SCALE): string
    {
        return bcdiv($dividend, $divisor, $scale);
    }

    /**
     * $leftOperand * $rightOperand
     *
     * @param string $leftOperand
     * @param string $rightOperand
     * @param int    $scale
     *
     * @return string
     */
    public static function mul(string $leftOperand, string $rightOperand, int $scale = self::SCALE): string
    {
        return bcmul($leftOperand, $rightOperand, $scale);
    }

    /**
     * @param string $number
     * @param int    $minZero
     * @param int    $scale
     *
     * @return string
     */
    public static function format(string $number, int $minZero = 1, int $scale = self::SCALE): string
    {
        if ($minZero < 0) {
            throw new \LogicException("minZero must be >= 0");
        }

        list($integer, $float) = explode('.', $number);

        /* Basic part of float value till minimal count of Zero digits */
        $float1 = substr($float, 0, $minZero);
        /* Digits after minimal count till scale */
        $float2 = $minZero > $scale ? '' : substr($float, $minZero);
        /* Remove all 0 after $minZero values of result's float part */
        $result = implode('.', [$integer, $float1 . rtrim($float2, '0')]);

        return rtrim($result, '.');
    }
}
