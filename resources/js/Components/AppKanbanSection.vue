<script setup>
import AppKanbanTask from "@/Components/AppKanbanTask.vue";
import AppModal from "@/Components/AppModal.vue";
import {ref} from "vue";

defineProps({
  item: Object
})

const isNewTaskModalOpen = ref(false)
</script>

<template>
  <div class="bg-white dark:bg-gray-800 dark:border-gray-700 rounded px-2 py-2">
    <!-- board category header -->
    <div class="flex justify-between items-center mb-2 mx-1">
      <div class="flex items-center justify-between">
        <h2 class="bg-indigo-300 text-sm w-max px-1 rounded mr-2 text-black">{{ item.name }}</h2>
        <p class="text-gray-400 dark:text-gray-500 text-sm">({{ item.uncompletedTasksCount }})</p>
      </div>

<!--      <div class="text-black text-lg cursor-pointer rounded-md px-1.5 bg-indigo-300">-->
        <div>
          <button
            type="button"
            @click="isNewTaskModalOpen = true"
            class="rounded-md bg-black/20 px-1.5 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
          >
            +
          </button>

          <AppModal :is-open="isNewTaskModalOpen" @close="isNewTaskModalOpen = false">
            <template #title>Create New Task</template>
          </AppModal>
        </div>
<!--      </div>-->
    </div>

    <div class="grid gap-2">
      <AppKanbanTask
        v-for="task in item.tasks"
        :task="task"
        :key="task.id"
        class="p-2 rounded shadow-sm border-2"
        :class="[
          task.completed ? 'border-indigo-100 dark:border-indigo-700' : 'border-gray-100 dark:border-gray-700'
        ]"
      />
    </div>
  </div>
</template>