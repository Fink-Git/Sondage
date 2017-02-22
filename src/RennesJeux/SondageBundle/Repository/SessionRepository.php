<?php

namespace RennesJeux\SondageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use RennesJeux\UserBundle\Entity\User;

/**
 * SessionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SessionRepository extends EntityRepository
{
	/**
	* Renvoi un querybuilder recuperant les sessions dont la date n'est pas 
         * passée et dont le nombre de participant n'a pas encore depassé 
         * le nombre de participant minimum
	*/
	public function sessionsProposees()
    {
    	$qb =  $this->createQueryBuilder('s')
    		->innerJoin('s.jeu', 'jeu')
    		->leftJoin('s.joueurs', 'joueurs')
    		->addSelect('jeu', 'joueurs')
    		->where('s.date >= :datedujour')
    			->setParameter('datedujour', new \Datetime(date('Ymd')))
    		->andWhere('s.nbParticipants < jeu.nbparticipantmin')
                ->orderBy('s.date', 'ASC');

        return $qb;
    }

    /**
    * Renvoi un querybuilder recuperant les sessions dont la date n'est pas 
     * encore passée et dont le nombre de participant a atteint le nombre 
     * de participant minimum
    */
    public function sessionsValidees()
    {
    	$qb = $this->createQueryBuilder('s')
    		->innerJoin('s.jeu', 'jeu')
    		->leftJoin('s.joueurs', 'joueurs')
    		->addSelect('jeu, joueurs')
    		->where('s.nbParticipants >= jeu.nbparticipantmin')
    		->andWhere('s.date >= :datedujour')
    			->setParameter('datedujour', new \Datetime(date('Ymd')))
    		->orderBy('s.date', 'ASC');

        return $qb;
    }

    /**
    * Execute la requete et renvoie les resultats sous forme de tableaux
    */
    public function Execution($qb)
    {
    	return $qb->getQuery()
           ->getArrayResult();
    }

    /**
    * Execute la requete et renvoie les resultats sous forme de paginator
    */
    public function requetePaginee($qb)
    {
    	/*$adapter = new DoctrineORMAdapter($qb,false,true);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(5);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;*/
    }

    /**
    * Recherche une session par id et ramene les donnees des entites Jeux et 
     * Session
    */
    public function findSession($id)
    {
    	$qb =  $this->createQueryBuilder('s')
    		->innerJoin('s.jeu', 'jeu')
    		->addSelect('jeu')
    		->where('s.id = :id')
    			->setParameter('id', $id)
    		->setMaxResults(1);


        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Recupere les sessions de l'utilisateur courant
     * @param User $user
     */
    public function sessionsParJoueur($user)
    {
        $qb = $this->createQueryBuilder('s')
    		->innerJoin('s.jeu', 'jeu', 'WITH', 'jeu.hote = :hote')
                    ->setParameter('hote', $user->getUsername())
    		->leftJoin('s.joueurs', 'joueurs')
    		->addSelect('jeu, joueurs')
    		->where('s.date >= :datedujour')
                    ->setParameter('datedujour', new \Datetime(date('Ymd')))
    		->orderBy('s.date', 'ASC');

        return $qb;
                              
    }
}
