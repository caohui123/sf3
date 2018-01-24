<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController extends FOSRestController
{

    /**
     * @Rest\Get("/test")
     */
    public function indexAction(Request $request)
    {
        $data = ['hello' => 'world'];
        $view = $this->view($data, Response::HTTP_OK);
        return $view;
    }

    /**
     * @Rest\Get("/getuser",name="get_rest_user")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/getuser/{id}")
     */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if ($singleresult === null) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Post("/getuser/")
     * @Rest\View(StatusCode = Response::HTTP_NO_CONTENT)
     */
    public function postAction(Request $request)
    {

        $form = $this->createForm(UserType::class, null, [
            'csrf_protection' => false,
        ]);

        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $this->view($this->buildErrorArray($form), Response::HTTP_BAD_REQUEST);
        }
        /**
         * @var $userPost User
         */
        $userPost = $form->getData();
//print_r($userPost);exit;
        $em = $this->getDoctrine()->getManager();
        $em->persist($userPost);
        $em->flush();

        $routeOptions = [
            'id' => $userPost->getId(),
            //'_format' => $request->get('_format'),
        ];
        //return $this->routeRedirectView('get_rest_user', $routeOptions, Response::HTTP_CREATED);
        return new View("User Added Successfully".$userPost->getId(), Response::HTTP_OK);

        /* $data = new User;
         $name = $request->get('name');
         if(empty($name))
         {
             return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
         }
         $data->setName($name);
         $em = $this->getDoctrine()->getManager();
         $em->persist($data);
         $em->flush();
         return new View("User Added Successfully", Response::HTTP_OK);*/
    }

    /**
     * @Rest\Put("/getuser/{id}")
     */
    public function updateAction($id, Request $request)
    {
        $name = $request->get('name');
        $sn = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (empty($user)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        if (!empty($name)) {
            $user->setName($name);
            $sn->flush();
            return new View("User Updated Successfully", Response::HTTP_OK);
        }
        return new View("User name or role cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
    }


    /**
     * @Rest\Delete("/getuser/{id}")
     */
    public function deleteAction($id)
    {
        $sn = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (empty($user)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        } else {
            $sn->remove($user);
            $sn->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }

    public function buildErrorArray(FormInterface $form)
    {
        $errors = [];

        foreach ($form->all() as $child) {
            $errors = array_merge(
                $errors,
                $this->buildErrorArray($child)
            );
        }

        foreach ($form->getErrors() as $error) {
            $errors[$error->getCause()->getPropertyPath()] = $error->getMessage();
        }

        return $errors;
    }
}
