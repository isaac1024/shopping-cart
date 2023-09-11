import {ChangeEvent, FormEvent, useState} from "react";
import {useRouter} from "next/navigation";

export function useCreateOrder(): [string, string, boolean, (event: ChangeEvent<HTMLInputElement>) => void, (event: ChangeEvent<HTMLInputElement>) => void, (e: FormEvent) => void] {
    const [name, setName] = useState('');
    const [address, setAddress] = useState('');
    const [loader, setLoader] = useState(false);
    const router = useRouter();

    const nameChange = (event: ChangeEvent<HTMLInputElement>): void => {
        setName(event.target.value);
    }

    const addressChange = (event: ChangeEvent<HTMLInputElement>): void => {
        setAddress(event.target.value);
    }

    const createOrder = (e: FormEvent): void => {
        e.preventDefault();
        setLoader(true)
        const cartId = localStorage.getItem('cart_id');
        const body = {
            cartId: cartId,
            name: name,
            address: address,
        }
        fetch('http://localhost:8000/orders', {
            method: 'POST',
            body: JSON.stringify(body),
        }).then((response) => {
            return response.json();
        }).then(({id}: {id: string}) => {
            setLoader(false);
            router.push('/payment/' + id);
        });
    }

    return [name, address, loader, nameChange, addressChange, createOrder];
}