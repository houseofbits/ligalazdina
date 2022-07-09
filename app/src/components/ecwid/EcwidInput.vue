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
  },
  label: {
    type: String,
    required: true
  },
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
      class="form-control form-control--flexible form-control--label"
  >
    <input
        :id="props.name"
        v-model="value"
        :aria-label="props.label"
        :name="props.name"
        autocomplete="first-name"
        autocorrect="off"
        class="form-control__text"
        enterkeyhint="next"
        maxlength="255"
        required=""
        type="text"
        @blur="onBlur"
        @focus="isInFocus = true"
        @input="onChange"
    />
    <label :for="props.name">
      <span class="form-control__label">{{ props.label }}</span>
    </label>
    <div class="form-control__placeholder">
      <div class="form-control__placeholder-inner">{{ props.label }}</div>
    </div>
  </div>
  <div v-if="isValidationErrorVisible" :id="'error-message-' + props.name" class="form__msg form__msg--error">
    {{
      errorMessage
    }}
  </div>
</template>