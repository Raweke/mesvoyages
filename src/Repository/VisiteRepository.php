<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }
    
    /**
     * Retourne toutes les visites triées sur un champ
     * @param type $champ
     * @param type $ordre
     * @return Visite[]
     */
    public function findAllOrderBy($champ, $ordre): array{
        return $this->createQueryBuilder('v')
                ->orderBy('v.'.$champ, $ordre)
                ->getQuery()
                ->getResult();
                         
    }
    
    
    /**
     * Enregistrement dont un champ est égal a une valeur. Ou tous les enregistrement si valeur vide
     * @param type $champ
     * @param type $valeur
     * @return Visite[]
     */
    public function findByEqualValue($champ, $valeur): array {
        if($valeur==""){
            return $this->createQueryBuilder('v') //alias de la table
                    ->orderBy('v.'.$champ,'ASC')
                    ->getQuery()
                    ->getResult();
        }else{
            return $this->createQueryBuilder('v')
                    ->where('v.'.$champ.'=:valeur')
                    ->setParameter('valeur', $valeur)
                    ->orderBy('v.datecreation','DESC')
                    ->getQuery()
                    ->getResult();
        }
    }
    
    public function remove(Visite $visite):void
    {
        $this->getEntityManager()->remove($visite);
        $this->getEntityManager()->flush();
    }
    
    public function add(Visite $visite): void
    {
        $this->getEntityManager()->persist($visite);
        $this->getEntityManager()->flush();
    }    
    
    public function findAllLasted($nb) : array {
        return $this->createQueryBuilder('v') // alias de la table
           ->orderBy('v.datecreation', 'DESC')
           ->setMaxResults($nb)     
           ->getQuery()
           ->getResult();
    }
    
}
