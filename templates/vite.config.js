import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin';
import browserslist from 'browserslist';
import { browserslistToTargets } from 'lightningcss';
import path from 'path';
import { getBabelOutputPlugin } from '@rollup/plugin-babel';
import { devDependencies } from './package.json';

export default defineConfig({
  base: '/wp-content/themes/{{TEXT_DOMAIN}}/public/build',
  css: {
    lightningcss: {
      targets: browserslistToTargets(
        browserslist([
          '> 0.5%',
          'last 2 versions',
          'Firefox ESR',
          'not dead',
          'IE 11',
          'android 4.4',
          'ios 9',
        ])
      ),
    },
  },
  build: {
    cssMinify: 'lightningcss',
    minify: false,
    target: 'es2015',
    // rollupOptions: {
    //   external: ['alpinejs', 'vanilla-lazyload'],  // Если они внешние
    //   output: {
    //     globals: {
    //       alpinejs: 'Alpine',
    //       'vanilla-lazyload': 'LazyLoad'
    //     }
    //   }
    // }
  },
  plugins: [
    laravel({
      input: [
        // 'resources/js/vanilla-lazyload.js',
        // 'resources/js/alpine.js',
        // 'resources/js/app.js',
        // 'resources/js/embla.js',
      ],
      refresh: true,
    }),

    wordpressPlugin(),

    // Generate the theme.json file in the public/build/assets directory
    // based on the Tailwind config and the theme.json file from base theme folder
    wordpressThemeJson({
      disableTailwindColors: true,
      disableTailwindFonts: true,
      disableTailwindFontSizes: true,
    }),

    getBabelOutputPlugin({
      babelrc: false,
      configFile: false,
      presets: [
        [
          '@babel/preset-env',
          {
            modules: false,
            useBuiltIns: 'entry',
            corejs: {
              version: devDependencies['core-js'],
            },
          },
        ],
      ],
    }),
  ],
  resolve: {
    alias: {
      '@scripts': path.resolve(__dirname, 'resources/js'),
      '@styles': path.resolve(__dirname, 'resources/css'),
      '@fonts': path.resolve(__dirname, 'resources/fonts'), // Changed from '/resources/fonts'
      '@images': path.resolve(__dirname, 'resources/images'),
    },
  },
});
