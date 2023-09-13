'use client'

import Payment from "@/components/order/payment";
import {Elements} from "@stripe/react-stripe-js";
import {useStripe} from "@/services/use-stripe";

export default function PaymentPage() {
    const [stripe, secret] = useStripe();
    return (
        <>
            {
                secret && stripe && (
                    <Elements stripe={stripe} options={{clientSecret: secret}}>
                        <Payment />
                    </Elements>
                )
            }
        </>
    );
}