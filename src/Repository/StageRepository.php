<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

	/**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
	
    public function findStagesEntreprise($entreprise)
    {
        return $this->createQueryBuilder('s')
            ->join('s.entreprise','e')
			->where('e.nom = :entreprise')
            ->setParameter('entreprise', $entreprise)
            ->getQuery()
            ->getResult()
        ;
    }
	
	public function findStagesFormation($formation)
    {
        $gestionnaireEntite = $this->getEntityManager();
		$requete = $gestionnaireEntite->createQuery('SELECT s, f FROM App\Entity\Stage s JOIN s.formation f WHERE f.nom = :formation');
		$requete->setParameter('formation', $formation);
		return $requete->execute();
    }
	
	public function findStagesEtEntreprises()
    {
        return $this->getEntityManager()->createQuery('SELECT s, e FROM App\Entity\Stage s JOIN s.entreprise e')->execute();
    }
	
    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
