<template>
  <component
    :is="as"
    :type="type"
    :class="[
      getClasses(),
      isLoading && '!flex items-center justify-center gap-x-2',
      disabled && 'cursor-not-allowed !opacity-70',
    ]"
    :disabled="variant === 'disabled' || disabled"
  >
    <slot />

    <LoadingIcon v-if="isLoading" class="text-white fill-white w-5" />
  </component>
</template>

<script setup>
import { LoadingIcon } from '@/Components/common'
const props = defineProps({
  as: {
    type: [String, Object],
    default: 'button', // button, a, Link
  },
  variant: {
    type: String,
    default: 'primary', // primary, secondary, outline, disabled
  },
  type: {
    type: String,
    default: 'button', // button, submit
  },
  disabled: {
    type: Boolean,
    default: () => false,
  },
  isLoading: {
    type: Boolean,
    default: () => false,
  },
})

const getClasses = () => {
  let defaultClasses =
    'inline-block py-2 px-4 rounded-md border text-sm font-semibold hover:opacity-70 outline-none transition-all duration-200 hover-transition active:scale-95 shadow-lg'
  let classes = ''

  switch (props.variant) {
    case 'secondary':
      classes = 'bg-secondary border-secondary text-white'
      break
    case 'outline':
      classes = 'border border-primary text-primary'
      break
    case 'plain':
      classes = 'border border-gray-400 text-gray-500'
      break
    case 'danger':
      classes = 'border border-[#dc3545] text-[#dc3545]'
      break
    case 'blank':
      classes = 'border-none !p-2'
      break
    case 'primary':
    default:
      classes = 'bg-primary hover:bg-primary-hover text-white'
      break
  }

  return `${defaultClasses} ${classes}`
}
</script>
