export default {
  create: () => ({
    interceptors: { request: { use: () => {} } },
    get: () => Promise.resolve({ data: {} }),
    post: () => Promise.resolve({ data: {} }),
    defaults: { headers: { common: {} } },
  }),
}
