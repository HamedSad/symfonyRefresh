<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }

    // // Pour les methodes custom si je veux obtenir que les projeté avec terminé en false
    // public function findAllVisible(){
    //     return $this->createQueryBuilder('p')
    //         ->where('p.terminé = false')
    //         //récupérer la requete
    //         ->getQuery()
    //         //récupérer le résultat
    //         ->getResult();
    // }

    public function findLatest() : array {
        return $this->createQueryBuilder('p')
            ->setMaxResults(4)
            //->where('p.terminé = false')
            //récupérer la requete
            ->getQuery()
            //récupérer le résultat
            ->getResult();
    }

    // /**
    //  * @return Project[] Returns an array of Project objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

}
