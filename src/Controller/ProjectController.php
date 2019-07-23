<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\ProjectSearch;
use App\Form\ProjectSearchType;
use App\Repository\ProjectRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProjectController extends AbstractController{

    public function __construct(ProjectRepository $repository, ObjectManager $em){
        $this->repository = $repository;
        //EntityManager classe responsable de gerer les données ds la BDD  
        $this->em = $em;
    }
    

    /**
    *@Route("/mesprojets", name="project.index")
    *@return Response
    */
    public function index(PaginatorInterface $paginator, Request $request): Response{

        //Creation d'une nouvelle entité
        $search = new ProjectSearch();

        $form = $this->createForm(ProjectSearchType::class, $search);

        //Gérer la requete
        $form->handleRequest($request);
      

        $projects = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );
        //Il existe des methodes de base find(), findAll(), findOneBy
        // $property = $this->repository->findOneBy(['ground'=>2]);
        return $this->render('project/index.html.twig',[
            'current_menu' => 'projects',
            'projects' => $projects,
            //je lui demande d'afficher le formulaire de recherche avec le createView
            'form' => $form->createView()
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