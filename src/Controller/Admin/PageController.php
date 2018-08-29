<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Form\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/pages")
 */
class PageController extends Controller
{
    /**
     * @Route("/", name="admin_page_index", methods="GET")
     */
    public function index(): Response
    {
        $pages = $this->getDoctrine()
            ->getRepository(Page::class)
            ->findAll();

        return $this->render('admin/page/index.html.twig', ['pages' => $pages]);
    }

    /**
     * @Route("/new", name="admin_page_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('admin_page_index');
        }

        return $this->render('admin/page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_page_show", methods="GET")
     */
    public function show(Page $page): Response
    {
        return $this->render('admin/page/show.html.twig', ['page' => $page]);
    }

    /**
     * @Route("/{id}/edit", name="admin_page_edit", methods="GET|POST")
     */
    public function edit(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_page_edit', ['id' => $page->getId()]);
        }

        return $this->render('admin/page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_page_delete", methods="DELETE")
     */
    public function delete(Request $request, Page $page): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
        }

        return $this->redirectToRoute('admin_page_index');
    }
}
