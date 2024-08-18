<script setup>
import {TrashIcon} from "@heroicons/vue/24/outline/index.js";
import {nextTick, ref} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
  item: Object
})

const {toggleTaskItem} = useToggleComplete()
const {
  isEditing,
  showEditing,
  title,
  titleField,
  save,
  cancel,
} = useEdit()
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
  const isEditing = ref(false)
  const title = ref(props.item.title)
  const titleField = ref(null)

  const showEditing = async () => {
    isEditing.value = true

    await nextTick()

    titleField.value.focus()
  }

  const onSave = () => {
    router.put(route('items.update', props.item.id), {
      title: title.value,
    }, {
      onError: (err) => {
        title.value = props.item.title
      }
    })

    isEditing.value = false
  }

  const onCancel = () => {
    title.value = props.item.title

    isEditing.value = false
  }

  return {
    isEditing,
    showEditing,
    title,
    titleField,
    save: onSave,
    cancel: onCancel,
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
    <div class="flex">
      <input
        @change="toggleTaskItem()"
        :id="'task-item-' + item.id"
        :checked="item.completedAt"
        type="checkbox"
        class="w-3 h-3 text-blue-600 bg-gray-100 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700">
      <label
        @click="showEditing" v-if="!isEditing"
        class="select-none ms-2 text-xs font-medium"
        :class="[
            item.completedAt ? 'line-through decoration-indigo-900 dark:decoration-indigo-300 text-gray-900/50 dark:text-gray-300/50': 'text-gray-900 dark:text-gray-300'
          ]"
      >
        {{ item.title }}
      </label>

      <input
        ref="titleField"
        @keydown.enter="save"
        @keydown.esc="cancel"
        v-if="isEditing"
        v-model="title"
        class="w-full bg-transparent border-none focus:ring-0 p-0 m-0 ms-2 text-xs font-medium text-gray-900 dark:text-gray-300">

    </div>

    <div>
      <TrashIcon class="size-4 text-red-500 hover:bg-red-500/50 rounded cursor-pointer"
                 @click="deleteTaskItem"/>
    </div>
  </div>
</template>
