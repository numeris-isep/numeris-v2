<?php

namespace App\Calculator;

interface CalculatorInterface
{
    public function calculate($params = null): array;
}
