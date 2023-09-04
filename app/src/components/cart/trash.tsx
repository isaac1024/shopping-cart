import styles from "@/components/cart/trash.module.css";
import Image from "next/image";
import {deleteProduct} from "@/services/delete-product";

export default function Trash({cartId, productId}: {cartId: string, productId: string}) {
    const deleteHandler = () => {
        deleteProduct(cartId, productId)
    }
    return (
        <button className={styles.trash}>
            <Image src={'/trash.svg'} width={16} height={16} alt="Trash product" onClick={deleteHandler}/>
        </button>
    )
}