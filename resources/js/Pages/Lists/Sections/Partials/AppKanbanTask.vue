<script setup>
import {computed, ref} from "vue";
import {cva} from "class-variance-authority";
import {router, useForm} from "@inertiajs/vue3";
import {PlusCircleIcon, TrashIcon} from "@heroicons/vue/24/outline/index.js";
import AppKanbanItem from "@/Pages/Lists/Sections/Partials/AppKanbanItem.vue";
import NewTaskModal from "@/Pages/Lists/Sections/Partials/NewTaskItemModal.vue";
import EditableField from "@/Components/EditableField.vue";
import EditableTextArea from "@/Components/EditableTextArea.vue";
import EditableSelect from "@/Components/EditableSelect.vue";
import moment from "moment";

const props = defineProps({
  task: Object
})

const isNewTaskItemModalOpen = ref(false)
const {toggleTask} = useToggleComplete()
const {editing, form: editingForm, save} = useEdit()

const priorities = [
  // {name: 'Task Priority', selected: true, disabled: true},
  {name: 'None'},
  {name: 'Low'},
  {name: 'Medium'},
  {name: 'High'}
]

const {deleteTask} = useDelete()

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

function useToggleComplete() {
  const toggleTask = () => {
    router.put(route('tasks.toggle.completed', props.task.id), undefined, {preserveScroll: true})
  }

  const toggleTaskItem = (itemId) => {
    router.put(route('items.toggle.completed', itemId), undefined, {preserveScroll: true})
  }

  return {
    toggleTask,
    toggleTaskItem
  }
}

function useEdit() {
  const editing = ref({
    title: false,
    description: false,
    priority: false,
  })

  const form = useForm({
    title: props.task.title,
    description: props.task.description,
    priority: props.task.priority
  })

  const onSave = () => {
    form.put(route('tasks.update', props.task.id), {
      preserveScroll: true,
      onError: (err) => {
        form.title = props.task.title
        form.description = props.task.description
        form.priority = props.task.priority
      }
    })
  }

  return {
    editing,
    form,
    save: onSave,
  }
}

function useDelete() {
  const deleteTask = () => {
    router.delete(route('tasks.destroy', props.task.id), {preserveScroll: true})
  }

  const deleteTaskItem = (itemId) => {
    router.delete(route('items.destroy', itemId), {preserveScroll: true})
  }

  return {
    deleteTask,
    deleteTaskItem
  }
}
</script>

<template>
  <div>
    <div>
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
          <input
            @change="toggleTask"
            type="checkbox"
            :checked="task.completedAt"
            class="w-4 h-4 text-blue-600 bg-gray-100 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700">

          <EditableField
            v-model="editingForm.title"
            :editing="editing.title"
            @save="save"
            @editing="editing.title = true"
            @cancel="editing.title = false"
            class="ms-1 text-sm font-medium text-gray-900 dark:text-gray-300"
          >
            <label
              class="select-none text-sm font-medium text-gray-900 dark:text-gray-300">
              {{ editingForm.title }}
            </label>
          </EditableField>
        </div>

        <TrashIcon class="ml-1 size-4 text-red-500 hover:bg-red-500/50 rounded cursor-pointer" @click="deleteTask"/>
      </div>

      <p class="flex items-center gap-1 text-white text-xs mt-1">
        Priority:

        <EditableSelect
          v-model="editingForm.priority"
          :options="priorities"
          :editing="editing.priority"
          @save="save"
          @editing="editing.priority = true"
          @cancel="editing.priority = false"
        >
          <span :class="priorityClass">{{ editingForm.priority }}</span>
        </EditableSelect>
      </p>

      <EditableTextArea
        v-model="editingForm.description"
        :editing="editing.description"
        @save="save"
        @editing="editing.description = true"
        @cancel="editing.description = false"
        class="text-white text-xs mt-1 cursor-default"
      >
        <p class="text-white text-xs mt-1">{{ editingForm.description }}</p>
      </EditableTextArea>

      <div v-if="task.completedAt" class="text-xs pt-1 dark:text-gray-400">completed {{ moment(task.completedAt).fromNow() }}</div>

      <div v-if="task.items.length || !task.completedAt" class="border border-gray-100 dark:border-gray-700 my-2"></div>

      <div class="grid gap-2">
        <AppKanbanItem v-for="item in task.items" :key="item.id" :item="item"/>

        <div
          v-if="!task.completedAt"
          @click="isNewTaskItemModalOpen = true"
          class="p-2 rounded shadow-sm border-2 grid place-items-center dark:text-white/70 dark:bg-gray-800 dark:border-gray-700 cursor-pointer">
          <PlusCircleIcon class="size-5"/>

          <NewTaskModal
            :task-id="task.id"
            :open="isNewTaskItemModalOpen"
            @close="isNewTaskItemModalOpen = false"
          />
        </div>
      </div>
    </div>
  </div>
</template>