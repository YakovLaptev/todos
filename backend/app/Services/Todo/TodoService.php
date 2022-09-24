<?php

namespace App\Services\Todo;

use App\Models\Todo;
use App\Models\TodoList;
use App\Services\Exceptions\UndefinedException;

/**
 * Класс TodoService направлен на работу c Todo списком и элементами
 *
 * @package App\Services\Todo
 */
class TodoService
{
    /**
     * Метод добавляет Todo'шку в список, 
     * если список не указан, то добавляет в общий
     *
     * @param string $name
     * @return Todo
     * @throws UndefinedException
     */
    public static function addTodo(string $name = '', TodoList $list = null): Todo
    {
        if (empty($name)) {
            throw new UndefinedException('Имя не может быть пустым');
        }

        $todo = new Todo();
        $todo->name = $name;

        if (empty($list->id)) {
            $commonList = TodoList::getCommonList();
            $todo->todo_list_id = $commonList->id;
        }

        $todo->save();
        $todo->load('list');
        
        return $todo;
    }

    /**
     * Метод отмечает Todo'шку как выполненную|не выполненную
     *
     * @param int $id
     * @param string $mode
     * @return bool
     * @throws UndefinedException
     */
    public static function resolveOrUnresolveTodo(int $id, string $mode = 'resolve'): bool
    {
        if (empty($id)) {
            throw new UndefinedException('Идентификатор не может быть пустым');
        }

        $todo = Todo::findOrFail($id);

        $todo->is_resolved = $mode == 'resolve';
        $todo->save();

        return $todo->is_resolved;
    }

    /**
     * Метод удаляет Todo'шку 
     * 
     * @param int $id
     * @return void
     * @throws UndefinedException
     */
    public static function removeTodo(int $id)
    {
        if (empty($id)) {
            throw new UndefinedException('Идентификатор не может быть пустым');
        }

        $todo = Todo::findOrFail($id);

        $todo->delete();
    }

     /**
     * Метод переносит Todo'шку в соседний список 
     * 
     * @param int $id
     * @return Todo
     * @throws UndefinedException
     */
    public static function moveTodoToNearbyList(int $id): Todo
    {
        if (empty($id)) {
            throw new UndefinedException('Идентификатор не может быть пустым');
        }

        $todo = Todo::with('list')->findOrFail($id);

        $todoLists = TodoList::all()->toArray();

        foreach($todoLists as $todoListKey => $todoList) {
            if($todoList['id'] == $todo->list->id) {
                $todo->todo_list_id = $todoLists[$todoListKey+1]['id'] ?? $todoLists[$todoListKey-1]['id'] ?? TodoList::getCommonList()->id;
                break;
            }
        }

        $todo->save();

        return $todo;
    }
}
