<template>
  <div class="tooltip-container relative flex w-auto justify-center">
    <div
      class="tooltip-popup absolute flex items-center justify-center z-10"
      :class="placement"
    >
      <div
        class="absolute bottom-[-4px] h-[8px] w-[8px] rotate-45 transform bg-slate-500"
      ></div>
      <div class="z-5 relative rounded bg-slate-500 py-[5px] px-2">
        <!-- eslint-disable vue/no-v-html -->
        <p
          class="text-[11px] font-medium text-zinc-200 text-center whitespace-break-spaces"
          :class="width"
          v-html="description || $t('common.some_information_about')"
        />
      </div>
    </div>

    <slot>
      <!-- <FontAwesomeIcon
        :icon="['fas', 'info-circle']"
        :class="['inline-block cursor-pointer']"
        :style="{
          color: iconColor,
          fontSize: iconSize,
        }"
      /> -->
      <Icon
        name="InformationCircleIcon"
        class="w-5 inline-block cursor-pointer"
      />
    </slot>
  </div>
</template>

<script setup>
import { Icon } from '@/Components/common'

defineProps({
  description: {
    type: [String, null],
    required: false,
    default: () => null,
  },
  iconColor: {
    type: String,
    default: '#c547d3',
  },
  iconSize: {
    type: String,
    default: '14px',
  },
  width: {
    type: String,
    default: 'w-[180px]',
  },
  placement: {
    type: String,
    default: 'bottom-[20px] left-[0] right-[0]',
  },
})
</script>

<style>
.tooltip-popup {
  visibility: hidden;
}

.tooltip-container:hover .tooltip-popup {
  visibility: visible;
}
</style>
