import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/scss/style.scss',  // SCSSファイルのエントリーポイント
        'resources/js/app.js',        // JavaScriptファイルのエントリーポイント
      ],
      refresh: true,
    }),
  ],
  resolve: {
    alias: {
      '@img': '/public/img',
      '@': path.resolve(__dirname, 'resources'),
      '~slick-carousel': path.resolve(__dirname, 'node_modules/slick-carousel'),
      '~': path.resolve(__dirname, 'node_modules')
    }
  }
});
