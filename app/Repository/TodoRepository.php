<?php
namespace App\Repository;

use App\Models\Todo;

class TodoRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Function: getTodos
     * @param int $userId
     * @return Todo
     */
    public function getTodos($userId)
    {
        return Todo::where('user_id', $userId)->paginate(10);
    }

    /**
     * Function: storeTodo
     * @param array $todoRequest
     * @return object Todo
     */
    public function storeTodo($todoRequest)
    {
        return Todo::create($todoRequest);
    }

    /**
     * Function: getTodo
     * @param Todo $todo
     */
    public function getTodo($todo, $userId)
    {
        return $todo->where('user_id', $userId)->first();
    }
}
