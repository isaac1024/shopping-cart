import styles from "@/components/product/product-collection.module.css";
import Product from "@/components/product/product";
import {getAllProducts} from "@/core/product";

export default async function ProductCollection() {
    const products = await getAllProducts();
    return (
        <section className={styles.productCollection}>
            {
                products.map((product) => <Product key={product.id} product={product} />)
            }
        </section>
    )
}