<script setup>
import {nextTick, ref, watch} from "vue";

const model = defineModel()
const emit = defineEmits(['save', 'cancel', 'editing'])
const props = defineProps({
  editing: Boolean
})

const original = model.value

const field = ref(null)

watch(props, async (value) => {
  if (value.editing) {
    await nextTick()
    field.value.focus()
  }
})

const onSave = () => {
  emit('save')
  emit('cancel')
}

const onCancel = () => {
  emit('cancel')
  model.value = original
}
</script>

<template>
  <div @click="emit('editing')">
    <slot v-if="!editing"/>

    <input
      ref="field"
      @keydown.enter="onSave"
      @keydown.esc="onCancel"
      v-if="editing"
      v-model="model"
      class="w-full bg-transparent border-none focus:ring-0 leading-tight p-0 m-0"
      :class="$attrs.class"
    >
  </div>
</template>
