<?php

namespace BooksStoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BooksStoreBundle\Entity\Books;
use BooksStoreBundle\Form\BooksType;

/**
 * Books controller.
 *
 */
class BooksController extends Controller
{

    /**
     * Lists all Books entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BooksStoreBundle:Books')->findAll();

        return $this->render('BooksStoreBundle:Books:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Books entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Books();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('books_show', array('id' => $entity->getId())));
        }

        return $this->render('BooksStoreBundle:Books:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Books entity.
     *
     * @param Books $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Books $entity)
    {
        $form = $this->createForm(new BooksType(), $entity, array(
            'action' => $this->generateUrl('books_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Books entity.
     *
     */
    public function newAction()
    {
        $entity = new Books();
        $form   = $this->createCreateForm($entity);

        return $this->render('BooksStoreBundle:Books:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Books entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BooksStoreBundle:Books')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Books entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BooksStoreBundle:Books:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Books entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BooksStoreBundle:Books')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Books entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BooksStoreBundle:Books:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Books entity.
    *
    * @param Books $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Books $entity)
    {
        $form = $this->createForm(new BooksType(), $entity, array(
            'action' => $this->generateUrl('books_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Books entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BooksStoreBundle:Books')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Books entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('books_edit', array('id' => $id)));
        }

        return $this->render('BooksStoreBundle:Books:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Books entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BooksStoreBundle:Books')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Books entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('books'));
    }

    /**
     * Creates a form to delete a Books entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('books_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
