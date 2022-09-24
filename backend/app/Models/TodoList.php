<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string name
 * @property string code
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class TodoList extends Model
{

    const COMMON_CODE = 'common';
    const URGENT_CODE = 'urgent';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'code'
    ];

    /**
     * Метод устанавливает отношения с таблицей todos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todos()
    {
        return $this->hasMany(Todo::class, 'todo_list_id');
    }
    
    /**
     * Метод возвращает обычный список Todo
     *
     * @return TodoList
     */
    public static function getCommonList(): TodoList
    {
        return self::where('code', self::COMMON_CODE)->firstOrNew();
    }
}
