<template>
  <div class="container">
    <h1>hallo</h1>
    <sw-button variant="primary" @click="clickButton">Log SalesChannel</sw-button>
  </div>
</template>

<script>
import swButton from '@shopware-ag/meteor-component-library/src/components/form/sw-button/sw-button.vue';
import * as sw from "@shopware-ag/meteor-admin-sdk";

export default {
  name: 'sales-channel',
  components: {
    'sw-button': swButton,
  },
  mounted() {
    sw.location.startAutoResizer();
    sw.location.updateHeight(300);
  },
  methods: {
    clickButton() {
      sw.data.get({ id: 'sw-sales-channel-detail__salesChannel'}).then((sc) => {
        console.log('SalesChannel', sc);
      });
    },
  }
};
</script>

<style scoped>
.container {
  margin: 20px;
}
</style>
