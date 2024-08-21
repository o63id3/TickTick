<script setup>
import AppKanbanTask from "@/Pages/Lists/Sections/Partials/AppKanbanTask.vue";
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import {PlusCircleIcon, TrashIcon} from "@heroicons/vue/24/outline/index.js";
import NewTaskModal from "@/Pages/Lists/Sections/Partials/NewTaskModal.vue";
import EditableField from "@/Components/EditableField.vue";

const props = defineProps({
  section: Object
})

const isNewTaskModalOpen = ref(false)
const {editing, name, save, cancel} = useEdit()

const {deleteSection} = useDelete()

function useEdit() {
  const editing = ref(false)
  const name = ref(props.section.name)

  const onSave = () => {
    router.put(route('sections.update', props.section.id), {name: name.value}, {
      onError: (err) => {
        name.value = props.section.name
      }
    })
  }

  return {
    editing,
    name,
    save: onSave,
  }
}

function useDelete() {
  const deleteSection = () => {
    router.delete(route('sections.destroy', props.section.id), {preserveScroll: true})
  }

  return {
    deleteSection
  }
}
</script>

<template>
  <div class="bg-white dark:bg-gray-800 dark:border-gray-700 rounded px-2 py-2 min-w-80 max-w-80">
    <!-- board category header -->
    <div class="flex justify-between items-center mb-2 mx-1">
      <div class="flex items-center justify-between">
        <EditableField
          v-model="name"
          :editing="editing"
          @save="save"
          @editing="editing = true"
          @cancel="editing = false"
          class="text-sm text-gray-800 dark:text-gray-200"
        >
          <h2 class="bg-indigo-300 text-sm w-max px-1 rounded mr-2 text-black">{{ name }}</h2>
        </EditableField>

        <p class="text-gray-400 dark:text-gray-500 text-sm">({{ section.uncompletedTasksCount }})</p>
      </div>

      <TrashIcon class="ml-1 size-4 text-red-500 hover:bg-red-500/50 rounded cursor-pointer" @click="deleteSection"/>
    </div>

    <div class="grid gap-2">
      <div
        @click="isNewTaskModalOpen = true"
        class="p-2 rounded shadow-sm border-2 grid place-items-center dark:text-white/70 dark:bg-gray-800 dark:border-gray-700 cursor-pointer">
        <PlusCircleIcon class="size-5"/>

        <NewTaskModal
          :section-id="section.id"
          :open="isNewTaskModalOpen"
          @close="isNewTaskModalOpen = false"
        />
      </div>

      <AppKanbanTask
        v-for="task in section.tasks"
        :task="task"
        :key="task.id"
        class="p-2 rounded shadow-sm border-2"
        :class="[
          task.completedAt ? 'border-indigo-100 dark:border-indigo-700' : 'border-gray-100 dark:border-gray-700'
        ]"
      />
    </div>
  </div>
</template>