'use client'

import {usePayment} from "@/services/use-payment";
import styles from '@/components/order/payment.module.css';
import {PaymentElement} from "@stripe/react-stripe-js";

export default function Payment() {
    const handleSubmit = usePayment();
    return (
        <div className={styles.card}>
            <h2>Payment</h2>
            <form className={styles.form} onSubmit={handleSubmit}>
                <PaymentElement />
                <button className={styles.btn}>Pay</button>
            </form>
        </div>
    )
}