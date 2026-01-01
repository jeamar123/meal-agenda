<template>
  <TransitionRoot appear :show="show">
    <Dialog as="div" :class="['relative z-50', dialogClasses]" @close="emit('close')">
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
      <div class="modal-container" :class="containerClasses">
        <div :class="containerInnerClasses">
          <TransitionChild
            class="w-full lg:w-auto"
            :enter="currentAnimation.enter"
            :enter-from="currentAnimation.enterFrom"
            :enter-to="currentAnimation.enterTo"
            :leave="currentAnimation.leave"
            :leave-from="currentAnimation.leaveFrom"
            :leave-to="currentAnimation.leaveTo"
          >
            <!-- Drawer Variant -->
            <DialogPanel v-if="variant === 'drawer'" :class="panelClasses">
              <div class="flex h-full flex-col">
                <!-- Drawer Header Slot -->
                <div v-if="$slots.header" class="border-b border-border">
                  <slot name="header" />
                </div>

                <!-- Drawer Content -->
                <div class="flex-1 overflow-y-auto">
                  <slot />
                </div>
              </div>
            </DialogPanel>

            <!-- Standard Modal (Center & Bottom-sheet) -->
            <DialogPanel v-else :class="panelClasses">
              <!-- Header -->
              <slot v-if="showHeader" name="header">
                <DialogTitle v-if="title" class="text-lg font-medium text-text-primary mb-4">
                  {{ title }}
                </DialogTitle>
                <div
                  v-else
                  class="flex justify-between items-center mb-4"
                  :class="headerClass"
                >
                  <h2 class="font-medium text-lg">
                    {{ title || '' }}
                  </h2>
                  <button class="outline-none" @click="emit('close')">
                    <XMarkIcon class="w-4" />
                  </button>
                </div>
              </slot>

              <!-- Body -->
              <div :class="bodyClass">
                <slot />
              </div>

              <!-- Footer -->
              <slot v-if="showFooter" name="footer">
                <div
                  class="flex items-center gap-3 pt-2"
                  :class="{
                    'justify-end': footerButtonsAlignment === 'right',
                    'justify-center': footerButtonsAlignment === 'center',
                    'justify-start': footerButtonsAlignment === 'left',
                  }"
                >
                  <Button
                    v-if="showCloseButton"
                    variant="blank"
                    @click="emit('close')"
                  >
                    {{ closeButtonText }}
                  </Button>
                  <Button @click="emit('confirm')">
                    {{ confirmButtonText }}
                  </Button>
                </div>
              </slot>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { computed } from 'vue'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import { Button } from '@/Components/common'
import { XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  // Existing props
  show: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    default: '',
  },
  bodyClass: {
    type: String,
    default: '',
  },
  wrapperClass: {
    type: String,
    default: '',
  },
  verticalPosition: {
    type: String,
    default: 'center', // top, center
  },
  showHeader: {
    type: Boolean,
    default: true,
  },
  headerClass: {
    type: String,
    default: '',
  },
  showFooter: {
    type: Boolean,
    default: false,
  },
  showCloseButton: {
    type: Boolean,
    default: true,
  },
  footerButtonsAlignment: {
    type: String,
    default: 'right', // left, center, right
  },
  closeButtonText: {
    type: String,
    default: 'Cancel',
  },
  confirmButtonText: {
    type: String,
    default: 'Confirm',
  },

  // New props for variant support
  variant: {
    type: String,
    default: 'center',
    validator: (value) => ['center', 'bottom-sheet', 'drawer'].includes(value),
  },
  animation: {
    type: String,
    default: 'fade',
    validator: (value) => ['fade', 'scale', 'slide'].includes(value),
  },
  drawerPosition: {
    type: String,
    default: 'left',
    validator: (value) => ['left', 'right'].includes(value),
  },
  panelClass: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['close', 'confirm'])

// Animation configurations
const getSlideAnimation = () => {
  if (props.variant === 'bottom-sheet') {
    return {
      enterFrom: 'translate-y-full',
      enterTo: 'translate-y-0',
      leaveFrom: 'translate-y-0',
      leaveTo: 'translate-y-full',
    }
  }
  if (props.variant === 'drawer') {
    const direction = props.drawerPosition === 'right'
    return {
      enterFrom: direction ? 'translate-x-full' : '-translate-x-full',
      enterTo: 'translate-x-0',
      leaveFrom: 'translate-x-0',
      leaveTo: direction ? 'translate-x-full' : '-translate-x-full',
    }
  }
  return {
    enterFrom: 'opacity-0',
    enterTo: 'opacity-100',
    leaveFrom: 'opacity-100',
    leaveTo: 'opacity-0',
  }
}

const animations = {
  fade: {
    enter: 'duration-300 ease-out',
    enterFrom: 'opacity-0',
    enterTo: 'opacity-100',
    leave: 'duration-200 ease-in',
    leaveFrom: 'opacity-100',
    leaveTo: 'opacity-0',
  },
  scale: {
    enter: 'duration-300 ease-out',
    enterFrom: 'opacity-0 scale-95',
    enterTo: 'opacity-100 scale-100',
    leave: 'duration-200 ease-in',
    leaveFrom: 'opacity-100 scale-100',
    leaveTo: 'opacity-0 scale-95',
  },
}

const currentAnimation = computed(() => {
  if (props.animation === 'slide') {
    return {
      enter: 'duration-300 ease-out',
      leave: 'duration-200 ease-in',
      ...getSlideAnimation(),
    }
  }
  return animations[props.animation]
})

// Computed classes
const dialogClasses = computed(() => {
  return ''
})

const containerClasses = computed(() => {
  const base = 'fixed inset-0'

  switch (props.variant) {
    case 'center':
      return `${base} overflow-y-auto`
    case 'bottom-sheet':
      return `${base} overflow-y-auto pointer-events-none`
    case 'drawer':
      return `${base} overflow-hidden`
    default:
      return base
  }
})

const containerInnerClasses = computed(() => {
  const baseAlignment = 'flex min-h-full'

  switch (props.variant) {
    case 'center':
      const alignment = props.verticalPosition === 'top' ? 'start' : 'center'
      return `${baseAlignment} justify-center items-${alignment} p-4`
    case 'bottom-sheet':
      return `${baseAlignment} items-end justify-center`
    case 'drawer':
      const position = props.drawerPosition === 'right' ? 'right-0 pl-10' : 'left-0 pr-10'
      return `pointer-events-none fixed inset-y-0 flex max-w-full ${position}`
    default:
      return baseAlignment
  }
})

const panelClasses = computed(() => {
  const baseClasses = 'transform transition-all'
  let variantClasses = ''

  switch (props.variant) {
    case 'center':
      variantClasses = 'w-full overflow-hidden rounded-lg bg-surface p-6 shadow-xl'
      break
    case 'bottom-sheet':
      variantClasses = 'w-full pointer-events-auto bg-surface rounded-t-2xl shadow-xl p-6'
      break
    case 'drawer':
      variantClasses = `pointer-events-auto relative ${props.panelClass || 'w-[280px]'} bg-surface shadow-xl h-full`
      break
  }

  // Apply custom panelClass if provided and not a drawer (drawer uses it for width)
  const customClass = props.variant !== 'drawer' && props.panelClass ? props.panelClass : ''

  return `${baseClasses} ${variantClasses} ${customClass} ${props.wrapperClass}`.trim()
})
</script>
