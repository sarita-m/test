<?php
namespace App\ProductScrapeData;

use App\ProductScrapeData\ProductInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Panther\Client;

class ProductScrapeData 
{
    public function __construct(ProductInterface $pInterface)
    {
        $this->pInterface = $pInterface;
        
    }

    /**
     * @return array collection productData. Return the values scrape from the webpage 'https://testurl/'
     */
    public function getProductScrapeData(): Collection
    {
        $productData = [];
        $client = Client::createChromeClient();
       
        $crawler = $client->request('GET', $this->pInterface->getPageUrl());
       
        $productData['option'] = $crawler->filter($this->pInterface->getTitleOption())->extract(array('_text')); 
        $productData['subscription'] = $this->checkSubscriptionOption($productData['option']);
        $productData['description'] = $crawler->filter($this->pInterface->getDescription())->extract(array('_text'));  
        $productData['price'] = $this->strtoFloat($crawler->filter($this->pInterface->getPrice())->extract(array('_text')));
        $productData['discount'] = $this->strtoFloat($crawler->filter($this->pInterface->getDiscount())->extract(array('_text')));      
        $productData['discount']  = $this->calculateDiscount($productData['discount'], $productData['price'], $productData['subscription']);
           
        return new ArrayCollection($productData);
    }

    /**
     * @return discountPer[]. Calculate discount percentage based on price and saving value. Returns an array of discount percentage.
     */
    private function calculateDiscount($savings, $prices, $subscriptions)
    {
       $saving_count = count($savings); 
       $discountPer = [];
       foreach($subscriptions AS $k => $subscription)
       { 
            if($subscription == 'Months'){
                $discountPer[$k] = 0;
            }
            else{
                $saving = $savings[$k-$saving_count];
                $discountPer[$k] = round(($saving/$prices[$k] * 100), 2);
            }
            
        }

       return $discountPer;
    }

    /**
     * @return amount a float value.
     */
    private function strtoFloat($params)
    {
        $amount = [];
        foreach($params AS $param)
        {
            $amount[] = preg_replace('#[^0-9\.,]#', '', $param);
        }
        return $amount;
    }

    /**
     * @return subscription[] month or year string Returns an array with values [month,year]
     */
    private function checkSubscriptionOption($options){
    
        if(!empty($options)){
            foreach($options AS $option){
                $string = explode(" ", $option);
                $subscription[] = array_pop($string);
            }
        }
        return $subscription;
    }
}

?>