<script lang="ts" setup>

</script>
<template>
    <div id="custom-contact-section" data-v-app="">
      <div id="contact-section" data-v-app="">
        <div class="contact-form form-row">
          <div class="form-column"><h3>Message me!</h3>
            <form novalidate="">
              <div class="ec-form__cell"><span class="ec-form__title ec-header-h6">Your contact details</span>
                <div class="form-control--empty form-control form-control--flexible form-control--label"><input
                    id="firstName" aria-label="First name" autocomplete="first-name" autocorrect="off" class="form-control__text"
                    enterkeyhint="next" maxlength="255" name="firstName" required="" type="text"><label
                    for="firstName"><span class="form-control__label">First name</span></label>
                  <div class="form-control__placeholder">
                    <div class="form-control__placeholder-inner">First name</div>
                  </div>
                </div><!--v-if--></div>
              <div class="ec-form__cell">
                <div class="form-control--empty form-control form-control--flexible form-control--label"><input
                    id="lastName" aria-label="Last name" autocomplete="first-name" autocorrect="off" class="form-control__text"
                    enterkeyhint="next" maxlength="255" name="lastName" required="" type="text"><label
                    for="lastName"><span class="form-control__label">Last name</span></label>
                  <div class="form-control__placeholder">
                    <div class="form-control__placeholder-inner">Last name</div>
                  </div>
                </div><!--v-if--></div>
              <div class="ec-form__cell">
                <div class="form-control--empty form-control form-control--flexible form-control--label"><input
                    id="email" aria-label="Email" autocomplete="first-name" autocorrect="off" class="form-control__text"
                    enterkeyhint="next" maxlength="255" name="email" required="" type="text"><label
                    for="email"><span class="form-control__label">Email</span></label>
                  <div class="form-control__placeholder">
                    <div class="form-control__placeholder-inner">Email</div>
                  </div>
                </div><!--v-if--></div>
              <div class="ec-form__cell"><span class="ec-form__title ec-header-h6">Message</span>
                <div class="form-control--empty form-control form-control--flexible"><textarea id="message"
                                                                                               class="form-control__text message-textarea"
                                                                                               style="height: 200px;"></textarea>
                </div><!--v-if--></div>
              <div class="ec-form__row ec-form__row--continue">
                <div class="ec-form__cell ec-form__cell--6">
                  <div
                      class="form-control form-control--button form-control--large form-control--primary form-control--flexible form-control--done form-control--disabled">
                    <button class="form-control__button" type="submit"><span
                        class="form-control__button-text">Send</span></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="form-column contact-section column-padding-left-18"><h3>Contact details</h3>
            <p>Business hours: 5:00 - 15:00 (UTC/GMT)</p>
            <ul>
              <li>
                <div class="fa-icon">
                  <svg aria-hidden="true" class="svg-inline--fa fa-location-dot" data-icon="location-dot" data-prefix="fas"
                       focusable="false" role="img" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
                    <path class="" d="M168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2H168.3zM192 256C227.3 256 256 227.3 256 192C256 156.7 227.3 128 192 128C156.7 128 128 156.7 128 192C128 227.3 156.7 256 192 256z"
                          fill="currentColor"></path>
                  </svg>
                </div>
                <span>Mailing address: Latvia, Riga, Rupniecibas 18-16, LV1010</span></li>
              <li>
                <div class="fa-icon">
                  <svg aria-hidden="true" class="svg-inline--fa fa-envelope" data-icon="envelope" data-prefix="fas"
                       focusable="false" role="img" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path class="" d="M464 64C490.5 64 512 85.49 512 112C512 127.1 504.9 141.3 492.8 150.4L275.2 313.6C263.8 322.1 248.2 322.1 236.8 313.6L19.2 150.4C7.113 141.3 0 127.1 0 112C0 85.49 21.49 64 48 64H464zM217.6 339.2C240.4 356.3 271.6 356.3 294.4 339.2L512 176V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V176L217.6 339.2z"
                          fill="currentColor"></path>
                  </svg>
                </div>
                <span>Email: contact@ligalazdina.com</span></li>
              <li>
                <div class="fa-icon">
                  <svg aria-hidden="true" class="svg-inline--fa fa-phone" data-icon="phone" data-prefix="fas"
                       focusable="false" role="img" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path class="" d="M511.2 387l-23.25 100.8c-3.266 14.25-15.79 24.22-30.46 24.22C205.2 512 0 306.8 0 54.5c0-14.66 9.969-27.2 24.22-30.45l100.8-23.25C139.7-2.602 154.7 5.018 160.8 18.92l46.52 108.5c5.438 12.78 1.77 27.67-8.98 36.45L144.5 207.1c33.98 69.22 90.26 125.5 159.5 159.5l44.08-53.8c8.688-10.78 23.69-14.51 36.47-8.975l108.5 46.51C506.1 357.2 514.6 372.4 511.2 387z"
                          fill="currentColor"></path>
                  </svg>
                </div>
                <span>Phone: +371 29648203</span></li>
              <li>
                <div class="fa-icon">
                  <svg aria-hidden="true" class="svg-inline--fa fa-whatsapp-square" data-icon="whatsapp-square" data-prefix="fab"
                       focusable="false" role="img" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                    <path class="" d="M224 122.8c-72.7 0-131.8 59.1-131.9 131.8 0 24.9 7 49.2 20.2 70.1l3.1 5-13.3 48.6 49.9-13.1 4.8 2.9c20.2 12 43.4 18.4 67.1 18.4h.1c72.6 0 133.3-59.1 133.3-131.8 0-35.2-15.2-68.3-40.1-93.2-25-25-58-38.7-93.2-38.7zm77.5 188.4c-3.3 9.3-19.1 17.7-26.7 18.8-12.6 1.9-22.4 .9-47.5-9.9-39.7-17.2-65.7-57.2-67.7-59.8-2-2.6-16.2-21.5-16.2-41s10.2-29.1 13.9-33.1c3.6-4 7.9-5 10.6-5 2.6 0 5.3 0 7.6 .1 2.4 .1 5.7-.9 8.9 6.8 3.3 7.9 11.2 27.4 12.2 29.4s1.7 4.3 .3 6.9c-7.6 15.2-15.7 14.6-11.6 21.6 15.3 26.3 30.6 35.4 53.9 47.1 4 2 6.3 1.7 8.6-1 2.3-2.6 9.9-11.6 12.5-15.5 2.6-4 5.3-3.3 8.9-2 3.6 1.3 23.1 10.9 27.1 12.9s6.6 3 7.6 4.6c.9 1.9 .9 9.9-2.4 19.1zM400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM223.9 413.2c-26.6 0-52.7-6.7-75.8-19.3L64 416l22.5-82.2c-13.9-24-21.2-51.3-21.2-79.3C65.4 167.1 136.5 96 223.9 96c42.4 0 82.2 16.5 112.2 46.5 29.9 30 47.9 69.8 47.9 112.2 0 87.4-72.7 158.5-160.1 158.5z"
                          fill="currentColor"></path>
                  </svg>
                </div>
                <a href="https://wa.me/0037129648203">Click to chat in Whatsapp</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
</template>