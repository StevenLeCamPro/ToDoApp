<?php
namespace App\Controller\Api;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
        // Récupérer la tâche par son ID
        $task = $taskRepository->find($id);

        if (!$task) {
            return $this->json(['message' => 'Task not found'], 404);
        }

        // Retourner les données de la tâche en JSON
        return $this->json([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'isDone' => $task->IsDone(),
            'createdAt' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }
}
