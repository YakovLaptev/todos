<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int todo_list_id
 * @property string name
 * @property bool is_resolved
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Todo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'todo_list_id',
        'name',
        'is_resolved'
    ];

    protected $casts = [
        'is_resolved' => 'boolean'
    ];

    /**
     * Scope для получения решенных пунктов
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsResopved($query)
    {
        return $query->where('is_resolved', true);
    }

    /**
     * Метод возвращает код списка
     *
     * @return string
     */
    public function getListCode(): string
    {
        return $this->list->code ?? TodoList::COMMON_CODE;
    }

    /**
     * Метод устанавливает отношения с таблицей todo_lists
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function list()
    {
        return $this->belongsTo(TodoList::class, 'todo_list_id');
    }
}
