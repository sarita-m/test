<?php

namespace App\ProductScrapeData;

interface ProductInterface
{
    public function getPageUrl(): string;

    public function getTitleOption(): string;
   
    public function getProductDetail(): string;
   
    public function getDescription(): string;
   
    public function getPrice(): string;
    
    public function getDiscount(): string;

}

?>