<?php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends ApiController
{
    /**
    * @Route("/users", methods="GET")
    */
    public function index(UserRepository $userRepository)
    {        
        $users = $userRepository->transformAll();

        return $this->respond($users);
    }

    /**
    * @Route("/users", methods="POST")
    */
    public function create(Request $request, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the title
        if (! $request->get('first_name')) {
            return $this->respondValidationError('Please provide a first name!');
        }

        // persist the new user
        $user = new User;
        $user->setFirstName($request->get('first_name'));
        $user->setLastName($request->get('last_name'));        
        $user->setEmail($request->get('email'));
        $user->setMobile($request->get('mobile'));
        $user->setStreet($request->get('street'));
        $user->setCity($request->get('city'));
        $user->setCountry($request->get('country'));
        $user->setZip($request->get('zip'));        
        $em->persist($user);
        $em->flush();

        return $this->respondCreated($userRepository->transform($user));
    }
    /**
    * @Route("/users/{id}", methods="PUT")
    */
    public function update($id, Request $request, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);        
        $user = $userRepository->find($id);
        if(empty($user)) {            
            return $this->respond('Invalid user ID');
        }
        if($request->get('first_name')) $user->setFirstName($request->get('first_name'));
        if($request->get('last_name')) $user->setLastName($request->get('last_name'));
        if($request->get('email')) $user->setLastName($request->get('email'));
        if($request->get('mobile')) $user->setLastName($request->get('mobile'));
        if($request->get('street')) $user->setLastName($request->get('street'));
        if($request->get('city')) $user->setLastName($request->get('city'));
        if($request->get('country')) $user->setLastName($request->get('country'));
        if($request->get('zip')) $user->setLastName($request->get('zip'));
        $em->flush();

        return $this->respondCreated($userRepository->transform($user));
    }

   /**
    * @Route("/users/{id}", methods="DELETE")
    */
    public function deleteAction($id, Request $request, UserRepository $userRepository, EntityManagerInterface $em){
        $request = $this->transformJsonBody($request);        
        $user = $userRepository->find($id);
        if(empty($user)) {            
            return $this->respond('Invalid user ID');
        }
        $em->remove($user);
        $em->flush();
        return $this->respond('User deleted successfully.');
    }
}