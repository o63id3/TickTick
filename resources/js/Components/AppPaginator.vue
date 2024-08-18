<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
  meta: Object
})
</script>

<template>
  <div class="flex items-center justify-between border-t border-gray-200 bg-white dark:border-gray-900 dark:bg-gray-800 px-4 py-3 sm:px-6">
    <div class="flex flex-1 justify-between sm:hidden">
      <Link :href="meta.links[0].url ?? '#'"
         class="relative inline-flex items-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-black/20 dark:text-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:hover:bg-black/30">Previous</Link>
      <Link :href="meta.links[meta.links.length - 1].url ?? '#'"
         class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-black/20 dark:text-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:hover:bg-black/30">Next</Link>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700 dark:text-white">
          Showing
          {{ ' ' }}
          <span class="font-medium">{{ meta.from }}</span>
          {{ ' ' }}
          to
          {{ ' ' }}
          <span class="font-medium">{{ meta.to }}</span>
          {{ ' ' }}
          of
          {{ ' ' }}
          <span class="font-medium">{{ meta.total }}</span>
          {{ ' ' }}
          results
        </p>
      </div>
      <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
          <Link
            v-for="link in meta.links"
            :key="link.label"
            :href="link.url ?? '#'"
            aria-current="page"
            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold first:rounded-l last:rounded-r"
            :class="[
              link.active? 'z-10 bg-indigo-600 text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 dark:bg-black/20 dark:text-white dark:hover:bg-black/30 dark:border-gray-600 dark:ring-gray-600',
              link.url? '': 'cursor-not-allowed disabled'
            ]"
          >{{ link.label }}
          </Link>
        </nav>
      </div>
    </div>
  </div>
</template>