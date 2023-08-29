'use client'

import styles from '@/components/header/cart.module.css';
import Image from "next/image";
import {useNumberItems} from "@/core/use-number-items";
import Link from "next/link";

export default function Cart() {
    const numberItems = useNumberItems();
    return (
        <Link className={styles.cart} href="/checkout">
            <Image className={styles.cartLogo} src={'/shopping-cart.svg'} width={32} height={32}
               alt="Shopping cart icon"/>
            <span className={styles.cartNumberItems}>{numberItems}</span>
        </Link>
    );
}