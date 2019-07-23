<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 23/07/2019
 * Time: 13:41
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/hello/{name}", name="hello", methods={"GET"})
     * @return Response
     */
    public function hello(string $name=null )
    {


        return new Response('hello' . ' ' . $name);

    }
}