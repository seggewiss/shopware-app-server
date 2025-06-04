<template>
  <component :is='page' />
</template>

<script setup lang='ts'>
import type { Component } from 'vue';
import { computed, defineOptions } from 'vue';
import * as sw from '@shopware-ag/meteor-admin-sdk';
import TestModule from '@/views/test-module.vue';
import SidebarFoo from '@/views/sidebar-foo.vue';
import SidebarBar from '@/views/sidebar-bar.vue';
import DailyMotionElement from '@/views/swag-dailymotion/element.vue';
import DailyMotionConfig from '@/views/swag-dailymotion/config.vue';
import DailyMotionPreview from '@/views/swag-dailymotion/preview.vue';
import MainModule from '@/views/main-module.vue';

defineOptions({
  name: 'app-controller',
});

const pages: Record<string, Component> = {
    'test-module': TestModule,
    'sidebar-foo': SidebarFoo,
    'sidebar-bar': SidebarBar,
    'main-module': MainModule,
    'swag-dailymotion-element': DailyMotionElement,
    'swag-dailymotion-config': DailyMotionConfig,
    'swag-dailymotion-preview': DailyMotionPreview,
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
