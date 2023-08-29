import styles from '@/components/shared/price.module.css'
export default function Price({amount}: {amount: number}) {
    const price = (amount / 100).toLocaleString("es-ES", {style:"currency", currency:"EUR"});
    return (<span className={styles.price}>{price}</span>)
}