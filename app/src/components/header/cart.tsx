'use client'

import styles from '@/components/header/cart.module.css';
import Image from "next/image";
import Link from "next/link";
import {useCartItemsContext} from "@/app/cart-items-context";
import {useEffect} from "react";
import {getCart} from "@/services/cart-items";

export default function Cart() {
    const {numberItems, cartItemsHandler} = useCartItemsContext();
    useEffect(() => {
        getCart().then((cartItems) => {
            cartItemsHandler(cartItems.numberItems)
        });
    }, [])
    return (
        <Link className={styles.cart} href="/checkout">
            <Image className={styles.cartLogo} src={'/shopping-cart.svg'} width={32} height={32}
               alt="Shopping cart icon"/>
            <span className={styles.cartNumberItems}>{numberItems}</span>
        </Link>
    );
}