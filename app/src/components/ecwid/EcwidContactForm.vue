<script lang="ts" setup>
import {ref} from 'vue';
import EcwidInput from "@src/components/ecwid/EcwidInput.vue";
import EcwidTextarea from "@src/components/ecwid/EcwidTextarea.vue";
import * as Yup from "yup";
import Message from '@src/helpers/Message';
import {Form, Field} from 'vee-validate';

const isMessageSentConfirmationVisible = ref(false);

function onMessageSentSuccessfully(): void {
  if (!isMessageSentConfirmationVisible.value) {
    isMessageSentConfirmationVisible.value = true;
    setTimeout(() => {
      isMessageSentConfirmationVisible.value = false;
      isButtonDisabled.value = false;
    }, 6000);
  }
}

async function onSubmit(values: any): Promise<any> {
  isButtonDisabled.value = true;
  try {
    await Message.send(values);
    onMessageSentSuccessfully();
  } catch (e) {
    isButtonDisabled.value = true;
  }
}

const schema = Yup.object().shape({
  firstName: Yup.string().required().label('First name'),
  lastName: Yup.string().required().label('Last name'),
  email: Yup.string().email().required().label('Email'),
  message: Yup.string().min(6).required().label('Message'),
});

const isButtonDisabled = ref(false);

</script>
<template>
  <h3>Message me!</h3>

  <div v-if="isMessageSentConfirmationVisible" class="email-sent-message">
    <div class="circle">
      <svg height="23" viewBox="0 0 27 23" width="27" xmlns="http://www.w3.org/2000/svg">
        <path class="svg-line-check" d="M1.97 11.94L10.03 20 25.217 2" fill="none" fill-rule="evenodd"
              stroke="currentColor" stroke-linecap="round" stroke-width="3"></path>
      </svg>
    </div>
    <span>Thank you for reaching out. I will get back to you as soon as possible.</span>
  </div>

  <Form :validation-schema="schema" @submit="onSubmit" v-if="!isMessageSentConfirmationVisible">
    <div class="ec-form__cell">
      <span class="ec-form__title ec-header-h6">Your contact details</span>

      <ecwid-input
          label="First name"
          name="firstName"
      />
    </div>
    <div class="ec-form__cell">
      <ecwid-input
          label="Last name"
          name="lastName"
      />
    </div>
    <div class="ec-form__cell">
      <ecwid-input
          label="Email"
          name="email"
      />
    </div>

    <div class="ec-form__cell">
      <span class="ec-form__title ec-header-h6">Message</span>
      <ecwid-textarea
          name="message"
      />
    </div>

    <div class="ec-form__row ec-form__row--continue">
      <div class="ec-form__cell ec-form__cell--6">
        <div
            :class="{'form-control--disabled': isButtonDisabled}"
            class="form-control form-control--button form-control--large form-control--primary form-control--flexible form-control--done"
        >
          <button :disabled="isButtonDisabled" class="form-control__button" type="submit">
            <span class="form-control__button-text">Send</span></button>
        </div>
      </div>
    </div>
  </Form>

</template>
<style lang="scss" scoped>
html#ecwid_html body#ecwid_body .ec-size .ec-store .email-sent-message {
  padding: 8px;
  margin-top: 16px;
  margin-bottom: 16px;
  display: flex;
  flex-direction: row;
  justify-content: left;
  align-items: center;
  transition: all;
  transition-duration: 400ms;

  & .circle {
    color: rgb(26, 122, 196);
    border-radius: 50%;
    border: solid 1px rgb(26, 122, 196);
    width: 32px;
    height: 32px;
    display: flex;
    justify-content: center;
    align-items: center;

    & svg {
      width: 16px;
      height: 16px;
    }
  }

  & span {
    color: #1cb920;
    font-size: 14px;
    font-weight: bold;
    padding-left: 12px;
    line-height: 15px;
  }
}
</style>
