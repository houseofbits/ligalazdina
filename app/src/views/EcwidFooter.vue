<script setup lang="ts">
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {library} from '@fortawesome/fontawesome-svg-core'
import {faLock, faLocationDot, faEnvelope, faPhone} from '@fortawesome/free-solid-svg-icons'

library.add(faLock, faLocationDot, faEnvelope, faPhone);

function openCategory(id: number): void {
  Ecwid.openPage('category', {id});
}

function openPage(page: string): void {
  Ecwid.openPage('pages/' + page);
}

</script>
<template>
  <div class="custom-footer">
    <div class="footer-sections">
      <div class="col about-section">
        <img class="footer-logo" src="https://www.ligalazdina.com/images/ll-logo.png" alt="Logo">
        <a class="website-link" href="https://www.ligalazdina.com">www.ligalazdina.com</a>
        <div class="footer-social-links">
          <a href="https://facebook.com/105409448785323">
            <img src="https://www.ligalazdina.com/images/fb-logo.png" alt="Facebook">
          </a>
          <a href="https://instagram.com/lazdina_liga_art">
            <img src="https://www.ligalazdina.com/images/insta-logo.png" alt="Instagram">
          </a>
        </div>
      </div>
      <div class="col">
        <h3 class="footer-section-header">Categories</h3>
        <ul>
          <li class="cursor-pointer" @click="openCategory(128435496)">Postcards / Greeting cards</li>
          <li class="cursor-pointer" @click="openCategory(128443058)">Wall art</li>
          <li class="cursor-pointer" @click="openCategory(130234031)">Accessories</li>
          <li class="cursor-pointer" @click="openCategory(130277542)">Items by Artwork</li>
        </ul>
      </div>
      <div class="col">
        <h3 class="footer-section-header">Information</h3>
        <ul>
          <li class="cursor-pointer" @click="openPage('terms')">Terms & Conditions</li>
          <li class="cursor-pointer" @click="openPage('privacy-policy')">Privacy Policy</li>
          <li class="cursor-pointer" @click="openPage('shipping-payment')">Shipping & Payment info</li>
          <li class="cursor-pointer" @click="openPage('returns')">Return Policy</li>
          <li class="cursor-pointer" @click="openPage('about')">Contact</li>
          <li><a
              href="mailto:abuse@company.site?subject=Complaint against store: SID 72527999&body=SID 72527999, https://store.ligalazdina.com">Report
            Abuse</a></li>
        </ul>
      </div>
      <div class="col contact-section">
        <h3 class="footer-section-header">Contact</h3>
        <ul>
          <li>
            <div class="icon-wrapper">
              <font-awesome-icon icon="fa-solid fa-location-dot" class="fa-icon"/>
            </div>
            <span>Mailing address: Latvia, Riga, Rupniecibas 18-16, LV1010</span>
          </li>
          <li>
            <div class="icon-wrapper">
              <font-awesome-icon icon="fa-solid fa-envelope" class="fa-icon"/>
            </div>
            <span>Email: contact@ligalazdina.com</span>
          </li>
          <li>
            <div class="icon-wrapper">
              <font-awesome-icon icon="fa-solid fa-phone" class="fa-icon"/>
            </div>
            <span>Phone: +371 29648203</span>
          </li>
        </ul>
      </div>
    </div>
    <div class="footer-payment-methods">
      <h3 class="footer-section-header">
        <font-awesome-icon icon="fa-solid fa-lock" class="fa-icon icon-margin"/>
        <span>Secure online payment</span>
      </h3>
      <div>
        <img src="https://www.ligalazdina.com/images/p-paypal.jpg" alt="PayPal">
        <img src="https://www.ligalazdina.com/images/p-visa.jpg" alt="Visa">
        <img src="https://www.ligalazdina.com/images/p-master.jpg" alt="Mastercard">
        <img src="https://www.ligalazdina.com/images/p-amex.jpg" alt="Amex">
        <img src="https://www.ligalazdina.com/images/p-discover.jpg" alt="Discover">
        <img src="https://www.ligalazdina.com/images/p-jcb.jpg" alt="JCB">
        <img src="https://www.ligalazdina.com/images/p-dinners.jpg" alt="Dinners Club">
        <img src="https://www.ligalazdina.com/images/p-union.jpg" alt="Union Pay">
        <img src="https://www.ligalazdina.com/images/p-apple.jpg" alt="Apple Pay">
        <img src="https://www.ligalazdina.com/images/p-google.jpg" alt="Google Pay">
      </div>
    </div>
    <div class="footer-copyright">
      Copyright © Liga Lazdina
    </div>
  </div>
</template>

<style lang="scss" scoped>
html#ecwid_html body#ecwid_body {

  .custom-footer {
    width: 100%;
    height: auto;
    background-color: #3f3f3f;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 380px;
    overflow: hidden;

    .fa-icon {
      overflow: visible;
      box-sizing: content-box;
      height: 1em;
      vertical-align: -0.125em;
    }

    .col h3 {
      font-size: 16px;
    }

    .col ul li, .col a {
      text-decoration: none;
      color: #cccccc;
      font-size: 14px;
      font-weight: 400;
    }

    .col ul li:hover, .col a:hover {
      color: white;
    }

    .contact-section ul li:hover {
      color: #cccccc;
    }

    .col ul li {
      margin-top: 12px;
      padding-left: 8px;
    }

    .col ul {
      padding-left: 16px;
    }

    .col .website-link {
      text-decoration: none;
      color: white;
      font-size: 16px;
      font-weight: 600;
      margin-top: 8px;
      margin-bottom: 12px;
    }

    .col .website-link:hover {
      color: #cccccc;
    }

    .footer-social-links {
      margin-bottom: 8px;
    }

    .footer-sections {
      width: 100%;
      max-width: 1200px;
      display: flex;
      flex-direction: row;
      color: white;
    }

    .col {
      padding-top: 18px;
      flex-grow: 1;
      height: auto;
      flex-basis: 25%;
    }

    .about-section {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 16px;
    }

    .footer-section-header {
      margin: 0;
      padding: 0;
    }

    .footer-logo {
      width: 80%;
      max-width: 300px;
    }

    .footer-payment-methods {
      width: 100%;
      color: white;
      background-color: #282828;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 8px 8px;
    }

    .footer-payment-methods .icon-margin {
      margin-right: 8px;
    }

    .footer-payment-methods img {
      height: 32px;
      margin-right: 8px;
    }

    .footer-payment-methods div {
      margin-left: 8px;
      margin-right: 8px;
    }

    .footer-payment-methods h3 {
      margin-bottom: 8px;
      font-size: 14px;
      color: #cccccc;
    }

    .footer-copyright {
      color: lightgray;
      text-align: center;
      padding: 8px;
      font-size: 14px;
    }

    .contact-section ul {
      padding: 0;
      list-style-type: none;

      & li {
        padding: 0;
        display: flex;

        & .icon-wrapper {
          margin-right: 8px;
          width: 20px;
          display: flex;
          justify-content: center;
          flex-basis: 20px;
          flex-grow: 0;
          flex-shrink: 0;
        }
      }
    }

    @media only screen and (max-width: 900px) {
      .footer-sections {
        flex-wrap: wrap;
      }

      .about-section, .contact-section {
        flex-basis: 100%;
      }

      .contact-section {
        padding: 16px 16px 8px;
      }

      .col {
        display: flex;
        flex-direction: column;
        align-items: center;
      }
    }

    @media only screen and (max-width: 530px) {
      .col {
        flex-basis: 100%;
      }
    }

    .desktopPicture {
      width: 100%;
      height: 800px;
      position: absolute;
      opacity: 0.2;
    }

    .cursor-pointer {
      cursor: pointer;
    }
  }
}
</style>