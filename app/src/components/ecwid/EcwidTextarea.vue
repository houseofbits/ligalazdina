<script lang="ts" setup>
import * as _ from "lodash";
import {computed, ref, toRef} from 'vue';
import {useField} from "vee-validate";

const emit = defineEmits(['input']);

const props = defineProps({
  value: {
    type: String,
    default: ''
  },
  name: {
    type: String,
    required: true
  }
});

const name = toRef(props, "name");

const {
  value,
  errorMessage,
  handleBlur,
  handleChange,
  meta,
} = useField(name, undefined, {
  initialValue: props.value,
});

const isInFocus = ref<boolean>(false);

const isEmpty = computed<boolean>(() => {
  return _.isEmpty(value.value);
});

function onBlur(e: any): void {
  isInFocus.value = false;
  handleBlur();
}

function onChange(e: any): void {
  emit('input', value.value);
  handleChange(e);
}

const isValidationErrorVisible = computed<boolean>(() => {
  return meta.validated && !meta.valid;
});

</script>
<template>
  <div
      :class="{
    'form-control--empty':isEmpty,
    'form-control--focus': isInFocus,
    'form-control--error': isValidationErrorVisible
  }"
      class="form-control form-control--flexible"
  >
    <textarea
        :id="props.name"
        style="height: 200px;"
        v-model="value"
        :aria-label="props.label"
        class="form-control__text message-textarea"
        @blur="onBlur"
        @focus="isInFocus = true"
        @input="onChange"
    />
  </div>
  <div v-if="isValidationErrorVisible" :id="'error-message-' + props.name" class="form__msg form__msg--error">
    {{
      errorMessage
    }}
  </div>
</template>
