<script setup>
import {computed} from "vue";
import {cva} from "class-variance-authority";
import moment from "moment";
import {router} from "@inertiajs/vue3";

const props = defineProps({
  task: Object
})

const priorityClass = computed(() => {
  return cva("text-xs rounded px-1 py-0.5 cursor-default", {
    variants: {
      priority: {
        None: "text-white bg-white/50",
        Low: "text-blue-400 bg-blue-900/50",
        Medium: "text-yellow-400 bg-yellow-900/50",
        High: "text-red-400 bg-red-900/50",
      },
    },
  })({
    priority: props.task.priority
  });
});
</script>

<template>
  <div
    class="p-5 bg-gray-800 rounded text-lg font-semibold border border-gray-200 shadow dark:bg-gray-800 dark:border-gray-700">
    <h2 class="text-sm">
      <span class="hover:underline hover:text-indigo-400 cursor-pointer" @click="router.get(route('list.sections.index', task.section.list.id))">{{ task.section.list.name }}</span> > {{ task.section.name }} > {{ task.title }}
    </h2>

    <span :class="priorityClass">{{ task.priority }}</span>

    <p class="text-sm mt-2">
      {{ task.description }}
    </p>

    <span class="text-xs">{{ moment(task.createdAt).from(new Date()) }}</span>
  </div>
</template>
