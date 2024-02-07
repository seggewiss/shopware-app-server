<template>
  <div class="container">
    <sw-button variant="primary" @click="clickButton">Log order</sw-button>
  </div>
</template>

<script>
import swButton from '@shopware-ag/meteor-component-library/src/components/form/sw-button/sw-button.vue';
import * as sw from "@shopware-ag/meteor-admin-sdk";

export default {
  name: 'order',
  components: {
    'sw-button': swButton,
  },
  methods: {
    clickButton() {
      sw.data.get({ id: 'sw-order-detail-base__order'}).then((order) => {
        console.log('Order', order);
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
