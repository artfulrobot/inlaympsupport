<template>
  <li>
    <div class="party bc-lb1">

      <h3>
        <svg-vue class="x" style="max-height: 3rem;" :icon="party.logo" ></svg-vue>
        <div class="count-layout"><span class="count">{{party.mps.length}}</span></div>
      </h3>
      <ol>
        <li v-for="mp in mps" >
          <span :is="mp.h ? 'strong' : 'span'">{{mp.c}} - {{mp.n}} MP</span>
        </li>
      </ol>
      <p style="text-align: center; margin: 1rem 0 0;" v-show="hasMix" >
        <a href
           v-show="!showAll"
           @click.prevent="showAll = 1"
           >Show {{countHidden}} other MP{{ countHidden > 1 ? 's' : '' }}</a>
        <a href
           v-show="showAll"
           @click.prevent="showAll = 0"
           >Hide MPs</a>
      </p>
    </div>
  </li>
</template>
<script>
export default {
  props: ['party'],
  data() {
    return {
      showAll: false,
    };
  },
  computed: {
    hasMix() {
      return this.countHidden > 0;
    },
    countHidden() {
      return this.party.mps.length - this.party.mps.filter(mp => mp.h === 1).length;
    },
    mps() {
      if (this.showAll) {
        return this.party.mps;
      }
      return this.party.mps.filter(mp => mp.h === 1);
    }
  }
};
</script>
