import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import {wordpressPlugin, wordpressThemeJson} from '@roots/vite-plugin';
import browserslist from 'browserslist';
import {browserslistToTargets} from 'lightningcss';
import path from 'path';
import {babel} from '@rollup/plugin-babel';
import {devDependencies} from './package.json';

import {globSync} from 'glob';

// Получаем все CSS-файлы из resources/css/blocks/**/*.css
const blockStyles = globSync('resources/css/blocks/**/style.css');
const blockScripts = globSync('resources/js/blocks/**/index.js');

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
    minify: true,
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
        'resources/js/vanilla-lazyload.js',
        // 'resources/js/alpine.js',
        'resources/js/app.js',
        // 'resources/js/swiper.js',

        'resources/css/app.css',
        'resources/css/admin.css',
        // 'resources/css/blog.css',
        // 'resources/css/services.css',
        // 'resources/css/portfolio.css',
        // 'resources/css/reviews.css',
        // 'resources/css/blocks/404.css',
        // 'resources/css/components/swiper.css',

        ...blockStyles,
        ...blockScripts,
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

    babel({
      babelHelpers: 'bundled', // Важно! Это решит ошибку 'addHelper'
      exclude: 'node_modules/**',
      extensions: ['.js', '.jsx', '.es6', '.es', '.mjs'],
      presets: [
        [
          '@babel/preset-env',
          {
            targets: {
              ie: '11',
              ios: '9',
            },
            modules: false,
            useBuiltIns: 'entry',
            corejs: 3,
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
  server: {
    host: '127.0.0.1',
    port: 5173,
    cors: true,
  },
});
