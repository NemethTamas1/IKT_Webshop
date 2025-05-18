import { setActivePinia, createPinia } from 'pinia'
import { useCartStore } from '@/stores/CartStore'

describe('CartStore', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  it('adds different products as separate items in the cart', () => {
    const cartStore = useCartStore()

    const productA = {
      id: 1,
      name: 'Fehérje',
      price: 4990,
      quantity: 1
    }

    const productB = {
      id: 2,
      name: 'Multivitamin',
      price: 2990,
      quantity: 1
    }

    cartStore.addToCart(productA)
    cartStore.addToCart(productB)

    expect(cartStore.cart.length).toBe(2)
    expect(cartStore.cart[0].id).toBe(1)
    expect(cartStore.cart[1].id).toBe(2)
  })

  it('increases quantity when the same product is added again', () => {
    const cartStore = useCartStore()

    const product = {
      id: 1,
      name: 'Fehérje',
      price: 4990,
      quantity: 1
    }

    cartStore.addToCart(product)
    cartStore.addToCart(product)

    expect(cartStore.cart.length).toBe(1)
    expect(cartStore.cart[0].quantity).toBe(2)
  })
})
