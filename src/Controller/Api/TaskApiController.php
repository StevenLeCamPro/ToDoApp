<?php
namespace App\Controller\Api;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface as em;

class TaskApiController extends AbstractController
{
    
      #[Route('/api/tasks', name:"api_tasks", methods:["GET"])]
     
    public function getTasks(TaskRepository $taskRepository): JsonResponse
    {
        // Récupérer toutes les tâches
        $tasks = $taskRepository->findAll();

        // Créer un tableau de données JSON
        $data = [];

        foreach ($tasks as $task) {
            $data[] = [
                'id' => $task->getId(),
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'isDone' => $task->IsDone(),
                'createdAt' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        // Retourner les données en JSON
        return $this->json($data);
    }

     #[Route('/api/task/{id}', name:"api_task_show", methods:["GET"])]
    public function getTask(int $id, TaskRepository $taskRepository): JsonResponse
    {
        $task = $taskRepository->find($id);

        if (!$task) {
            return $this->json(['message' => 'Tâche non trouvée'], 404);
        }

        return $this->json([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'isDone' => $task->IsDone(),
            'createdAt' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }

    #[Route('/api/taskCreate', name:"api_task_create", methods:["POST"])]
    public function createTask(Request $request, TaskRepository $taskRepository, em $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $task = new Task();
        $task->setTitle($data['title']);
        $task->setDescription($data['description']);
        $task->setIsDone($data['isDone']);
        $task->setCreatedAt(new \DateTimeImmutable());

        $em->persist($task);
        $em->flush();

        return $this->json([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'isDone' => $task->IsDone(),
            'createdAt' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
        ], 201);
    }

    #[Route('/api/updateTask/{id}', name:"api_task_update", methods:["PUT"])]
    public function updateTask(int $id, Request $request, TaskRepository $taskRepository, em $em): JsonResponse
    {
        $task = $taskRepository->find($id);

        if (!$task) {
            return $this->json(['message' => 'Tâche non trouvée'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $task->setTitle($data['title']);
        $task->setDescription($data['description']);
        $task->setIsDone($data['isDone']);

        $em->flush();

        return $this->json([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'isDone' => $task->IsDone(),
            'createdAt' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }

    #[Route('/api/deleteTask/{id}', name:"api_task_delete", methods:["DELETE"])]
    public function deleteTask(int $id, TaskRepository $taskRepository, em $em){
        $task = $taskRepository->find($id);

        if (!$task){
            return $this->json(['message' => 'Pas de tâche trouvée'], 404);
        }

        $em->remove($task);
        $em->flush();

        return $this->json(['message' => 'Tâche supprimée avec succès']);
    }
}
