import {useEffect, useState} from "react";
import {useCartItemsContext} from "@/app/cart-items-context";

interface Cart {
    id: string,
    numberItems: number,
    totalAmount: number,
    productItems: ProductData[],
}

export interface ProductData {
    productId: string,
    title: string,
    unitPrice: number,
    quantity: number,
    totalPrice: number,
}

export function useCart(): Cart {
    const [cart, setCart] = useState(null);

    useEffect(() => {
        const cartId = localStorage.getItem('cart_id');
        if (!cartId) {
            return;
        }

        getCart(cartId).then((c) => setCart(c));
        console.log(cart)
    }, []);

    return cart;
}

async function getCart(cartId: string): Promise<Cart> {
    const response = await fetch('http://localhost:8000/carts/'+cartId);
    if (!response.ok) {
        throw new Error('Failed to fetch data');
    }

    return  response.json();
}