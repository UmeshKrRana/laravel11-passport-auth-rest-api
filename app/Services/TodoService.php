<?php
namespace App\Services;

use App\Repository\TodoRepository;

class TodoService
{
    protected $todoRepository;
    protected $authService;

    /**
     * Create a new class instance.
     */
    public function __construct(TodoRepository $todoRepository, AuthService $authService)
    {
        $this->todoRepository = $todoRepository;
        $this->authService    = $authService;
    }

    /**
     * Function: getTodos
     * Description: To fetch todos based on logged in user
     */
    public function getTodos()
    {
        # Get Auth User
        $authUser = $this->authService->getAuthUser();

        # Fetch Todos based on Auth User id
        return $this->todoRepository->getTodos($authUser->id);
    }

    /**
     * Function: storeTodo
     * @param array $todoRequest
     */
    public function storeTodo($todoRequest)
    {
        # Prepare Todo Request
        $todoRequest = $this->prepareTodoRequest($todoRequest);

        return $this->todoRepository->storeTodo($todoRequest);
    }

    /**
     * Function: prepareTodoRequest
     * @param object $todoRequest
     * @return array $todoRequest
     */
    public function prepareTodoRequest($todoRequest)
    {
        # Get Auth User
        $authUser = $this->authService->getAuthUser();

        $todoRequest            = $todoRequest->all();
        $todoRequest['user_id'] = $authUser->id;

        return $todoRequest;
    }

    /**
     * Function: showTodo
     * @param Todo $todo
     */
    public function showTodo($todo)
    {
        # Get Auth User
        $authUser = $this->authService->getAuthUser();

        return $this->todoRepository->getTodo($todo, $authUser->id);
    }

    /**
     * Function: updateTodo
     * @param object $todoRequest
     * @param Todo $todo
     * @return $todo
     */
    public function updateTodo($todoRequest, $todo)
    {

        # Find Todo Based on Todo Id and Auth User Id
        $todo = $this->showTodo($todo);

        if ($todo) {
            $todo->title       = $todoRequest->title;
            $todo->description = $todoRequest->description;

            return $todo->save();
        }
    }

    /**
     * Function: deleteTodo
     * @param Todo $todo
     */
    public function deleteTodo($todo)
    {
        # Find Todo Based on Todo Id and Auth User Id
        $todo = $this->showTodo($todo);

        if ($todo) {
            return $todo->delete();
        }
    }
}
