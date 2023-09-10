'use client'

import React, {createContext, useContext, useEffect, useState} from "react";
import {getCart} from "@/services/cart-items";

const CartItemsContext = createContext({
    numberItems: 0,
    cartItemsHandler: (numberItems: number) => {},
})

export function CartItemsContextProvider({children}: {children: React.ReactNode}) {
    const [numberItems, setNumberItems] = useState(0);

    useEffect(() => {
        getCart().then((cartItems) => setNumberItems(cartItems.numberItems));
    }, [])

    const cartItemsHandler = () => {
        getCart().then((cartItems) => setNumberItems(cartItems.numberItems));
    };

    return (
        <CartItemsContext.Provider value={{numberItems, cartItemsHandler}}>{ children }</CartItemsContext.Provider>
    );
}

export const useCartItemsContext = () => useContext(CartItemsContext);