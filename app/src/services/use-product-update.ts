import {ChangeEvent, useState} from "react";
import {useCartItemsContext} from "@/app/cart-items-context";

export function useProductUpdate(productId: string): [number, boolean, () => void, (event: ChangeEvent<HTMLInputElement>) => void] {
    const [quantity, setQuantity] = useState(0);
    const [loader, setLoader] = useState(false);
    const {cartItemsHandler} = useCartItemsContext();

    const quantityChange = (event: ChangeEvent<HTMLInputElement>): void => {
        const quantity: number = Number(event.target.value);
        setQuantity(quantity);
    }

    const updateQuantity = (): void => {
        setLoader(true)
        const body = {
            productId: productId,
            quantity: quantity,
        }
        const cartId = localStorage.getItem('cart_id')
        fetch('http://localhost:8000/carts/' + cartId + '/product_quantity', {
            method: 'POST',
            body: JSON.stringify(body),
        }).then(() => {
            cartItemsHandler(quantity);
            setLoader(false)
        });
    }

    return [quantity, loader, updateQuantity, quantityChange];
}