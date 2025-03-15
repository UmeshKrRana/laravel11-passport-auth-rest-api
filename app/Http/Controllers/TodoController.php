<?php
namespace App\Http\Controllers;

use App\Helper\ApiResponse;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Services\TodoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $todos = $this->todoService->getTodos();
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $todos, statusCode: self::SUCCESS);

        } catch (Exception $e) {
            Log::error('Exception occured while fetching todos' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param App\Http\Requests\TodoRequest $request
     * @return Illuminate\Http\JsonResponse
     */
    public function store(TodoRequest $request)
    {
        try {
            $todo = $this->todoService->storeTodo($request);
            if ($todo) {
                return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $todo, statusCode: self::CREATED);
            }
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::FAILED_MESSAGE, statusCode: self::ERROR);

        } catch (Exception $e) {
            Log::error('Exception occured while saving todo' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        try {
            $todo = $this->todoService->showTodo($todo);

            if ($todo) {
                return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $todo, statusCode: self::SUCCESS);
            }

            return ApiResponse::error(status: self::ERROR_STATUS, message: self::FAILED_MESSAGE, statusCode: self::ERROR);
        } catch (Exception $e) {
            Log::error('Exception occured while fetching the todo' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        try {
            # Update Todo
            $todo = $this->todoService->updateTodo($request, $todo);

            if ($todo) {
                return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $todo, statusCode: self::SUCCESS);
            }

            return ApiResponse::error(status: self::ERROR_STATUS, message: self::FAILED_MESSAGE, statusCode: self::ERROR);

        } catch (Exception $e) {
            Log::error('Exception occured while updating the todo' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        try {
            # Delete Todo
            $todo = $this->todoService->deleteTodo($todo);

            if ($todo) {
                return ApiResponse::success(status: self::SUCCESS_STATUS, message: 'Todo ' . self::DELETED_SUCCESS, statusCode: self::SUCCESS);
            }

            return ApiResponse::error(status: self::ERROR_STATUS, message: self::DELETED_FAILED, statusCode: self::ERROR);

        } catch (Exception $e) {
            Log::error('Exception occured while deleting the todo' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }
}
