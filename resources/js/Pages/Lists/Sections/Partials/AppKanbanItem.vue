<script setup>
import {TrashIcon} from "@heroicons/vue/24/outline/index.js";
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import EditableField from "@/Components/EditableField.vue";

const props = defineProps({
  item: Object
})

const {toggleTaskItem} = useToggleComplete()
const {editing, title, save} = useEdit()
const {deleteTaskItem} = useDelete()

function useToggleComplete() {
  const toggleTaskItem = () => {
    router.put(route('items.toggle.completed', props.item.id), undefined, {preserveScroll: true})
  }

  return {
    toggleTaskItem
  }
}

function useEdit() {
  const editing = ref(false)
  const title = ref(props.item.title)

  const onSave = () => {
    router.put(route('items.update', props.item.id), {
      title: title.value,
    }, {
      onError: (err) => {
        title.value = props.item.title
      }
    })
  }

  return {
    editing,
    title,
    save: onSave,
  }
}

function useDelete() {
  const deleteTaskItem = () => {
    router.delete(route('items.destroy', props.item.id), {preserveScroll: true})
  }

  return {
    deleteTaskItem
  }
}
</script>

<template>
  <div class="flex items-center justify-between">
    <div class="flex items-center">
      <input
        @change="toggleTaskItem"
        :checked="item.completedAt"
        type="checkbox"
        class="w-3 h-3 text-blue-600 bg-gray-100 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700">

      <EditableField
        v-model="title"
        :editing="editing"
        @save="save"
        @editing="editing = true"
        @cancel="editing = false"
        class="text-xs ms-1 font-medium text-gray-900 dark:text-gray-300"
      >
        <label
          class="select-none text-xs font-medium"
          :class="[
            item.completedAt ? 'line-through decoration-indigo-900 dark:decoration-indigo-300 text-gray-900/50 dark:text-gray-300/50': 'text-gray-900 dark:text-gray-300'
          ]"
        >
          {{ title }}
        </label>
      </EditableField>
    </div>

    <TrashIcon
      class="size-4 text-red-500 hover:bg-red-500/50 rounded cursor-pointer"
      @click="deleteTaskItem"
    />
  </div>
</template>
