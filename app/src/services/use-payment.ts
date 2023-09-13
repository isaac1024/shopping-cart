import {FormEvent} from "react";
import {useElements, useStripe} from "@stripe/react-stripe-js";

export function usePayment() {
    const stripe = useStripe();
    const elements = useElements();

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();

        stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: "http://localhost:3000",
            },
        });
    }

    return handleSubmit;
}