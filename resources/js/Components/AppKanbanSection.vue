<script setup>
import AppKanbanTask from "@/Components/AppKanbanTask.vue";
import AppModal from "@/Components/AppModal.vue";
import {nextTick, ref} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import {TrashIcon} from "@heroicons/vue/24/outline/index.js";

const props = defineProps({
  section: Object
})

const {isNewTaskModalOpen, priorities, form, submit} = useNewTask()
const {isEditing, showEditing, name, nameField, save, cancel} = useEdit()

const { deleteSection } = useDelete()

function useNewTask() {
  const isNewTaskModalOpen = ref(false)

  const priorities = [
    {name: 'None'},
    {name: 'Low'},
    {name: 'Medium'},
    {name: 'High'}
  ]

  const form = useForm({
    title: null,
    description: null,
    priority: null
  })

  const submit = () => {
    form.post(route('section.tasks.store', props.section.id), {
      onSuccess: () => {
        isNewTaskModalOpen.value = false
        form.reset()
      }
    })
  }

  return {
    isNewTaskModalOpen,
    priorities,
    form,
    submit
  }
}

function useEdit() {
  const isEditing = ref(false)
  const name = ref(props.section.name)
  const nameField = ref(null)

  const showEditing = async () => {
    isEditing.value = true

    await nextTick()
    nameField.value.focus()
  }

  const onSave = () => {
    router.put(route('sections.update', props.section.id), {name: name.value}, {
      onError: (err) => {
        name.value = props.section.name
      }
    })
    isEditing.value = false
  }

  const onCancel = () => {
    name.value = props.section.name
    isEditing.value = false
  }

  return {
    isEditing,
    showEditing,
    name,
    nameField,
    save: onSave,
    cancel: onCancel,
  }
}

function useDelete() {
  const deleteSection = () => {
    router.delete(route('sections.destroy', props.section.id), {preserveScroll: true})
  }

  return {
    deleteSection
  }
}
</script>

<template>
  <div class="bg-white dark:bg-gray-800 dark:border-gray-700 rounded px-2 py-2">
    <!-- board category header -->
    <div class="flex justify-between items-center mb-2 mx-1">
      <div class="flex items-center justify-between">
        <h2 @click="showEditing" v-if="!isEditing" class="bg-indigo-300 text-sm w-max px-1 rounded mr-2 text-black">{{ name }}</h2>
        <input
          ref="nameField"
          @keydown.enter="save"
          @keydown.esc="cancel"
          v-if="isEditing"
          v-model="name"
          class="w-full bg-transparent border-none focus:ring-0 p-0 m-0 font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">

        <p class="text-gray-400 dark:text-gray-500 text-sm">({{ section.uncompletedTasksCount }})</p>
        <TrashIcon class="ml-1 size-4 text-red-500 hover:bg-red-500/50 rounded cursor-pointer" @click="deleteSection" />
      </div>

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

          <form @submit.prevent="submit" class="flex flex-col gap-4">
            <div>
              <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
              <input v-model="form.title" type="text" id="title"
                     class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                     placeholder="Task title"/>

              <p v-if="form.errors.title" class="text-xs text-red-500 mt-1">{{ form.errors.title }}</p>
            </div>

            <div>
              <label for="description"
                     class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
              <textarea v-model="form.description" type="text" id="description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Task description"/>

              <p v-if="form.errors.description" class="text-xs text-red-500 mt-1">{{ form.errors.description }}</p>
            </div>

            <div>
              <label for="priority" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                option</label>
              <select v-model="form.priority"
                      id="priority"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected disabled>Task Priority</option>
                <option v-for="priority in priorities" :key="priority.name" :value="priority.name">
                  {{ priority.name }}
                </option>
              </select>

              <p v-if="form.errors.priority" class="text-xs text-red-500 mt-1">{{ form.errors.priority }}</p>
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

    <div class="grid gap-2">
      <AppKanbanTask
        v-for="task in section.tasks"
        :task="task"
        :key="task.id"
        class="p-2 rounded shadow-sm border-2"
        :class="[
          task.completedAt ? 'border-indigo-100 dark:border-indigo-700' : 'border-gray-100 dark:border-gray-700'
        ]"
      />
    </div>
  </div>
</template>