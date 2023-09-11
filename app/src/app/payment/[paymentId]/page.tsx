'use client'

import {useParams} from "next/navigation";
import {useEffect, useState} from "react";
import {loadStripe} from "@stripe/stripe-js";
import {Elements, PaymentElement} from "@stripe/react-stripe-js";

export default function Payment() {
    const params = useParams();
    const [secret, setSecret] = useState('');
    const [stripe, setStripe] = useState(null);
    const stripeKey = 'pk_test_51NpFv4E7UVPvnb6MDPZxKoAmRWz1T7axOwf9fkXjp8sqNqI42YToAxgnFxV5HP2eNSYO5Uhi1yt9VZMWjJr3YyfQ00BVjLZlcg';
    useEffect(() => {
        fetch('http://localhost:8000/payments/'+params.paymentId)
            .then((response) => {
                return response.json();
            }).then(({paymentSecret}) => {
                setSecret(paymentSecret)
                setStripe(loadStripe(stripeKey))
        })
    }, [])
    return (
        <>
            <h2>Payment</h2>
            {secret && stripe && (
                <Elements stripe={stripe} options={{clientSecret: secret}}>
                    <form>
                        <PaymentElement/>
                        <button>Pay</button>
                    </form>
                </Elements>
            )}
        </>
    )
}