<?php

namespace App\Controller;

use App\Entity\Product;
use App\ProductScrapeData\ProductScrapeData;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends AbstractController
{
    private ProductScrapeData $data;
    public function __construct(ProductScrapeData $data)
    {
        $this->data = $data;
    }

    #[Route('/', name: 'app_product')]
    public function index()
    {
        return $this->render('product/index.html.twig');
    }
    
    /**
     * @Route("/fetch_all_product/", name="fetch_all")
     */
    #[Route('/fetch_all_product', name: 'fetch_all')]
    public function fetch_all_product(ProductRepository $repository)
    {
        $package = $repository->findAll();

        $package = (array)$package;
        return $this->render('product/product.html.twig',  array(
            "package" => $package));
    }
    /**
     * @return product json object array. fetch the data from webpage and save it into table prodcut_db.product 
     */
    #[Route('/product', name: 'app_product2')]
    public function addProduct(ProductRepository $repository): JsonResponse
    { 
        $products = $this->data->getProductScrapeData();
        $flag = 0;
        foreach($products['option'] AS $k => $v){
         
                $title = $repository->findOneByTitle(trim($products['option'][$k]));
              
                if(!$title){  
                    $productEntity = new Product();

                    $productEntity->setSubscription($products["subscription"][$k]);
                    $productEntity->setTitle($products['option'][$k]);
                    $productEntity->setDescription($products['description'][$k]);
                    $productEntity->setPrice($products['price'][$k]);
                
                    $productEntity->setDiscount($products['discount'][$k]);
                    $repository->add($productEntity, false);
                    $flag = 1;
                }    
       }
     
       if($flag == 1){ 
          $repository->add($productEntity, true);
        }

        return $this->json($products->toArray());
    }
}
