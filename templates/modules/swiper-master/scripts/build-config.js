import { parseSwiperBuildModulesEnv } from './utils/helper.js';

const envBuildModules = parseSwiperBuildModulesEnv();

export const modules = envBuildModules || [
  'virtual',
  'navigation',
  'autoplay',
  'thumbs',
];

export default {
  modules,
};
