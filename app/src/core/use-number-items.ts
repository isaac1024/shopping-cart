import {useEffect, useState} from "react";

interface CartId {
    id: string,
}

interface Cart {
    id: string,
    numberItems: number,
}

export function useNumberItems(): number {
    const [numberItems, setNumberItems] = useState(null);

    useEffect(() => {
        getCart().then((c) => setNumberItems(c.numberItems));
    }, []);

    return numberItems;
}

async function getCart(): Promise<Cart> {
    const cartId = await getCartId();
    const response = await fetch('http://localhost:8000/carts/'+cartId+'/items');
    if (!response.ok) {
        throw new Error('Failed to fetch data');
    }

    return  response.json();
}

async function getCartId(): Promise<string> {
    const cartId = localStorage.getItem('cart_id')
    if (cartId) {
        return cartId;
    }

    const cartIdData = await createCart();
    localStorage.setItem('cart_id', cartIdData.id)
    return cartIdData.id;
}

async function createCart(): Promise<CartId> {
    const response = await fetch('http://localhost:8000/carts', {
        'method': 'POST',
    });
    if (!response.ok) {
        throw new Error('Failed to fetch data');
    }

    return  response.json();
}