<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Project;
use App\Repository\ProjectRepository;

class ProjectController extends AbstractController{

    public function __construct(ProjectRepository $repository){
        $this->repository = $repository;
    }
    

    /**
    *Page les biens et le nom du path présent dans le template
    *@Route("/mesprojets", name="project.index")
    *@return Response
    */

    public function index(ProjectRepository $repository): Response{
        // //Pour interagir avec la bdd, création d'une nouvelle entité
        // $project = new Project();
        // $project->setTitle('Mon premier projet')
        //         ->setArea(12)
        //         ->setDescription('Ce projet a été réalisé il y a quelques années')
        //         ->setGround(2)
        //         ->setSurface(15)
        //         ->setUser(1);
        // //EntityManager classe responsable de gerer les données ds la BDD  
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($project);
        // $em->flush();
        
        // //Pour initialiser le repo dans une variable
        // $repository = $this->getDoctrine()->getRepository(Project::class);
        // dump($repository);

        //Il existe des methodes de base find(), findAll(), findOneBy
        // $property = $this->repository->findOneBy(['ground'=>2]);
        // dump($property);
        return $this->render('project/index.html.twig',[
            'current_menu' => 'projects'
        ]);
    }

    /**
    *@Route("/mesProjects/{slug}-{id}", name="project.show", requirements={"slug": "[a-z0-9\-]*"})
    *@return Response
    */
    public function show($slug, $id) : Response{

        $project = $this->repository->find($id);

        //j'envoie le projet à ma vue

        return $this->render('project/show.index.html.twig',[
            'project' => $project,
            'current_menu' => 'projects'
        ]);
    }
}
