'use client'

import styles from '@/components/product/quantity.module.css';
import {useProductUpdate} from "@/services/use-product-update";
import Loader from "@/components/shared/loader";
import {FormEvent} from "react";

export default function Quantity({productId}: {productId: string}) {
    const [quantity, loader, updateQuantity, quantityChange] = useProductUpdate(productId);
    const submitHandler = (e: FormEvent) => {
        e.preventDefault();
        updateQuantity();
    }
    return (
        <form className={styles.form} onSubmit={submitHandler}>
            <input className={styles.input} type="number" min="0" value={quantity} onChange={quantityChange} />
            <button className={styles.btn} disabled={loader}>{loader ? <Loader/> : "Add books" }</button>
        </form>
    )
}