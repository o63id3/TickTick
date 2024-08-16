<script setup>
import {computed, ref} from "vue";
import {cva} from "class-variance-authority";
import AppModal from "@/Components/AppModal.vue";

const props = defineProps({
  task: Object
})

const isNewTaskItemModalOpen = ref(false)

const priorityClass = computed(() => {
  return cva("text-xs rounded px-1 py-0.5", {
    variants: {
      priority: {
        None: "text-white bg-white/50",
        Low: "text-blue-400 bg-blue-900/50",
        Medium: "text-yellow-400 bg-yellow-900/50",
        High: "text-red-400 bg-red-900/50",
      },
    },
  })({
    priority: props.task.priority
  });
});</script>

<template>
  <div>
    <div>
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
          <input :id="'task-' + task.id" type="checkbox"
                 :checked="task.completed"
                 class="w-4 h-4 text-blue-600 bg-gray-100 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700">
          <label
            :for="'task-' + task.id"
            class="select-none ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
            {{ task.title }}
          </label>
        </div>

        <div v-if="!task.completed">
          <div>
            <button
              type="button"
              @click="isNewTaskItemModalOpen = true"
              class="rounded-md bg-black/20 px-1.5 text-xs font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
            >
              +
            </button>

            <AppModal :is-open="isNewTaskItemModalOpen" @close="isNewTaskItemModalOpen = false">
              <template #title>Create New Task Item</template>
            </AppModal>
          </div>
        </div>
      </div>


      <p class="text-white text-xs mt-1">
        Priority: <span :class="priorityClass">{{ task.priority }}</span>
      </p>

      <p class="text-white text-xs mt-1">{{ task.description }}</p>

      <div v-if="task.items.length" class="border border-gray-100 dark:border-gray-700 my-2"></div>

      <div v-for="taskItem in task.items">
        <input :id="'task-item-' + taskItem.id" type="checkbox"
               :checked="taskItem.completed"
               class="w-3 h-3 text-blue-600 bg-gray-100 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700">
        <label
          :for="'task-item-' + taskItem.id"
          class="select-none ms-2 text-xs font-medium"
          :class="[
            taskItem.completed ? 'line-through decoration-indigo-900 dark:decoration-indigo-300 text-gray-900/50 dark:text-gray-300/50': 'text-gray-900 dark:text-gray-300'
          ]"
        >
          {{ taskItem.title }}
        </label>
      </div>
    </div>
  </div>
</template>