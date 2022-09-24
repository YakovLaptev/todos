<script setup>
    import axios from 'axios';
    import { reactive, computed } from "vue";
    import Todos from "./components/Todos.vue";
    import InputTodo from "./components/InputTodo.vue";

    axios.defaults.withCredentials = true
    
    const state = reactive({
        items: [],
        lists: [],
    });

    // actions with todos
    const addTodoToList = (response) => {
        var todo = response.data.data.todo;
        state.items.push({
            id: todo.id,
            name: todo.name,
            list: todo.list.code || 'common',
            isResolved: false,
        });
    };

    const removeTodo = (response, todo) => {
        if(response.data.status === true) {
            var itemToDelete = state.items.map((item, key) => {
                if(item.id == todo.id) {
                    state.items.splice(key, 1);
                }   
            });
        }
    };

    const doneOrUndone = (result, todo) => {
        if(result.data.status === true) {
            todo.isResolved = result.data.data.isResolved;
        }
    };

    const moveTodoToNearbyList = (result, todo) => {
        if(result.data.status === true) {
            todo.list = result.data.data.list.code;
        }
    };


    // handlers
    const addTodoHandler = (name) => {
        axios.post('/api/todo/add', {
            name: name
        })
        .then(addTodoToList)
        .catch((error) => { alert(`Error ${error.message}`) })
    };

    const removeHandler = (todo) => {
        axios.delete('/api/todo/remove/' + todo.id)
        .then((responce) => {removeTodo(responce, todo)})
        .catch((error) => { alert(`Error ${error.message}`) })
    };

    const doneOrUndoneHandler = (todo, mode) => {
        axios.put('/api/todo/resolve/' + todo.id, {
            mode: mode
        })
        .then((result) => {doneOrUndone(result, todo)})
        .catch((error) => { alert(`Error ${error.message}`) })
    };

    const moveTodoToNearbyListHandler = (todo) => {
        axios.put('/api/todo/move/' + todo.id)
        .then((responce) => {moveTodoToNearbyList(responce, todo)})
        .catch((error) => { alert(`Error ${error.message}`) })
    };

    const commonTodos = computed(() => {
        var todos = state.items.filter((item) => item.list == 'common');
        return todos.sort((a, b) => a.isResolved - b.isResolved );
    });
    const commonList = computed(() => {
        return state.lists.find((item) => item.code == 'common');
    });
    const urgentTodos = computed(() => {
        var todos = state.items.filter((item) => item.list == 'urgent');
        return todos.sort((a, b) => a.isResolved - b.isResolved );
    });
    const urgentList = computed(() => {
        return state.lists.find((item) => item.code == 'urgent');
    });

   
     // get todo lists
     axios.get('/api/todo/lists')
        .then((response) => {
            if(response.data.status === true) {
                var lists = response.data.data.lists;
                lists.map(function(list) {
                    state.lists.push({
                        code: list.code,
                        name: list.name,
                    });

                    if(!!list.todos) {
                        list.todos.map(function(todo) {
                            state.items.push({
                                id: todo.id,
                                name: todo.name,
                                list: list.code || 'common',
                                isResolved: todo.is_resolved,
                            });
                        }); 
                    }
                });
            }
        })
        .catch((error) => { alert(`Error ${error.message}`) });
</script>

<template>
    <div class="todos">
        <div class="common">
            <Todos :todos="commonTodos" :list="commonList"
                @remove-handler="removeHandler" 
                @done-or-undone-handler="doneOrUndoneHandler" 
                @move-todo-to-nearby-list-handler="moveTodoToNearbyListHandler" 
            />
            <hr />
            <InputTodo @add-todo-handler="addTodoHandler" /> 
        </div>
        <div class="urgent">
            <Todos :todos="urgentTodos" :list="urgentList"
                @remove-handler="removeHandler" 
                @done-or-undone-handler="doneOrUndoneHandler" 
                @move-todo-to-nearby-list-handler="moveTodoToNearbyListHandler" 
            />
        </div>
    </div>
</template>

<style scoped>
    * {
        margin: 10;
        padding: 2;
        box-sizing: border-box;
    }
</style>
    