'use client'

import styles from '@/components/product/quantity.module.css';
import {useState} from "react";

export default function Quantity({productId}: {productId: string}) {
    const [quantity, setQuantity] = useState(0);

    const quantityChange = (event) => {
        const newQuantity: number = Number(event.target.value);
        setQuantity(newQuantity);
    }

    const updateQuantity = async () => {
        const body = {
            productId: productId,
            quantity: quantity,
        }
        const cartId = localStorage.getItem('cart_id')
        const response = await fetch('http://localhost:8000/carts/' + cartId + '/product_quantity', {
            method: 'POST',
            body: JSON.stringify(body),
        });
    }
    return (
        <>
            <input className={styles.input} type="number" min="0" size="3" value={quantity} onChange={quantityChange} />
            <button className={styles.btn} onClick={updateQuantity}>Add books</button>
        </>
    )
}