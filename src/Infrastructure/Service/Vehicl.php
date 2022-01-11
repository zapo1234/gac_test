<?php

namespace App\Infrastructure\Service;
use App\Domain\Entity\Vehicle;
use App\Domain\Entity\Expense;

interface Vehicl
{
public function saveVehicle(Vehicle $vehicle, Expense $expense): void;

public function getTotal() : int;

public function getTotalCategory(Expense $expense): int;

public function getTotalTop10() :array;

public function getVehicleTop10() :array;

public function getDataVehicle() :array;

}