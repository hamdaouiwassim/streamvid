<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Video;
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {

        return $this->render('home/index.html.twig');
   
        
       
    }
     /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        $videos = $this->getDoctrine()
        ->getRepository(Video::class)
        ->findAll();
            if ( $this->getUser()){
                if ( $this->getUser()->getRoles()[0] == "ADMIN"){
                            return  $this->render('admin/home.html.twig',[
                                'videos' => $videos,
                            ]);
                }else{
                            return  $this->render('users/home.html.twig',[
                                'videos' => $videos,
                            ]);
                }
            }
        
   
        
       
    }
}
