<template>
  <div style="overflow:hidden;" class="inlay-mpsupport imps">

    <h2 v-if="inlay.initData.publicTitle">{{inlay.initData.publicTitle}}</h2>
    <div
      v-if="inlay.initData.introHTML"
      v-html="inlay.initData.introHTML"
      class="imps-intro"></div>

    <ul class="imps-partylist" >
      <mp-list
        v-for="party in parties"
        :key="party.name"
        :party="party"
        ></mp-list>
    </ul>
  </div>
</template>
<style lang="scss">
// Invisible flex wrapper
.imps-partylist {
  padding: 0;
  margin: 1rem -1rem;
  display: flex;
  flex-wrap: wrap;

  // Invisible flex item wrapper
  &>li {
    flex: 0 0 24rem;
    list-style: none;
    margin: 0 0 1rem;
    padding: 0 1rem;
  }

  // Visible block
  .party {
    height: 100%;
    padding: 1rem;
    h3 {
      margin: 0 0 1rem;
      font-size:1rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      &>.logo-layout { flex: 1 0 50%; }
      &>.count-layout { flex: 0 0 auto; padding-left: 1rem; }
    }
  }
  .count {
    border-radius: 1rem;
    background: #1f4f91;
    color: white;
    padding: 0 0.5rem;
  }
}
</style>
<script>
import MpList from './MpList.vue';

export default {
  props: ['inlay'],
  components: {MpList},
  data() {
    const d = {
      myId: this.$root.getNextId(),
    };
    return d;
  },
  computed: {
    parties() {
      this.inlay.initData.mps.forEach(party => {
        party.logo = party.name.replace(/ /g,'-').toLowerCase();
      });
      return this.inlay.initData.mps;
    }
  },
  methods: {
  }
}
</script>
