'use client'

import styles from "@/components/cart/cart.module.css"
import {useCart} from "@/core/use-cart";
import Product from "@/components/cart/product";
import Price from "@/components/shared/price";

export default function Cart() {
    const cart = useCart();
    return (
        <>
            {
                cart &&
                <div>
                    <section className={styles.productCollection}>{
                        cart && cart.productItems.map((p) => <Product key={p.productId} product={p}/>)
                    }</section>
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