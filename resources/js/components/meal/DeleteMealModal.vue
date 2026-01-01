<template>
  <Modal
    :show="show"
    variant="center"
    animation="scale"
    title="Delete Meal"
    :show-footer="false"
    @close="emit('close')"
  >
    <p class="text-sm text-text-secondary mb-6">
      Are you sure you want to delete
      <span class="font-semibold text-text-primary">{{ meal?.name }}</span>?
      This action cannot be undone.
    </p>

    <div class="flex gap-3 justify-end">
      <button
        @click="emit('close')"
        class="px-4 py-2 text-sm font-medium text-text-primary bg-secondary hover:bg-secondary-hover rounded-md transition"
      >
        Cancel
      </button>
      <button
        @click="emit('confirm')"
        class="px-4 py-2 text-sm font-medium text-white bg-error hover:opacity-90 rounded-md transition"
      >
        Delete
      </button>
    </div>
  </Modal>
</template>

<script setup>
import { Modal } from '@/Components/common'

defineProps({
  show: {
    type: Boolean,
    required: true,
  },
  meal: {
    type: Object,
    default: null,
  },
})

const emit = defineEmits(['close', 'confirm'])
</script>
