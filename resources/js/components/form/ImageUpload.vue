<template>
  <div>
    <div :class="wrapperClass">
      <label class="form-label" :class="labelClass" :for="id"
        >{{ label }}<span v-if="required">*</span></label
      >
      <div
        class="min-h-[150px] md:min-h-[200px] relative border-2 border-dashed bg-gray-50 rounded-md flex items-center justify-center"
        :class="inputClass"
      >
        <div v-if="fileValue || filePreview" class="relative w-full z-[5]">
          <img
            v-if="filePreview"
            :src="filePreview"
            alt=""
            class="w-full rounded-md relative"
          />

          <div
            class="absolute bottom-0 w-full flex items-center justify-between gap-x-1 bg-black bg-opacity-50 p-1"
          >
            <p class="text-white px-2">{{ fileValue?.name }}</p>
            <div class="flex justify-end gap-x-1">
              <button
                class="rounded-full hover:opacity-80 bg-primary text-white w-8 h-8 flex items-center justify-center"
                @click="clickFileInput"
              >
                <PencilSquareIcon class="w-4" />
              </button>
              <button
                class="rounded-full hover:opacity-80 bg-red-500 text-white w-8 h-8 flex items-center justify-center"
                @click="removeFile"
              >
                <TrashIcon class="w-4" />
              </button>
            </div>
          </div>
        </div>

        <div
          v-if="!fileValue && !filePreview"
          class="flex flex-col gap-y-2 items-center justify-center text-gray-500"
        >
          <ArrowDownTrayIcon class="w-6" />
          <p class="text-sm text-center">
            <b>Choose a file</b> or drag it here.
          </p>
        </div>

        <input
          id="fileInput"
          ref="fileInput"
          type="file"
          class="absolute inset-0 cursor-pointer opacity-0"
          style="font-size: 0px"
          :accept="allowedMimes"
          @change="getFileInputValue"
        />
      </div>
    </div>
    <template v-if="errors.length">
      <div class="mt-1">
        <p
          v-for="error in errors"
          :key="error"
          class="text-red-500 block text-xs"
        >
          {{ error }}
        </p>
      </div>
    </template>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import {
  ArrowDownTrayIcon,
  PencilSquareIcon,
  TrashIcon,
} from '@heroicons/vue/24/outline'

const props = defineProps({
  id: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: 'label',
  },
  value: {
    type: [File, String],
    default: '',
  },
  previewUrl: {
    type: String,
    default: '',
  },
  required: {
    type: Boolean,
    default: () => false,
  },
  errors: {
    type: Array,
    default: () => [],
  },
  wrapperClass: {
    type: [String, Object, Array],
    default: '',
  },
  labelClass: {
    type: [String, Object, Array],
    default: '',
  },
  inputClass: {
    type: [String, Object, Array],
    default: '',
  },
  allowedMimes: {
    type: String,
    default: 'image/*',
  },
})

const emit = defineEmits(['change'])

const fileInput = ref(null)
const fileValue = ref(null)
const filePreview = ref(null)

onMounted(() => {
  if (props.previewUrl) {
    filePreview.value = props.previewUrl
  }
})

const getFileInputValue = (event) => {
  const file = event.target.files
  fileValue.value = file[0]
  if (fileValue.value?.type.includes('image')) {
    filePreview.value = URL.createObjectURL(file[0])
  } else {
    filePreview.value = null
  }
  emit('change', fileValue.value)
}

const clickFileInput = () => {
  fileInput.value.click()
  // document.getElementById('fileInput').click()
}

const removeFile = () => {
  fileValue.value = null
  filePreview.value = null
  document.getElementById('fileInput').value = ''
  emit('change', fileValue.value)
}
</script>
