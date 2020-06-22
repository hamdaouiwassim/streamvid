<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
class AdminActionsController extends AbstractController
{
    /**
     * @Route("/admin/actions", name="admin_actions")
     */
    public function index()
    {
        return $this->render('admin_actions/index.html.twig', [
            'controller_name' => 'AdminActionsController',
        ]);
    }


    /**
     * @Route("/user/{id}/delete", name="deleteuser")
     */
    public function deleteUser($id)
    {

 
            if($this->getUser()->getRoles()[0] == "ADMIN"){

                $entityManager = $this->getDoctrine()->getManager();
                $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($id);
                //dd($user);
                $entityManager->remove($user);
                $entityManager->flush();

            }
           
            return  $this->redirect("/home");
            
     
            
       
        
    }
}
