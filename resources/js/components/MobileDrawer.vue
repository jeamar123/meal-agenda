<template>
  <Modal
    :show="show"
    variant="drawer"
    animation="slide"
    :drawer-position="direction"
    :panel-class="width"
    :show-header="false"
    :show-footer="false"
    @close="emit('close')"
  >
    <template #header>
      <slot name="header" />
    </template>

    <slot />
  </Modal>
</template>

<script setup>
import { Modal } from '@/Components/common'

defineProps({
  show: {
    type: Boolean,
    required: true,
  },
  direction: {
    type: String,
    default: 'left',
    validator: (value) => ['left', 'right'].includes(value),
  },
  width: {
    type: String,
    default: 'w-[280px]',
  },
})

const emit = defineEmits(['close'])
</script>
