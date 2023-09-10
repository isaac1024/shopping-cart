'use client'

import styles from '@/components/header/cart.module.css';
import Image from "next/image";
import Link from "next/link";
import {useCartItemsContext} from "@/app/cart-items-context";

export default function Cart() {
    const {numberItems} = useCartItemsContext();

    return (
        <Link className={styles.cart} href="/checkout">
            <Image className={styles.cartLogo} src={'/shopping-cart.svg'} width={32} height={32}
               alt="Shopping cart icon"/>
            <span className={styles.cartNumberItems}>{numberItems}</span>
        </Link>
    );
}