<template>
  <li>
    <div class="party bc-lb1">
      <h3>
        <div class="logo-layout"><svg-vue v-if="logoExists" style="max-height: 3rem;" :icon="party.logo" ></svg-vue>{{ logoExists ? '' : party.name }}</div>
        <div class="count-layout"><span class="count">{{party.mps.length}}</span></div>
      </h3>
      <ol>
        <li v-for="mp in mps" v-if="mp.show">
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
  props: ['party', 'search'],
  data() {
    return {
      showAll: false,
      logoExists: ['conservatives', 'dup', 'green-party', 'labour', 'liberal-democrats', 'plaid-cymru', 'scottish-national-party'].includes(this.party.logo)
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
      if (this.search) {
        return this.party.mps.filter(mp => mp.show);
      }
      else {
        if (this.showAll) {
          return this.party.mps;
        }
        return this.party.mps.filter(mp => mp.h === 1);
      }
    }
  }
};
</script>
