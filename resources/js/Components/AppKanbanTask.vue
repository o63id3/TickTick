<script setup>
import {computed, ref} from "vue";
import {cva} from "class-variance-authority";
import AppModal from "@/Components/AppModal.vue";
import {router, useForm} from "@inertiajs/vue3";

const props = defineProps({
  task: Object
})

const {isNewTaskItemModalOpen, form, submit} = useNewTask()
const {toggleTask, toggleTaskItem} = useToggle()

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
});

function useNewTask() {
  const isNewTaskItemModalOpen = ref(false)

  const form = useForm({
    title: null,
  })

  const submit = () => {
    form.post(route('task.items.store', props.task.id), {
      onSuccess: () => {
        isNewTaskItemModalOpen.value = false
        form.reset()
      }
    })
  }

  return {
    isNewTaskItemModalOpen,
    form,
    submit
  }
}

function useToggle() {
  const toggleTask = () => {
    router.put(route('tasks.toggle.completed', props.task.id), undefined, {preserveScroll: true})
  }

  const toggleTaskItem = (itemId) => {
    router.put(route('items.toggle.completed', itemId), undefined, {preserveScroll: true})
  }

  return {
    toggleTask,
    toggleTaskItem
  }
}
</script>

<template>
  <div>
    <div>
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
          <input
            @change="toggleTask"
            :id="'task-' + task.id"
            type="checkbox"
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

              <form @submit.prevent="submit" class="flex flex-col gap-4">
                <div>
                  <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                  <input v-model="form.title" type="text" id="title"
                         class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                         placeholder="Task title"/>

                  <p v-if="form.errors.title" class="text-xs text-red-500 mt-1">{{ form.errors.title }}</p>
                </div>

                <div class="flex items-center justify-end gap-2">
                  <button @click="isNewTaskModalOpen = false" class="rounded dark:text-white text-sm">Cancel</button>
                  <button type="submit"
                          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Create
                  </button>
                </div>
              </form>
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
        <input
          @change="toggleTaskItem(taskItem.id)"
          :id="'task-item-' + taskItem.id"
          :checked="taskItem.completed"
          type="checkbox"
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