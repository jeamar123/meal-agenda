<template>
  <TransitionRoot appear :show="show" as="template">
    <Dialog as="div" class="relative z-50" @close="emit('close')">
      <!-- Backdrop -->
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/50" />
      </TransitionChild>

      <!-- Modal Container -->
      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-lg bg-surface p-6 shadow-xl transition-all">
              <DialogTitle class="text-lg font-medium text-text-primary mb-4">
                Delete Meal
              </DialogTitle>

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
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'

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
