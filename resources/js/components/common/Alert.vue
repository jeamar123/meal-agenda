<template>
  <Modal
    :show-header="false"
    body-class="pt-5 !pb-5"
    wrapper-class="!max-w-[420px]"
    show
    @close="emit('close')"
  >
    <div class="text-center">
      <ExclamationCircleIcon class="w-28 mx-auto" />
      <h2 class="font-semibold text-2xl">{{ title || 'Confirm' }}</h2>
      <!-- eslint-disable vue/no-v-html -->
      <p class="" v-html="message || 'Are you sure?'"></p>
    </div>

    <div class="flex items-center justify-center gap-x-3 mt-4">
      <Button variant="outline" @click="emit('close')">
        {{ closeButtonText }}
      </Button>
      <Button @click="emit('confirm')">{{ confirmButtonText }}</Button>
    </div>
  </Modal>
</template>

<script setup>
import { Modal, Button } from '@/Components/common'
import { ExclamationCircleIcon } from '@heroicons/vue/24/outline'

defineProps({
  show: {
    type: Boolean,
    default: () => false,
  },
  title: {
    type: String,
    default: '',
  },
  message: {
    type: String,
    default: '',
  },

  closeButtonText: {
    type: String,
    default: 'Cancel',
  },
  confirmButtonText: {
    type: String,
    default: 'Confirm',
  },
})

const emit = defineEmits(['close', 'confirm'])
</script>
