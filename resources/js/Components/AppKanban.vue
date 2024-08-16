<script setup>
import AppKanbanItem from "@/Components/AppKanbanSection.vue";

defineProps({
  items: Array
})
</script>

<template>
  <div class="p-2">
    <div class="grid lg:grid-cols-6 md:grid-cols-4 sm:grid-cols-2 gap-5">
      <AppKanbanItem v-for="item in items" :key="item.id" :item="item" />
    </div>
  </div>
</template>