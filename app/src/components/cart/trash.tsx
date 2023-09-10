import styles from "@/components/cart/trash.module.css";
import Image from "next/image";

export default function Trash({trashHandler}: {trashHandler: () => void}) {
    return (
        <button className={styles.trash}>
            <Image src={'/trash.svg'} width={16} height={16} alt="Trash product" onClick={trashHandler}/>
        </button>
    )
}