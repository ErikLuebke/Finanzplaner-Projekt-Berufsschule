import { setActivePinia, createPinia } from 'pinia'
import { useAuthStore } from '@/stores/auth'
import { afterEach, beforeEach, describe, expect, it, vi } from 'vitest'

vi.mock('@/api/axios', () => ({
  default: {
    post: vi.fn(),
    defaults: { headers: { common: {} } },
  },
}))

describe('useAuthStore', () => {
  beforeEach(() => {
    vi.stubGlobal('localStorage', {
      store: {},
      getItem(key) { return this.store[key] ?? null },
      setItem(key, value) { this.store[key] = String(value) },
      removeItem(key) { delete this.store[key] },
      clear() { this.store = {} },
    })
    setActivePinia(createPinia())
  })

  afterEach(() => {
    vi.unstubAllGlobals()
  })

  it('isLoggedIn ist false wenn kein Token gesetzt ist', () => {
    const store = useAuthStore()
    expect(store.isLoggedIn).toBe(false)
  })

  it('isLoggedIn ist true nach setAuth', () => {
    const store = useAuthStore()
    store.setAuth({ token: 'test-token', user: { name: 'TestUser' } })
    expect(store.isLoggedIn).toBe(true)
  })
})
