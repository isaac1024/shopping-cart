import styles from "@/components/cart/product.module.css";
import {ProductData} from "@/core/use-cart";
import Price from "@/components/shared/price";
import Trash from "@/components/cart/trash";

export default function Product({cartId, product}: {cartId: string, product: ProductData}) {
    return (
        <article className={styles.card}>
            <h2 className={styles.cardTitle}>{product.title}</h2>
            <p className={styles.cardPrice}>
                <span>Number of books: {product.quantity}</span>
                <span>Unit price: <Price amount={product.unitPrice} /></span>
                <Trash productId={product.productId} cartId={cartId}/>
            </p>
        </article>
    )
}