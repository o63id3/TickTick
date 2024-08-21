<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {router} from "@inertiajs/vue3";
import AppKanban from "@/Pages/Lists/Sections/Partials/AppKanban.vue";
import {ref} from "vue";
import {PencilSquareIcon} from "@heroicons/vue/24/outline/index.js";
import NewSectionModal from "@/Pages/Lists/Sections/Partials/NewSectionModal.vue";
import EditableField from "@/Components/EditableField.vue";

const props = defineProps({
  list: Object,
  sections: Array,
});

const isNewSectionModalOpen = ref(false)
const {editing, name, save} = useEdit()

function useEdit() {
  const editing = ref(false)
  const name = ref(props.list.name)

  const onSave = () => {
    router.put(route('lists.update', props.list.id), {name: name.value}, {
      onError: (err) => {
        name.value = props.list.name
      }
    })
  }

  return {
    editing,
    name,
    save: onSave,
  }
}
</script>

<template>
  <AppLayout :title="list.name">
    <template #header>
      <div class="flex justify-between items-center w-full">

        <div class="flex gap-2 items-center w-full">
          <EditableField
            v-model="name"
            :editing="editing"
            @save="save"
            @editing="editing = true"
            @cancel="editing = false"
            class="font-semibold text-xl text-gray-800 dark:text-gray-200"
          >
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
              {{ name }}
            </h2>
          </EditableField>

          <div class="cursor-pointer">
            <PencilSquareIcon
              v-if="!editing"
              @click="editing = true"
              class="size-5 text-blue-300 hover:text-blue-300/50"
            />
          </div>
        </div>

        <div class="shrink-0">
          <div>
            <button
              type="button"
              @click="isNewSectionModalOpen = true"
              class="rounded-md bg-black/20 px-3 py-0.5 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
            >
              New Section
            </button>

            <NewSectionModal
              :list-id="list.id"
              :open="isNewSectionModalOpen"
              @close="isNewSectionModalOpen = false"
            />
          </div>
        </div>
      </div>
    </template>

    <AppKanban :sections="sections"/>
  </AppLayout>
</template>