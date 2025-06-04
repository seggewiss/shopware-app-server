<template>
    <div>
        <h1>Sidebar Bar</h1>
    </div>

    <input type="text" v-model="inputValue"/>
    <p>Input value: {{ inputValue }}</p>

    <button @click="onCloseSidebar">Close this sidebar</button>
</template>

<script setup lang='ts'>
import * as sw from '@shopware-ag/meteor-admin-sdk';
import { ref } from 'vue';

const inputValue = ref('');

const onCloseSidebar = () => {
    sw.ui.sidebar.close({
        locationId: 'sidebar-bar',
    });
};
</script>