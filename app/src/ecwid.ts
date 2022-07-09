import "@style/ecwid.css";
import EcwidFooter from "@src/views/EcwidFooter.vue";
import EcwidContact from "@src/views/EcwidContact.vue";
import EcwidContactHtml from "@src/views/EcwidContactHtml.vue";
import {createApp} from 'vue';
import {Form, Field} from 'vee-validate';

createApp(EcwidFooter).mount('.tile-footer');
const contactForm = createApp(EcwidContact);
contactForm.component('VForm', Form);
contactForm.component('VField', Field);
contactForm.mount('#contact-section')

// createApp(EcwidContactHtml).mount('#contact-section');

Ecwid.OnPageLoaded.add(function(page){
    if (page?.page === 'about') {
        createApp(EcwidContact).mount('#custom-contact-section');
    }
});
