<script setup>
import {router} from "@inertiajs/vue3";
import {TrashIcon} from "@heroicons/vue/24/outline/index.js";

const emit = defineEmits(['delete'])

defineProps({
  list: Object
})
</script>

<template>
  <div
    @click="router.get(route('list.sections.index', list.id))"
    class="cursor-pointer block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
    <div class="flex items-center justify-between">
      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
        {{ list.name }}
        <span>({{ list.uncompletedTasksCount }})</span>
      </h5>

      <TrashIcon
        class="size-5 text-red-500 hover:bg-red-500/50 rounded cursor-pointer"
        @click.stop="emit('delete')"
      />
    </div>

    <div class="dark:text-white text-sm">{{ list.description }}</div>
  </div>
</template>