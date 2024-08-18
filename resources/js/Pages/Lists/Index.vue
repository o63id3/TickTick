<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {router, useForm} from '@inertiajs/vue3'
import AppModal from "@/Components/AppModal.vue";
import {ref} from "vue";
import {TrashIcon} from "@heroicons/vue/24/outline/index.js";
import AppPaginator from "@/Components/AppPaginator.vue";


const props = defineProps({
  lists: Object,
});

const {isNewListModalOpen, form, submit} = useNewList()
const {deleteList} = useDelete()

function useNewList() {
  const isNewListModalOpen = ref(false)

  const form = useForm({
    name: null,
    description: null,
  })

  const submit = () => {
    form.post(route('lists.store'), {
      onSuccess: () => {
        isNewListModalOpen.value = false
        form.reset()
      }
    })
  }

  return {
    isNewListModalOpen,
    form,
    submit
  }
}

function useDelete() {
  const deleteList = (listId) => {
    router.delete(route('lists.destroy', listId), {preserveScroll: true})
  }

  return {
    deleteList
  }
}
</script>

<template>
  <AppLayout title="Lists">
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Lists
        </h2>

        <div>
          <button
            type="button"
            @click="isNewListModalOpen = true"
            class="rounded-md bg-black/20 px-3 py-0.5 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
          >
            New List
          </button>

          <AppModal :is-open="isNewListModalOpen" @close="isNewListModalOpen = false">
            <template #title>Create New List</template>

            <form @submit.prevent="submit" class="flex flex-col gap-4">
              <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input v-model="form.name" type="text" id="name"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="List name"/>

                <p v-if="form.errors.name" class="text-xs text-red-500 mt-1">{{ form.errors.name }}</p>
              </div>

              <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <textarea v-model="form.description" type="text" id="description"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                          placeholder="List description"/>

                <p v-if="form.errors.name" class="text-xs text-red-500 mt-1">{{ form.errors.name }}</p>
              </div>

              <div class="flex items-center justify-end gap-2">
                <button @click="isNewListModalOpen = false" class="rounded dark:text-white text-sm">Cancel</button>
                <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  Create
                </button>
              </div>
            </form>
          </AppModal>
        </div>
      </div>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="grid gap-4 grid-cols-1 md:grid-cols-3">
          <div
            v-for="list in lists.data"
            :key="list.id"
            @click="router.get(route('lists.show', list.id))"
            class="cursor-pointer block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <div class="flex items-center justify-between">
              <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ list.name }}
                <span>({{ list.uncompletedTasksCount }})</span>
              </h5>

              <TrashIcon class="size-5 text-red-500 hover:bg-red-500/50 rounded cursor-pointer"
                         @click.stop="deleteList(list.id)"/>
            </div>

            <div class="dark:text-white text-sm">{{ list.description }}</div>
          </div>
        </div>

        <AppPaginator class="mt-4 rounded-lg" :meta="lists.meta"/>
      </div>
    </div>
  </AppLayout>
</template>
