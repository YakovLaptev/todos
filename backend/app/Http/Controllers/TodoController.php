<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use App\Helpers\ResponseHelper;
use App\Services\Todo\TodoService;
use \Illuminate\Http\JsonResponse;

class TodoController extends Controller
{

    /**
     * Отображение отфильтрованных проектов
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function addTodo(Request $request): JsonResponse
    {
        $name = $request->get('name', '');
        try {
            $todo = TodoService::addTodo($name);

            return ResponseHelper::sendSuccess(['todo' => $todo]);
        } catch (\Exception $e) {
            return ResponseHelper::sendError($e->getMessage());
        }
    }

    /**
     * Пометка пункта сделанным/не сделанным
     * @param int $id
     * @param Request $request
     * @return Response
     * @throws Exception
     * 
     */
    public function resolveOrUnresolveTodo(int $id, Request $request): JsonResponse
    {
        $mode = $request->get('mode', '');
        try {
            $isResolved = TodoService::resolveOrUnresolveTodo($id, $mode);

            return ResponseHelper::sendSuccess(['isResolved' => $isResolved]);
        } catch (\Exception $e) {
            return ResponseHelper::sendError($e->getMessage());
        }
    }

    /**
     * Удаление пункта
     * @param int $id
     * @param Request $request
     * @return Response
     * @throws Exception
     * 
     */
    public function removeTodo(int $id, Request $request): JsonResponse
    {
        try {
            TodoService::removeTodo($id);

            return ResponseHelper::sendSuccess([]);
        } catch (\Exception $e) {
            return ResponseHelper::sendError($e->getMessage());
        }
    }

    /**
     * Перемещение пункта в соседний список
     * @param int $id
     * @param Request $request
     * @return Response
     * @throws Exception
     * 
     */
    public function moveTodoToNearbyList(int $id, Request $request): JsonResponse
    {
        try {
            $todo = TodoService::moveTodoToNearbyList($id);

            return ResponseHelper::sendSuccess(['list' => $todo->list]);
        } catch (\Exception $e) {
            return ResponseHelper::sendError($e->getMessage());
        }
    }
}
