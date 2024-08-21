<script setup>
import AppModal from "@/Components/AppModal.vue";
import {useForm} from "@inertiajs/vue3";

const emit = defineEmits(['submit', 'close'])

const props = defineProps({
  open: Boolean,
  sectionId: Number
})

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
  form.post(route('section.tasks.store', props.sectionId), {
    onSuccess: () => {
      emit('close')
      form.reset()
    }
  })
}
</script>

<template>
  <AppModal :is-open="open" @close="emit('close')">
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
        <label for="priority" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Priority</label>
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
        <button @click.prevent="emit('close')" class="rounded dark:text-white text-sm">Cancel</button>
        <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Create
        </button>
      </div>
    </form>
  </AppModal>
</template>