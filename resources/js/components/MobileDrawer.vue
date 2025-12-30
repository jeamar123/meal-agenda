<template>
  <TransitionRoot appear :show="show" as="template">
    <Dialog as="div" class="relative z-50" @close="emit('close')">
      <!-- Backdrop -->
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/50" />
      </TransitionChild>

      <!-- Drawer Container -->
      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div
            class="pointer-events-none fixed inset-y-0 flex max-w-full"
            :class="direction === 'right' ? 'right-0 pl-10' : 'left-0 pr-10'"
          >
            <TransitionChild
              as="template"
              enter="transform transition ease-out duration-300"
              :enter-from="direction === 'right' ? 'translate-x-full' : '-translate-x-full'"
              enter-to="translate-x-0"
              leave="transform transition ease-in duration-200"
              leave-from="translate-x-0"
              :leave-to="direction === 'right' ? 'translate-x-full' : '-translate-x-full'"
            >
              <DialogPanel
                class="pointer-events-auto relative"
                :class="width"
              >
                <div class="flex h-full flex-col bg-surface shadow-xl">
                  <!-- Header Slot -->
                  <div v-if="$slots.header" class="border-b border-border">
                    <slot name="header" />
                  </div>

                  <!-- Content Slot -->
                  <div class="flex-1 overflow-y-auto">
                    <slot />
                  </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
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
} from '@headlessui/vue'

const props = defineProps({
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
