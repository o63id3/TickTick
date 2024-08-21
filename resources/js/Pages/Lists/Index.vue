<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {router} from '@inertiajs/vue3'
import {ref} from "vue";
import AppPaginator from "@/Components/AppPaginator.vue";
import NewListModal from "@/Pages/Lists/Partials/NewListModal.vue";
import ListItem from "@/Pages/Lists/Partials/ListItem.vue";

defineProps({
  lists: Object,
});

const isNewListModalOpen = ref(false)

const deleteList = listId =>
  router.delete(route('lists.destroy', listId), {preserveScroll: true})
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

          <NewListModal
            :open="isNewListModalOpen"
            @close="isNewListModalOpen = false"
          />
        </div>
      </div>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="grid gap-4 grid-cols-1 md:grid-cols-3">
          <ListItem
            v-for="list in lists.data"
            :key="list.id"
            :list="list"
            @delete="deleteList(list.id)"
          />
        </div>

        <AppPaginator class="mt-4 rounded-lg" :meta="lists.meta"/>
      </div>
    </div>
  </AppLayout>
</template>
