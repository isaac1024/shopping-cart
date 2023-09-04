import styles from "@/components/order/delivery-data.module.css";

export default function DeliveryData() {
    return (
        <div className={styles.card}>
            <h2 className={styles.cardTitle}>Delivery data</h2>
            <form className={styles.form}>
                <label className={styles.label}>Name</label>
                <input className={styles.input}/>
                <label className={styles.label}>Address</label>
                <input className={styles.input}/>
                <button className={styles.btn}>Create order</button>
            </form>
        </div>
    );
}