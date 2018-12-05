<?php

namespace App\Controller;

use App\Entity\Products;
use App\Utils\Messages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{

    /**
     * @Route("/products", name="products", methods={"GET"})
     */
    public function getProductsAction()
    {
        $products =  $this->getDoctrine()
            ->getRepository(Products::class)
            ->findAll();

        return json_decode($products);
    }

    /**
     * @Route("/product/{id}", name="product", methods={"GET"})
     */
    public function getProductAction($id)
    {
        try {
            $product = $this->getDoctrine()
                ->getRepository(Products::class)
                ->find($id);
        } catch ( \Exception $e) {
            return new Response( $e->getMessage(), 500 );
        }

        return new JsonResponse([
            'success' => true,
            'data'    => $product
        ]);
    }

    /**
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createProductAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        if (! $request->get('name')) {
            return new Response('Please provide a name!');
        }

        $product = new Products();
        try {
            $product->setName($request->get('name'));
            $product->setPrice($request->get('price'));
            $product->setSKU($request->get('sku'));
            $product->setCategory($request->get('category'));

            $em->persist($product);
            $em->flush();
        } catch ( \Exception $e) {
            return new Response( $e->getMessage(), 500 );
        }

        return new Response('Saved new product with id '.$product->getId());
    }

    /**
     * @return Response|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteProductAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository(Products::class)
            ->find($id);

        if (!$product){
            return new Response(Messages::PRODUCT_NOT_FOUND . $id, 500);
        }

        try {
            $em->remove($product);
            $em->flush();
        } catch ( \Exception $e ) {
            return new Response( $e->getMessage(), 500 );
        }

        return new Response(  Messages::SUCCESSFUL_DELETION, 200 );
    }
}
