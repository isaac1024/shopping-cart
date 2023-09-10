import styles from "@/components/cart/trash.module.css";
import Image from "next/image";
import {FormEvent} from "react";

export default function Trash({trashHandler}: {trashHandler: () => void}) {
    const submitHandler = (e: FormEvent) => {
        e.preventDefault()
        trashHandler()
    }
    return (
        <form onSubmit={submitHandler}>
            <button className={styles.trash}>
                <Image src={'/trash.svg'} width={16} height={16} alt="Trash product"/>
            </button>
        </form>
    )
}