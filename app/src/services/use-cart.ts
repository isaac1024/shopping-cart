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
    photo: string
    unitPrice: number,
    quantity: number,
    totalPrice: number,
}

export function useCart(): [Cart|null, (cartId: string, productId: string) => void] {
    const [cart, setCart] = useState<Cart|null>(null);
    const {cartItemsHandler} = useCartItemsContext();

    useEffect(() => {
        const cartId = localStorage.getItem('cart_id');
        if (!cartId) {
            return;
        }

        getCart(cartId).then((c) => setCart(c));
    }, []);

    const deleteHandler = (cartId: string, productId: string) => {
        fetch('http://localhost:8000/carts/'+cartId+'/product_delete', {
            method: "POST",
            body: JSON.stringify({productId: productId}),
        }).then((response) => {
            getCart(cartId).then((c) => {
                setCart(c);
                cartItemsHandler(c.numberItems);
            });
        });
    }

    return [cart, deleteHandler];
}

async function getCart(cartId: string): Promise<Cart> {
    const response = await fetch('http://localhost:8000/carts/'+cartId);
    if (!response.ok) {
        throw new Error('Failed to fetch data');
    }

    return  response.json();
}