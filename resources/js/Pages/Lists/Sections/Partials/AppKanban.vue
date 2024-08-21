<script setup>
import AppKanbanSection from "@/Pages/Lists/Sections/Partials/AppKanbanSection.vue";

defineProps({
  sections: Array
})
</script>

<template>
  <div class="p-2">
    <div class="flex gap-5">
      <AppKanbanSection v-for="section in sections" :key="section.id" :section="section"/>
    </div>
  </div>
</template>