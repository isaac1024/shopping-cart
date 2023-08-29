import styles from '@/components/header/header.module.css';
import Cart from "@/components/header/cart";
import Link from "next/link";

export default function Header() {
    return (
        <header>
            <nav className={styles.header}>
                <Link href="/"><h1 className={styles.brand}>Shopping cart</h1></Link>
                <Cart/>
            </nav>
        </header>
    );
}