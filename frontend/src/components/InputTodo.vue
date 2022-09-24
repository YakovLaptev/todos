<script setup>
    import { defineEmits } from 'vue';

    const emit = defineEmits(['addTodoHandler',])

    const onAddTodo = (e) => {
        emit('addTodoHandler', e.target.value)
        e.target.value = ''
    }
</script>

<template>
    <div class="todo">
        <span>Add Todo:</span>
        <input type="text" @keydown.enter="onAddTodo" />
    </div>
</template>