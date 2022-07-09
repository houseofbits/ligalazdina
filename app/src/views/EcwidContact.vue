<script setup lang="ts">
import EcwidContactForm from '@src/components/ecwid/EcwidContactForm.vue';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {library} from '@fortawesome/fontawesome-svg-core'
import {faLock, faLocationDot, faEnvelope, faPhone} from '@fortawesome/free-solid-svg-icons'
import {faWhatsappSquare} from '@fortawesome/free-brands-svg-icons'

library.add(faLock, faLocationDot, faEnvelope, faPhone, faWhatsappSquare);

</script>
<template>

  <div class="contact-form form-row">
    <div class="form-column">
      <ecwid-contact-form/>
    </div>

    <div class="form-column contact-section column-padding-left-18 ">
      <h3>Contact details</h3>
      <p>Business hours: 5:00 - 15:00 (UTC/GMT)</p>
      <ul>
        <li>
          <div class="fa-icon">
            <font-awesome-icon icon="fa-solid fa-location-dot"/>
          </div>
          <span>Mailing address: Latvia, Riga, Rupniecibas 18-16, LV1010</span>
        </li>
        <li>
          <div class="fa-icon">
            <font-awesome-icon icon="fa-solid fa-envelope"/>
          </div>
          <span>Email: contact@ligalazdina.com</span>
        </li>
        <li>
          <div class="fa-icon">
            <font-awesome-icon icon="fa-solid fa-phone"/>
          </div>
          <span>Phone: +371 29648203</span>
        </li>
        <li>
          <div class="fa-icon">
            <font-awesome-icon icon="fa-brands fa-whatsapp-square"/>
          </div>
          <a href="https://wa.me/+37129648203">Click to chat in Whatsapp</a>
        </li>
      </ul>
    </div>
  </div>
</template>
