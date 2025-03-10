<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/task')]
final class TaskController extends AbstractController
{
    #[Route(name: 'app_task_index', methods: ['GET'])]
    // src/Controller/TaskController.php

public function index(Request $request, TaskRepository $taskRepository): Response
{
    // Récupérer l'état du filtre depuis la requête
    $statusFilter = $request->query->get('status'); // 'done' ou 'not_done'

    if ($statusFilter === 'done') {
        // Si 'done' est sélectionné, afficher uniquement les tâches terminées
        $tasks = $taskRepository->findBy(['isDone' => true]);
    } elseif ($statusFilter === 'not_done') {
        // Si 'not_done' est sélectionné, afficher uniquement les tâches non terminées
        $tasks = $taskRepository->findBy(['isDone' => false]);
    } else {
        // Par défaut, afficher toutes les tâches
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

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
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

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/task/{id}/finished', name: 'app_task_finished', methods: ['POST'])]
    public function markAsDone(Task $task, EntityManagerInterface $em): Response
{
    // Marquer la tâche comme terminée
    $task->setIsDone(true);

    // Enregistrer la modification dans la base de données
    $em->flush();

    // Rediriger l'utilisateur vers la liste des tâches
    return $this->redirectToRoute('app_task_index');
}

#[Route('/task/{id}/unfinished', name: 'app_task_unfinished', methods: ['POST'])]
public function markAsUndone(Task $task, EntityManagerInterface $em): Response
{
    // Marquer la tâche comme non terminée
    $task->setIsDone(false);

    // Enregistrer la modification dans la base de données
    $em->flush();

    // Rediriger l'utilisateur vers la liste des tâches
    return $this->redirectToRoute('app_task_index');
}


}