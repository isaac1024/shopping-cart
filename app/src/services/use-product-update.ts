import {ChangeEvent, useState} from "react";
import {useCartItemsContext} from "@/app/cart-items-context";

export function useProductUpdate(productId: string) {
    const [quantity, setQuantity] = useState(0);
    const {cartItemsHandler} = useCartItemsContext();

    const quantityChange = (event: ChangeEvent<HTMLInputElement>) => {
        const quantity: number = Number(event.target.value);
        setQuantity(quantity);
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
        
        if (response.ok) {
            cartItemsHandler(quantity);
        }
    }

    return [quantity, updateQuantity, quantityChange];
}