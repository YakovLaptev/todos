<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use \Illuminate\Http\JsonResponse;

class TodoListController extends Controller
{
    /**
     * Отображение списков Todo
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $todoListsWithTodos = TodoList::with('todos')->get();

        return ResponseHelper::sendSuccess(['lists' => $todoListsWithTodos]);
    }
}
