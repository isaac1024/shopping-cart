import styles from "@/components/cart/product.module.css";
import {ProductData} from "@/services/use-cart";
import Price from "@/components/shared/price";
import Trash from "@/components/cart/trash";
import Image from "next/image";

export default function Product({deleteHandler, cartId, product}: {deleteHandler: () => void, cartId: string, product: ProductData}) {
    const imageUrl = "http://api:8000" + product.photo;
    return (
        <article className={styles.card}>
            <div className={styles.cardTitle}>
                <Image src={imageUrl} width={70} height={84} alt={product.title} />
                <h2>{product.title}</h2>
            </div>
            <div className={styles.cardPrice}>
                <span>Number of books: {product.quantity}</span>
                <span>Unit price: <Price amount={product.unitPrice} /></span>
                <Trash trashHandler={deleteHandler}/>
            </div>
        </article>
    )
}