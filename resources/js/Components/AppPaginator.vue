<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
  meta: Object
})
</script>

<template>
  <div class="px-4 py-3 sm:px-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-1 justify-between sm:hidden">
      <component
        :is="meta.links[0].url && !meta.links[0].active ? Link: 'span'"
        :href="meta.links[0].url"
        aria-current="page"
        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold rounded"
        :class="[
              meta.links[0].active? 'z-10 bg-indigo-600 text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 dark:bg-black/20 dark:text-white dark:hover:bg-black/30 dark:border-gray-600 dark:ring-gray-600',
            ]"
      >
        {{ meta.links[0].label }}
      </component>

      <component
        :is="meta.links[meta.links.length - 1].url && !meta.links[meta.links.length - 1].active ? Link: 'span'"
        :href="meta.links[meta.links.length - 1].url"
        aria-current="page"
        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold rounded"
        :class="[
              meta.links[meta.links.length - 1].active? 'z-10 bg-indigo-600 text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 dark:bg-black/20 dark:text-white dark:hover:bg-black/30 dark:border-gray-600 dark:ring-gray-600',
            ]"
      >
        {{ meta.links[meta.links.length - 1].label }}
      </component>
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
          <component
            :is="link.url && !link.active ? Link: 'span'"
            v-for="link in meta.links"
            :key="link.label"
            :href="link.url"
            aria-current="page"
            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold first:rounded-l last:rounded-r"
            :class="[
              link.active? 'z-10 bg-indigo-600 text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 dark:bg-black/20 dark:text-white dark:hover:bg-black/30 dark:border-gray-600 dark:ring-gray-600',
            ]"
          >
            {{ link.label }}
          </component>
        </nav>
      </div>
    </div>
  </div>
</template>