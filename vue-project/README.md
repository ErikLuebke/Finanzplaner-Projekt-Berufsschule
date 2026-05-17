# vue-project

This template should help get you started developing with Vue 3 in Vite.

## Recommended IDE Setup

[VS Code](https://code.visualstudio.com/) + [Vue (Official)](https://marketplace.visualstudio.com/items?itemName=Vue.volar) (and disable Vetur).

## Recommended Browser Setup

- Chromium-based browsers (Chrome, Edge, Brave, etc.):
  - [Vue.js devtools](https://chromewebstore.google.com/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd) 
  - [Turn on Custom Object Formatter in Chrome DevTools](http://bit.ly/object-formatters)
- Firefox:
  - [Vue.js devtools](https://addons.mozilla.org/en-US/firefox/addon/vue-js-devtools/)
  - [Turn on Custom Object Formatter in Firefox DevTools](https://fxdx.dev/firefox-devtools-custom-object-formatters/)

## Customize configuration

See [Vite Configuration Reference](https://vite.dev/config/).

## Project Setup

```sh
npm install
```

### Compile and Hot-Reload for Development

```sh
npm run dev
```

### Compile and Minify for Production

```sh
npm run build
```

### Run Unit Tests with [Vitest](https://vitest.dev/)

```sh
npm run test:unit
```
######
# Vue + Vite + Docker Starter

Ein minimalistisches Vue 3 + Vite Projekt mit Docker-Setup (Entwicklung mit Hot-Reload) und optionalem Produktionsbuild via Nginx.

## Entwicklung starten
- docker compose -f docker-compose.dev.yml up
- Öffne http://localhost:5173

Stoppen: Strg+C, optional `docker compose -f docker-compose.dev.yml down`

## Pakete installieren (im Container)
- Neues Paket: docker compose -f docker-compose.dev.yml run --rm web npm i <paket>
- Dev-Paket: docker compose -f docker-compose.dev.yml run --rm web npm i -D <paket>
- Entfernen: docker compose -f docker-compose.dev.yml run --rm web npm uninstall <paket>

## Produktionsbuild (optional)
- Build: docker build -t vue-vite-docker-starter:prod .
- Run:  docker run -p 8080:80 vue-vite-docker-starter:prod
- Öffne http://localhost:8080

## Branch-Workflow (Empfehlung)
- main: stabil
- feature/<beschreibung>: neue Features per PR auf main
