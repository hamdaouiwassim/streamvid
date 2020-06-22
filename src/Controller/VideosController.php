<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Video;
class VideosController extends AbstractController
{
    /**
     * @Route("/videos", name="videos")
     */
    public function index()
    {
        $videos = $this->getDoctrine()
        ->getRepository(Video::class)
        ->findAll();
        return $this->render('videos/index.html.twig', [
            'videos' => $videos,
        ]);
    }


    /**
     * @Route("/video/add", name="addvideo")
     */
    public function addvideo()
    {
        if ( $this->getUser()->getRoles()[0] == "ROLE_ADMIN" ){
            return $this->render('videos/ajoutVideo.html.twig');
        }else{
           return  $this->redirect("/");
        }
        
    }

     /**
     * @Route("/video/add/db", name="addvideodb")
     */
    public function addvideodb(Request $request){
     
                    //get pic from http request
                    $Image = $request->files->get('cover'); 
                    $Content = $request->files->get('content'); 
                    //dd($Image);
                    
                    //generate a unique name for pic
                    $picName = uniqid().'-'.$Image->getClientOriginalName();
                      //generate a unique name for pic
                    $vidName = uniqid().'-'.$Content->getClientOriginalName();

                    //move pic to a directory
                    $Image->move(
                            $this->getParameter('covers_directory'),
                            $picName
                        );
                     //move pic to a directory
                     $Content->move(
                        $this->getParameter('videos_directory'),
                        $vidName
                    );

                    $video = new Video();
                    $video->setTitle($request->request->get('title'));
                    $video->setDescription($request->request->get('description'));
                    $video->setCover($picName);
                    $video->setContent($vidName);
                    $video->setAddedAt(new \DateTime(date("Y-m-d H:i:s")));
                    $video->setModifiedAt(new \DateTime(date("Y-m-d H:i:s")));

                    $entityManager = $this->getDoctrine()->getManager();

                      // tell Doctrine you want to (eventually) save the Product (no queries yet)
                    $entityManager->persist($video);

                    // actually executes the queries (i.e. the INSERT query)
                    $entityManager->flush();
           
           return new Response("files uploaded");
            

    }


    /**
     * @Route("/video/{id}/show", name="showvideo")
     */
    public function show($id){
                    $video = $this->getDoctrine()
                    ->getRepository(Video::class)
                    ->find($id);

                    if ( $this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
                        return  $this->render('admin/videos/show.html.twig',[
                            'video' => $videos,
                        ]);
                        }else{
                                    return  $this->render('users/videos/show.html.twig',[
                                        'video' => $video,
                                    ]);
                        }

    }


}
