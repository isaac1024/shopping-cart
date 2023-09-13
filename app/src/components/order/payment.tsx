'use client'

import {Elements, PaymentElement} from "@stripe/react-stripe-js";
import {usePayment} from "@/services/use-payment";
import styles from '@/components/order/payment.module.css';

export default function Payment() {
    const [stripe, secret] = usePayment();
    return (
        <div className={styles.card}>
            <h2>Payment</h2>
            {secret && stripe && (
                <Elements stripe={stripe} options={{clientSecret: secret}}>
                    <form className={styles.form}>
                        <PaymentElement />
                        <button className={styles.btn}>Pay</button>
                    </form>
                </Elements>
            )}
        </div>
    )
}