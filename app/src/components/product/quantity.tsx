'use client'

import styles from '@/components/product/quantity.module.css';
import {useProductUpdate} from "@/core/use-product-update";

export default function Quantity({productId}: {productId: string}) {
    const [quantity, updateQuantity, quantityChange] = useProductUpdate(productId);
    return (
        <>
            <input className={styles.input} type="number" min="0" size="3" value={quantity} onChange={quantityChange} />
            <button className={styles.btn} onClick={updateQuantity}>Add books</button>
        </>
    )
}