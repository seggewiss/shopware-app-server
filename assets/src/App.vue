<template>
  <component :is='page' />
</template>

<script setup lang='ts'>
import type { Component } from 'vue';
import { computed, defineOptions } from 'vue';
import * as sw from '@shopware-ag/meteor-admin-sdk';
import TestModule from '@/views/test-module.vue';

defineOptions({
  name: 'app-controller',
});

const pages: Record<string, Component> = {
    'test-module': TestModule,
};

const page = computed(() => {
  if (sw.location.is(sw.location.MAIN_HIDDEN))
    return null;

  const location = sw.location.get();

  if (!pages[location])
    throw new Error('Page not found');

  return pages[location];
})
</script>
