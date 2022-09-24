<script setup>
    import { defineEmits } from 'vue';

    const emit = defineEmits(['removeHandler', 'doneOrUndoneHandler', 'moveTodoToNearbyListHandler'])
    const props = defineProps({
        todos: Array,
        list: Object
    });

    const onRemove = (todo) => {
        emit('removeHandler', todo)
    }

    const onDoneOrUndone = (todo, mode) => {
        emit('doneOrUndoneHandler', todo, mode)
    }

    const onmoveTodoToNearbyList = (todo) => {
        emit('moveTodoToNearbyListHandler', todo)
    }
</script>

<template>
    <h2>{{ (!!props.list) ? props.list.name : '' }} <span :class="(props.todos.length >= 3 && props.list.code == 'urgent') ? 'over-count' : ''">({{ props.todos.length }})</span></h2>
    <ul v-if="props.todos.length > 0">
        <li v-for="todo in props.todos" :data-id="todo.id" :class="(todo.isResolved) ? 'resolved' : ''">
            <span>{{ todo.name }}</span>
            <button @click="onDoneOrUndone(todo, 'resolve')" v-if="!todo.isResolved">done</button>
            <button @click="onDoneOrUndone(todo, 'unresolve')" v-if="todo.isResolved">undone</button>
            <button @click="onmoveTodoToNearbyList(todo)" v-if="todo.list == 'common'">move to urgent</button>
            <button @click="onmoveTodoToNearbyList(todo)" v-if="todo.list == 'urgent'">move to common</button>
            <button @click="onRemove(todo)">remove</button>
        </li>
    </ul>
    <p class="empty-list" v-else>Todo list empty</p>
</template>