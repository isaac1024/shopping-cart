'use client'

import styles from "@/components/order/delivery-data.module.css";
import {useCreateOrder} from "@/services/use-create-order";
import Loader from "@/components/shared/loader";

export default function DeliveryData() {
    const [name, address, loader, nameChange, addressChange, createOrder] = useCreateOrder();
    return (
        <div className={styles.card}>
            <h2 className={styles.cardTitle}>Delivery data</h2>
            <form className={styles.form} onSubmit={createOrder}>
                <label className={styles.label}>Name</label>
                <input className={styles.input} type="text" value={name} onChange={nameChange}/>
                <label className={styles.label}>Address</label>
                <input className={styles.input} type="text" value={address} onChange={addressChange}/>
                <button className={styles.btn}>{loader ? <Loader/> : "Create order"}</button>
            </form>
        </div>
    );
}

