<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import AppModal from "@/Components/AppModal.vue";
import {ref} from "vue";

defineProps({
  lists: Object,
});

const isNewListModalOpen = ref(false)
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
          </AppModal>
        </div>
      </div>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="grid gap-4 grid-cols-1 md:grid-cols-3">
          <div v-for="list in lists" :key="list.id" class="">
            <Link
              :href="route('lists.show', list.id)"
              class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

              <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ list.name }}
                <span>({{ list.uncompletedTasksCount }})</span>
              </h5>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
