<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
final class TaskController extends AbstractController
{
    #[Route(name: 'app_task_index', methods: ['GET'])]
    public function index(Request $request, TaskRepository $taskRepository): Response
    {
        $statusFilter = $request->query->get('status');

        if ($statusFilter === 'done') {
            $tasks = $taskRepository->findBy(['isDone' => true]);
        } elseif ($statusFilter === 'not_done') {
            $tasks = $taskRepository->findBy(['isDone' => false]);
        } else {
            $tasks = $taskRepository->findAll();
        }

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'Tâche créée avec succès !');
            return $this->redirectToRoute('app_task_index');
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

             $this->addFlash('success', 'La tâche a bien été mise à jour.');

        // Redirection après la mise à jour
        return $this->redirectToRoute('app_task_index', ['id' => $task->getId()]);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {

        if (!$task) {
            throw $this->createNotFoundException('Tâche introuvable.');
        }

        $entityManager->remove($task);
        $entityManager->flush();

        $this->addFlash('success', 'Vous avez supprimé la tâche.');
        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        
    }

    #[Route('/{id}/finished', name: 'app_task_finished', methods: ['POST'])]
    public function markAsDone(Task $task, EntityManagerInterface $em): Response
    {
        $task->setIsDone(true);
        $em->flush();

        $this->addFlash('success', 'Tâche marquée comme "terminée".');

        return $this->redirectToRoute('app_task_index');
    }

    #[Route('/{id}/unfinished', name: 'app_task_unfinished', methods: ['POST'])]
    public function markAsUndone(Task $task, EntityManagerInterface $em): Response
    {
        $task->setIsDone(false);
        $em->flush();

        $this->addFlash('success', 'Tâche marquée comme "en cours".');

        return $this->redirectToRoute('app_task_index');
    }
}
