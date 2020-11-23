import Vue from 'vue';

import MPSupport from './MPSupport.vue';
import SvgVue from 'svg-vue';
Vue.use(SvgVue);


(() => {
  if (!window.inlayMPSupportInit) {
    // This is the first time this *type* of Inlay has been encountered.
    // We need to define anything global here.

    // Inject the SVG
    var svgContainer = false;

    // Create the boot function.
    window.inlayMPSupportInit = inlay => {

      if (false && !svgContainer) {
        svgContainer = document.createElement('div');
        svgContainer.style.display = 'none';
        svgContainer.innerHTML = inlay.initData.partiesSvg;
        document.body.appendChild(svgContainer);
      }
      const inlayNode = document.createElement('div');
      inlay.script.insertAdjacentElement('afterend', inlayNode);
      /* eslint no-unused-vars: 0 */
      // This is the root app.
      console.debug(inlay);
      const app = new Vue({
        el: inlayNode,
        data() {
          var d = {
            inlay,
            formID: 0,
            submissionRunning: false
          };
          return d;
        },
        render: h => h(MPSupport, {props: {inlay}}),
        methods: {
          getNextId() {
            this.formID++;
            return `i${this.inlay.publicID}-${this.formID}`;
          }
        }
      });
    };
  }
})();
