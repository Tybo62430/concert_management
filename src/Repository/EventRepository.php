<?php

namespace App\Repository;

use App\Entity\Artist;
use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('date' => 'ASC'));
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function add(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Retourne un tableau d'Event qui se deroule sur les 3 prochains mois
     */
    public function findThreeMonthEvent(): array
    {
        $date = new \DateTime('now');
        $date->modify('+3 month');

        return $this->createQueryBuilder('e')
            ->andWhere('e.date <= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne un tableau d'Event selon les champs artist, city, date
     */
    public function findSpecicEvent($searchInput): array
    {
        $query = $this->createQueryBuilder('e');

        if ($searchInput->getArtist()) {
            $artist = $this->getEntityManager()->getRepository(Artist::class)->FindOneBy([
                'name' => $searchInput->getArtist()
            ]);

            $query->andWhere('e.artist = :artist')
                ->setParameter('artist', $artist);
        }

        if ($searchInput->getCity()) {
            $query->andWhere('e.city = :city')
                ->setParameter('city', $searchInput->getCity());
        }

        if ($searchInput->getDateStart()) {
            $query->andWhere('e.date BETWEEN :dateStart AND :dateEnd')
                ->setParameter('dateStart', $searchInput->getDateStart())
                ->setParameter('dateEnd', $searchInput->getDateEnd());
        }

        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
