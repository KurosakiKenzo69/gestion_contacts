<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function delete(Contact $contact): void
    {
        $this->getEntityManager()->remove($contact);
        $this->getEntityManager()->flush();
    }

    public function save(Contact $contact): void
    {
        $this->getEntityManager()->persist($contact);
        $this->getEntityManager()->flush();
    }

    public function update(Contact $contact): void
    {
        $this->getEntityManager()->flush();
    }

    public function findContactById(int $id): ?Contact
    {
        return $this->find($id);
    }

    public function orderByName(): array
    {
        return $this->findBy([], ['nom' => 'ASC']);
    }

    // Dans le Repository de Contact
    public function countAllContacts()
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function search(string $search): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.nom LIKE :search OR c.prenom LIKE :search OR c.email LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    }
}
