<script setup>
import {ref} from "vue";
import {cva} from "class-variance-authority";

const model = defineModel()
const emit = defineEmits(['save', 'cancel', 'editing'])
const props = defineProps({
  editing: Boolean,
  options: Array
})

const original = model.value

const field = ref(null)

const onSave = () => {
  emit('save')
  emit('cancel')
}

const priorityClass = cva("text-xs rounded px-1 py-0.5 cursor-default", {
  variants: {
    priority: {
      None: "text-white bg-white/50",
      Low: "text-blue-400 bg-blue-900/50",
      Medium: "text-yellow-400 bg-yellow-900/50",
      High: "text-red-400 bg-red-900/50",
    },
    selected: {
      true: "border border-white/50",
      false: "border-none",
    }
  },
})
</script>

<template>
  <div @click="emit('editing')">
    <slot v-if="!editing"/>

    <div
      class="space-x-1"
      v-if="editing"
    >
      <span
        v-for="option in options"
        :key="option.name"
        :class="priorityClass({ priority: option.name, selected: option.name === model })"
        @click.stop="() => {  model = option.name; onSave(); }"
      >{{ option.name }}</span>
    </div>
  </div>
</template>
