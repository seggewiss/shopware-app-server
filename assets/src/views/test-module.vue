<template>
<div class='card-view'>
  <mt-card title="Test">
    <mt-button @click="onLogToConsoleClicked">Log to console</mt-button>
    <mt-button @click="onAddToastClicked">Add toast</mt-button>
  </mt-card>
</div>
</template>

<script setup lang='ts'>
import * as sw from '@shopware-ag/meteor-admin-sdk';
import { MtCard, MtButton } from '@shopware-ag/meteor-component-library';

const onLogToConsoleClicked = () => {
  console.log('Log to console clicked');
}

const onAddToastClicked = () => {
  sw.toast.dispatch({
    msg: 'Toast with jam',
    type: 'informal',
    dismissible: true,
  });
}
</script>

<style scoped lang='scss'>
.card-view {
  margin-top: 24px;
}
</style>
