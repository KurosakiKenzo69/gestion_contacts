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

    public function orderByField($field, $direction)
    {
        $allowedFields = ['nom', 'prenom', 'email'];

        if (!in_array($field, $allowedFields)) {
            $field = 'nom'; // Valeur par défaut
        }

        return $this->createQueryBuilder('c')
            ->orderBy('c.' . $field, $direction)
            ->getQuery()
            ->getResult();
    }

    public function orderByName(): array
    {
        return $this->findBy([], ['nom' => 'ASC']);
    }
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
