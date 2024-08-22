<script setup>
import TaskItem from "@/Pages/Tasks/Partials/TaskItem.vue";
import {startCase} from 'lodash'

defineProps({
  name: String,
  tasks: Array
})
</script>

<template>
  <div v-if="tasks.length" class="space-y-4">
    <h1 class="text-4xl cursor-default hover:underline"># {{ startCase(name) }}</h1>

    <div class="grid grid-cols-3 gap-2">
      <TaskItem
        v-for="task in tasks"
        :key="task.id"
        :task="task"
      />
    </div>
  </div>
</template>
