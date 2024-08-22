<script setup>
import AppModal from "@/Components/AppModal.vue";
import {useForm} from "@inertiajs/vue3";

const emit = defineEmits(['submit', 'close'])

const props = defineProps({
  open: Boolean,
  taskId: Number
})

const form = useForm({
  title: null,
})

const submit = () => {
  form.post(route('task.items.store', props.taskId), {
    onSuccess: () => {
      emit('close')
      form.reset()
    }
  })
}
</script>

<template>
  <AppModal :is-open="open" @close="emit('close')" @keydown.enter.prevent="submit">
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
        <button @click.prevent="emit('close')" class="rounded dark:text-white text-sm">Cancel
        </button>
        <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:cursor-not-allowed"
                :disabled="form.processing"
        >
          Create
        </button>
      </div>
    </form>
  </AppModal>
</template>