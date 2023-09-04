import './globals.css'
import type { Metadata } from 'next'
import Header from "@/components/header/header";
import {Nunito_Sans} from 'next/font/google'
import {CartItemsContextProvider} from "@/app/cart-items-context";

const font = Nunito_Sans({
  subsets: ['latin'],
  variable: '--font-base',
  weight: "variable",
})

export const metadata: Metadata = {
  title: 'Shopping cart',
  description: 'Shopping cart technical assessment',
}

export default async function RootLayout({children}: { children: React.ReactNode }) {
  return (
      <html lang="en">
      <body className={font.variable}>
      <CartItemsContextProvider>
        <Header/>
        <main>{children}</main>
      </CartItemsContextProvider>
      </body>
      </html>
  )
}
