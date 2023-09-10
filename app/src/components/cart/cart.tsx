'use client'

import styles from "@/components/cart/cart.module.css"
import {useCart} from "@/services/use-cart";
import Product from "@/components/cart/product";
import Price from "@/components/shared/price";

export default function Cart() {
    const [cart, deleteHandler] = useCart();

    return (
        <>
            {
                cart &&
                <div>
                    <section className={styles.productCollection}>
                        {
                            cart.productItems.map((p) => <Product key={p.productId} cartId={cart.id} product={p} deleteHandler={() => deleteHandler(cart.id, p.productId)}/>)
                        }
                    </section>
                    <div>
                        <p className={styles.price}>
                            <span>Total books: {cart.numberItems}</span>
                            <span>Total amount: <Price amount={cart.totalAmount}/></span>
                        </p>
                    </div>
                </div>
            }
        </>
    )
}