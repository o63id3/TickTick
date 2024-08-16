<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import AppKanban from "@/Components/AppKanban.vue";
import AppModal from "@/Components/AppModal.vue";
import {ref} from "vue";

defineProps({
  list: Object,
  sections: Array,
});

const isNewSectionModalOpen = ref(false)
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
            </AppModal>
          </div>
        </div>
      </div>
    </template>

    <AppKanban :items="sections" />
  </AppLayout>
</template>