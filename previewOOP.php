<?php
class car{
    private $make;
    private $model;
    private $year;
    private $engineSize;
    private $horsepower;
    private $transmission;
    private $fuelType;
    private $mileage;
    private $productionDate;
    private $basePrice;
    private $images=[];

public function __construct ($make, $model, $year, $engineSize, $horsepower, $transmission, $fuelType, $mileage, $productionDate, $basePrice){
    $this->make = $make;
    $this->model = $model;
    $this->year = $year;
    $this->engineSize = $engineSize;
    $this->horsepower = $horsepower;
    $this->transmission = $transmission;
    $this->fuelType = $fuelType;
    $this->mileage = $mileage;
    $this->productionDate = $productionDate;
    $this->basePrice = $basePrice;
}

public function getMake(){
    return $this->make;
}
public function getModel(){
    return $this->model;
}
public function getYear(){
    return $this->year;
}
public function getTitle(){
    return $this->make . " " . $this->model . " " . $this->year;
}
public function getEngineInfo(){
    return $this->engineSize . " (" . $this->horsepower . "HP)";
}
public function getTransmission(){
    return $this->transmission;
}
public function getFuelType(){
    return $this->fuelType;
}
public function getMileage(){
    return $this->mileage;
}
public function getProductionDate(){
    return $this->productionDate;
}
public function getBasePrice(){
    return $this->basePrice;
}

public function setImages($images){
    $this->images = $images;
}
public function getImages(){
    return $this->images;
}

public function formatPrice($price){
    return number_format($price, 0, ',', ' ') . " €";
}

public function getFeatures(){
    return [
        "Motor" => $this->engineSize . " V6",
        "Fuqia" => $this->horsepower . " Hp",
        "Transmision" => $this->transmission,
        "Karburanti" => $this->fuelType,
        "Viti i Prodhimit" => $this->productionDate,
        "Kilometrat" => $this->mileage . " km"
    ];
}
}

class Service {
    private $name;
    private $price;
    private $isFree;
    private $hasInfo;

    public function __construct($name, $price, $isFree = false, $hasInfo = false) {
        $this->name = $name;
        $this->price = $price;
        $this->isFree = $isFree;
        $this->hasInfo = $hasInfo;
    }

    public function getName() {
        return $this->name;
    }
    public function getPrice() {
        return $this->price;
    }
    public function isFree() {
        return $this->isFree;
    }
    public function hasInfo() {
        return $this->hasInfo;
    }
}
?>