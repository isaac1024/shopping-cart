'use client'

import React, {createContext, useContext, useState} from "react";

const CartItemsContext = createContext({
    numberItems: 0,
    cartItemsHandler: (numberItems: number) => {},
})

export function CartItemsContextProvider({children}: {children: React.ReactNode}) {
    const [numberItems, setNumberItems] = useState(0);

    const cartItemsHandler = (quantity: number) => {
        setNumberItems(numberItems + quantity)
    };

    return (
        <CartItemsContext.Provider value={{numberItems, cartItemsHandler}}>{ children }</CartItemsContext.Provider>
    );
}

export const useCartItemsContext = () => useContext(CartItemsContext);