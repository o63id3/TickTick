<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {router, useForm} from "@inertiajs/vue3";
import AppKanban from "@/Components/AppKanban.vue";
import AppModal from "@/Components/AppModal.vue";
import {ref} from "vue";

const props = defineProps({
  list: Object,
  sections: Array,
});

const { isNewSectionModalOpen, form, submit } = useNewSection()

function useNewSection() {
  const isNewSectionModalOpen = ref(false)

  const form = useForm({
    name: null,
  })

  const submit = () => {
    form.post(route('list.sections.store', props.list.id), {
      onSuccess: () => {
        isNewSectionModalOpen.value = false
        form.reset()
      }
    })
  }

  return {
    isNewSectionModalOpen,
    form,
    submit
  }
}
</script>

<template>
  <AppLayout :title="list.name">
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ list.name }}
        </h2>

        <div>
          <div>
            <button
              type="button"
              @click="isNewSectionModalOpen = true"
              class="rounded-md bg-black/20 px-3 py-0.5 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
            >
              New Section
            </button>

            <AppModal :is-open="isNewSectionModalOpen" @close="isNewSectionModalOpen = false">
              <template #title>Create New Section</template>

              <form @submit.prevent="submit">
                <div>
                  <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                  <input v-model="form.name" type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Section name" />

                  <p v-if="form.errors.name" class="text-xs text-red-500 mt-1">{{ form.errors.name }}</p>
                </div>

                <div class="flex items-center justify-end gap-2 mt-4">
                  <button @click="isNewSectionModalOpen = false" class="rounded dark:text-white text-sm">Cancel</button>
                  <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
                </div>
              </form>
            </AppModal>
          </div>
        </div>
      </div>
    </template>

    <AppKanban :items="sections" />
  </AppLayout>
</template>