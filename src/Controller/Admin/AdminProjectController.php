<?php
namespace App\Controller\Admin;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use App\Form\ProjectType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;


class AdminProjectController extends AbstractController {

    /**
    *@var ProjectRepository
    */
    private $repository;

    //Pour récupérer mes projets, j'ai besoin du repository donc j'injecte le ProjectRepository
    // Injection de l'Object manager
    public function __construct(ProjectRepository $repository, ObjectManager $em){
        //Je l'initialise dans mon constructeur
        $this->repository = $repository;
        $this->em = $em;
    }
    
    //Methode index pour récupérer l'ensemble des projets
    //Création de ma route pour la partie index

    /**
    *@Route("/admin", name="admin.project.index")
    *@return \Symfony\Component\HttpFoundation\Response
    */
    public function index(){
        $projects = $this->repository->findAll();
    //Je génère ma vu via un return, que l'on va mettre ds un dossier admin et on lui envoie un tableau comportant projects
        return $this->render('admin/project/index.html.twig', compact('projects'));
    }
   
        /**
        *@Route("admin/project/create", name="admin.project.new", methods="GET|POST")
        */
        public function new(Request $request){
            //creation d'une nouvelle instance de type Project, on crée un projet vide
            $project = new Project();
            //ensuite on créé un formulaire en lui passant la propriété
            $form = $this->createForm(ProjectType::class, $project);
            //on demande au formulaire de gérer la requete
            $form->handleRequest($request);
            //le formulaire a t il été envoyé et est-il valide?
            if($form->isSubmitted()  && $form->isValid()){
            //Notre objet étant créé de façon manuelle, elle n'est pas suivi par l'Entity Manager
            //Avant de flush on va persist cette nouvelle entité
                $this->em->persist($project);
            //Si les données sont valides il va mettre à jour la BDD
                $this->em->flush();
            //message de confirmation de création de projet 
            $this->addFlash('success', 'Votre projet a bien été créé');
            //redirection de l'user vers admine.project.index
                return $this->redirectToRoute('admin.project.index');
            }
            //Si tout est ok on va sur le template new
            return $this->render('admin/project/new.html.twig', [
                //On envoie le tout à la vue
                'project'=> $project,
                'form'=>$form->createView()
                ]); 
        }

    
    //Methode index pour éditer un projet
    //Ds les arguments, injection pour récupérer les projets qui m'intéressent

    /**
    *@Route("/admin/project/{id}", name="admin.project.edit")
    *@param Project $project
    *@param Request $request 
    *@return \Symfony\Component\HttpFoundation\Response
    */ 
    public function edit(Project $project, Request $request){
        //methode create form pour utiliser le formulaire avec le nom du formulaire et la mon entité qui comprendra toutes mes variables
        $form = $this->createForm(ProjectType::class, $project);

        //utilisation de la methode handleRequest issue de la class Request
        $form->handleRequest($request);

        //le formulaire a t il été envoyé et est-il valide?
        if($form->isSubmitted()  && $form->isValid()){
            //Si les données sont valides il va mettre à jour la BDD
            $this->em->flush();
            //message de confirmation de création de projet 
            $this->addFlash('success', 'Votre projet a bien été modifié');
            //redirection de l'user vers admine.project.index
            return $this->redirectToRoute('admin.project.index');
        }

        //puis je lui dis de se rendre sur la page admin/project/edit.html
        return $this->render('admin/project/edit.html.twig', [
        //On envoie le tout à la vue
        'project'=> $project,
        'form'=>$form->createView()
        ]);     
    }

    /**
    *@Route("/admin/projet/{id}", name="admin.project.delete", methods="DELETE")
    *@param Project $project
    *@return @return \Symfony\Component\HttpFoundation\Response
    */
    public function delete(Project $project, Request $request){
        $submittedToken = $request->request->get('_token');
        //vérification de la valeur du token csrf pour le form suppression soit bien valide
        if ($this->isCsrfTokenValid('delete', $submittedToken)) {
            $this->em->remove($project);
            $this->em->flush();
            //message de confirmation de création de projet 
            $this->addFlash('success', 'Votre projet a bien été supprimé');
            //return new Response('Suppression');
            }
            
            return $this->redirectToRoute('admin.project.index');
        }
}