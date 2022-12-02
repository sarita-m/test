<?php
namespace App\Tests;

use App\ProductScrapeData\ProductHtmlTag;
use Symfony\Component\Panther\PantherTestCase;

class ProductScrapeDataTest extends PantherTestCase
{
    public function testProductScrapeData(): void
    {
        $client = static::createPantherClient();
        /**
         * replaced url with testurl
         */
        $client->request('GET', 'https://testurl/');

        $this->assertSelectorExists('h3');
        $this->assertSelectorExists('.price-big');
        $this->assertSelectorExists('.package-price p');
        $this->assertSelectorExists('.package-description');
        $this->assertSelectorExists('.package-price');

        $this->assertSelectorTextContains('h3','Basic: 500MB Data - 12 Months');
        $this->assertSelectorTextContains('.price-big','£5.99');
       
    }

    public function testPageUrl()
    {
        $obj = new ProductHtmlTag();
        $this->assertEquals('https://testurl/', $obj->getPageUrl());

        $this->assertNotEmpty('https://testurl/', $obj->getPageUrl());

        $this->assertEmpty('', $obj->getPageUrl());

    }

}
        
?>