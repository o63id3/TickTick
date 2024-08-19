<script setup>
import AppKanbanSection from "@/Components/AppKanbanSection.vue";

defineProps({
  sections: Array
})
</script>

<template>
  <div class="p-2">
    <div class="grid lg:grid-cols-6 md:grid-cols-4 sm:grid-cols-2 gap-5">
      <AppKanbanSection v-for="section in sections" :key="section.id" :section="section" />
    </div>
  </div>
</template>