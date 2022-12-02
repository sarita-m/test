<?php

namespace App\ProductScrapeData;

use App\ProductScrapeData\ProductInterface;

class ProductHtmlTag implements ProductInterface
{
    public function getPageUrl(): string
    {
        /**
         *  replaced
         */
        return 'https://testurl/';
    }


    public function getTitleOption(): string
    {
        return 'h3';
    }

    public function getProductDetail(): string
    {
        return '.pricing-table';
    }

    public function getDescription(): string
    {
        return '.package-description';
    }

    public function getPrice(): string
    {
        return '.price-big';
    }

    public function getDiscount(): string
    {
        return '.package-price p';
    }
   
    
}