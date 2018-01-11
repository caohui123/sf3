<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\Profile;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $number = mt_rand(0, 100);

        return new Response(
            '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }

    /**
     * @Route("/lucky/test")
     */
    public function testAction()
    {
        $em = $this->getDoctrine()->getManager();

        $book = new Book();
        $book->setName('book3');
        $book->setPrice(100);

        $book2 = new Book();
        $book2->setName('book4');
        $book2->setPrice(200);

        $user = new User();
        $user->setName('caohui1');

        $profile = new Profile();
        $profile->setAge(18);
        $profile->setUser($user);
        $profile->setRealName('gogo2');
        $profile->setSex(1);

        $user->setBook($book);
        $user->setBook($book2);
        $user->setProfile($profile);
        $em->persist($book);
        $em->persist($book2);
        $em->persist($profile);
        $em->persist($user);
        $em->flush();

        return new Response(
            '<html><body>Lucky number: ' . $user->getId() . '</body></html>'
        );
    }
}
