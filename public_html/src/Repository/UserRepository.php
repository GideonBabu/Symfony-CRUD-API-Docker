<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }
    
    public function transform(User $user)
    {
        return [
                'id'    => (int) $user->getId(),
                'first_name' => (string) $user->getFirstName(),
                'last_name' => (string) $user->getLastName(),
                'email' => (string) $user->getEmail(),
                'mobile' => (int) $user->getMobile(),
                'street' => (string) $user->getStreet(),
                'city' => (string) $user->getCity(),
                'country' => (string) $user->getCountry(),
                'zip' => (string) $user->getZip(),
        ];
    }

    public function transformAll()
    {
        $users = $this->findAll();
        $usersArray = [];

        foreach ($users as $user) {
            $usersArray[] = $this->transform($user);
        }
        return $usersArray;
    }
}
