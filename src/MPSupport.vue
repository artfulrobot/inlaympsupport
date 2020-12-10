<template>
  <div style="overflow:hidden;" class="inlay-mpsupport imps">

    <h2 v-if="inlay.initData.publicTitle">{{inlay.initData.publicTitle}}</h2>
    <div
      v-if="inlay.initData.introHTML"
      v-html="inlay.initData.introHTML"
      class="imps-intro"></div>

    <form @submit.prevent="" action='#' class="imps-search">
      <div>
        <div class="imps-searchbox">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
          <input type="text" v-model="search" @input="updateSearch" />
        </div>
        <span>{{searchResult}}</span>
      </div>
    </form>

    <ul class="imps-partylist" >
      <mp-list
        v-for="party in parties"
        :key="party.name"
        :party="party"
        :search="search"
        ></mp-list>
    </ul>
  </div>
</template>
<style lang="scss">
.imps-searchbox {
  position: relative;
  display: inline-block;
  margin-right: 1rem;

  svg {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    fill: #1f4f91;
  }
  input {
    border: solid 1px #d8d8d8;
    border-radius: 3px;
    padding: 0.5rem 1rem 0.5rem 2.5rem;
  }
}
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
      parties: this.inlay.initData.mps,
      search: '',
      searchResult: '',
    };
    // do logo
    d.parties.forEach(party => {
      party.logo = party.name.replace(/ /g,'-').toLowerCase();
      party.mps.forEach(mp => { mp.show = true; mp.haystack = (mp.c + mp.n).toLowerCase(); });
    });
    return d;
  },
  methods: {
    updateSearch() {
      const needle = this.search.toLowerCase();
      var count = 0;
      this.parties.forEach(party => {
        party.mps.forEach(mp => {
          mp.show = needle ? mp.haystack.indexOf(needle) > -1 : true;
          count += mp.show ? 1 : 0;
        });
      });
      this.searchResult = '';
      if (needle) {
        if (count > 0) {
          this.searchResult = count + ' match' + (count>1 ? 'es' : '');
        }
        else {
          this.searchResult = 'MP not found';
        }
      }
    }
  }
}
</script>
