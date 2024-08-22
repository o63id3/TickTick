<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TasksCollection from "@/Pages/Tasks/Partials/TasksCollection.vue";

defineProps({
  tasks: Object
});

</script>

<template>
  <AppLayout title="Dashboard">
    <div class="max-w-5xl mx-auto px-4 dark:text-white space-y-10 my-10">
      <TasksCollection v-for="(tasks, key) in tasks" :name="key" :tasks="tasks" />
    </div>
  </AppLayout>
</template>
