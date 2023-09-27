<?php

declare(strict_types=1);


namespace Tahicz\SymfonyStatusLoggerBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Tahicz\SymfonyStatusLoggerBundle\Entity\StatusLog;

/**
 * @extends EntityRepository<StatusLog>
 *
 * @method null|StatusLog find($id, $lockMode = null, $lockVersion = null)
 * @method null|StatusLog findOneBy(array $criteria, array $orderBy = null)
 * @method StatusLog[]    findAll()
 * @method StatusLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusLogRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
	{
		$metadata = new ClassMetadata(StatusLog::class);
		parent::__construct($em, $metadata);
	}

	public function save(StatusLog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StatusLog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return array<int<0, max>, StatusLog>
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function latest(): array
    {
        $loggedJobsName = $this->createQueryBuilder(alias: 'sl')
            ->select('sl.jobName')
            ->distinct(true)
            ->orderBy('sl.jobName', 'ASC')
            ->getQuery()
            ->getSingleColumnResult()
        ;

        $returnData = [];
        foreach ($loggedJobsName as $jobName) {
            $row = $this->createQueryBuilder(alias: 'sl')
                ->where('sl.jobName = :jobName')
                ->setParameter('jobName', $jobName)
                ->setMaxResults(1)
                ->orderBy('sl.start', 'DESC')
                ->getQuery()
                ->getSingleResult()
            ;
            if ($row instanceof StatusLog) {
                $returnData[] = $row;
            }
        }

        return $returnData;
    }
}
