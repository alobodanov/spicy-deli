<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    public function getCategories()
    {
        $categories =  $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return json_decode($categories);

    }

}
