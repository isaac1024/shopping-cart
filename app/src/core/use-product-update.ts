import {ChangeEvent, useState} from "react";

export function useProductUpdate(productId: string) {
    const [quantity, setQuantity] = useState(0);

    const quantityChange = (event: ChangeEvent<HTMLInputElement>) => {
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

    return [quantity, updateQuantity, quantityChange];
}