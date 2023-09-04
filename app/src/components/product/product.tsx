import styles from "@/components/product/product.module.css";
import {ProductData} from "@/services/product";
import Image from "next/image";
import Price from "@/components/shared/price";
import Quantity from "@/components/product/quantity";

export default function Product({product}: {product: ProductData}) {
    const imageUrl = "http://api:8000" + product.photo;
    return (
        <article className={styles.card}>
            <h2 className={styles.cardTitle}>{product.title}</h2>
            <div className={styles.cardPhoto}><Image src={imageUrl} width={100} height={120} alt={product.title} /></div>
            <p className={styles.cardDescription}>{product.description}</p>
            <div className={styles.cardPrice}><Price amount={product.price}/><Quantity productId={product.id}/></div>
        </article>
    )
}