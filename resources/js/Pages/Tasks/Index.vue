<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TasksCollection from "@/Pages/Tasks/Partials/TasksCollection.vue";

defineProps({
  tasks: Object
});

</script>

<template>
  <AppLayout title="Dashboard">
<!--    <template #header>-->
<!--      <div class="flex justify-between items-center">-->
<!--        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">-->
<!--          Tasks-->
<!--        </h2>-->
<!--      </div>-->
<!--    </template>-->

    <div class="max-w-5xl mx-auto px-4 dark:text-white space-y-10 my-10">
      <TasksCollection v-for="(tasks, key) in tasks" :name="key" :tasks="tasks" />
    </div>
  </AppLayout>
</template>
