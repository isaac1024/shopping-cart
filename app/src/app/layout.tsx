import './globals.css'
import type { Metadata } from 'next'
import Header from "@/components/header/header";
import {Nunito_Sans} from 'next/font/google'

const font = Nunito_Sans({
  subsets: ['latin'],
  variable: '--font-base',
  weight: "variable",
})

export const metadata: Metadata = {
  title: 'Shopping cart',
  description: 'Shopping cart technical assessment',
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="en">
      <body className={font.variable}>
        <Header/>
        <main>{children}</main>
      </body>
    </html>
  )
}
