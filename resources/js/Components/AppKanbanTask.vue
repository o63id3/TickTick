<script setup>
import {computed, nextTick, ref} from "vue";
import {cva} from "class-variance-authority";
import AppModal from "@/Components/AppModal.vue";
import {router, useForm} from "@inertiajs/vue3";
import {TrashIcon} from "@heroicons/vue/24/outline/index.js";
import AppKanbanItem from "@/Components/AppKanbanItem.vue";

const props = defineProps({
  task: Object
})

const {isNewTaskItemModalOpen, form, submit} = useNewTask()
const {toggleTask} = useToggleComplete()
const {
  isEditingTitle,
  showEditing,
  title,
  titleField,
  save,
  cancel,
  isEditingDescription,
  description,
  descriptionField,
  isEditingPriority,
  priority,
  priorityField
} = useEdit()

const priorities = [
  {name: 'None'},
  {name: 'Low'},
  {name: 'Medium'},
  {name: 'High'}
]

const {deleteTask} = useDelete()

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

function useToggleComplete() {
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

function useEdit() {
  const isEditingTitle = ref(false)
  const isEditingDescription = ref(false)
  const isEditingPriority = ref(false)

  const title = ref(props.task.title)
  const description = ref(props.task.description)
  const priority = ref(props.task.priority)

  const titleField = ref(null)
  const descriptionField = ref(null)
  const priorityField = ref(null)

  const showEditing = async (field) => {
    if (field === 'title') {
      isEditingTitle.value = true
    } else if (field === 'description') {
      isEditingDescription.value = true
    } else if (field === 'priority') {
      isEditingPriority.value = true
    }

    await nextTick()

    if (field === 'title') {
      titleField.value.focus()
    } else if (field === 'description') {
      descriptionField.value.focus()
    } else if (field === 'priority') {
      priorityField.value.focus()
    }
  }

  const onSave = () => {
    router.put(route('tasks.update', props.task.id), {
      title: title.value,
      description: description.value,
      priority: priority.value
    }, {
      onError: (err) => {
        title.value = props.task.title
      }
    })

    isEditingTitle.value = false
    isEditingDescription.value = false
    isEditingPriority.value = false
  }

  const onCancel = () => {
    title.value = props.task.title
    description.value = props.task.description
    priority.value = props.task.priority

    isEditingTitle.value = false
    isEditingDescription.value = false
    isEditingPriority.value = false
  }

  return {
    isEditingTitle,
    isEditingDescription,
    isEditingPriority,
    showEditing,
    title,
    description,
    priority,
    titleField,
    descriptionField,
    priorityField,
    save: onSave,
    cancel: onCancel,
  }
}

function useDelete() {
  const deleteTask = () => {
    router.delete(route('tasks.destroy', props.task.id), {preserveScroll: true})
  }

  const deleteTaskItem = (itemId) => {
    router.delete(route('items.destroy', itemId), {preserveScroll: true})
  }

  return {
    deleteTask,
    deleteTaskItem
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
            type="checkbox"
            :checked="task.completed"
            class="w-4 h-4 text-blue-600 bg-gray-100 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700">

          <label
            @click="showEditing('title')" v-if="!isEditingTitle"
            class="select-none ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
            {{ title }}
          </label>

          <input
            ref="titleField"
            @keydown.enter="save"
            @keydown.esc="cancel"
            v-if="isEditingTitle"
            v-model="title"
            class="w-full bg-transparent border-none focus:ring-0 p-0 m-0 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">

          <TrashIcon class="ml-1 size-4 text-red-500 hover:bg-red-500/50 rounded cursor-pointer" @click="deleteTask"/>
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
                  <button @click="isNewTaskItemModalOpen = false" class="rounded dark:text-white text-sm">Cancel
                  </button>
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

      <p class="flex items-center gap-1 text-white text-xs mt-1">
        Priority:
        <span @click="showEditing('priority')" v-if="!isEditingPriority" :class="priorityClass">{{ priority }}</span>

        <select v-model="priority"
                class="w-full bg-transparent border-none focus:ring-0 m-0 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block py-0.5 px-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                ref="priorityField"
                @keydown.enter="save"
                @keydown.esc="cancel"
                v-if="isEditingPriority"
        >
          <option selected disabled>Task Priority</option>
          <option v-for="priority in priorities" :key="priority.name" :value="priority.name">
            {{ priority.name }}
          </option>
        </select>
      </p>

      <p @click="showEditing('description')" v-if="!isEditingDescription"
         class="text-white text-xs mt-1">{{ description }}</p>

      <textarea
        ref="descriptionField"
        @keydown.enter="save"
        @keydown.esc="cancel"
        v-if="isEditingDescription"
        v-model="description"
        class="w-full bg-transparent border-none focus:ring-0 p-0 m-0 text-white text-xs mt-1"/>

      <div v-if="task.items.length" class="border border-gray-100 dark:border-gray-700 my-2"></div>

      <AppKanbanItem v-for="item in task.items" :item="item" />
    </div>
  </div>
</template>